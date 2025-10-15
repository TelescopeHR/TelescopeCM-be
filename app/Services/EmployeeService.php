<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Support\HttpCode;
use Illuminate\Http\Request;
use App\Models\EmployeeProfile;
use App\Support\GeneralException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\EmployeeResource;
use App\Repository\EmployeeRepository;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EmployeeService extends BaseService
{
    use GeneralException;

    protected $model;

    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly PhoneNumberService $phoneNumberService
    )
    {
    }

    public function create(array $data): User
    {
        try {
            DB::transaction(function () use (&$employee, $data) {
                $employee_id = 'EMP'.rand(000000, 999999);
                
                $employee = $this->employeeRepository->create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'middle_name' => $data['middle_name'] ?? null,
                    'gender' => $data['gender'],
                    'birthday' => $data['birthday'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'zip' => $data['zip'],
                    'phone' => $data['login_phone'],
                    'avatar' => $data['profile_picture'] ?? null,
                ]);
                $employee->roles()->attach(Role::ROLE_ID_CARE_WORKER);
                
                $employee->employeeProfile()->create([
                    'employee_status' => $data['status'],
                    'social_security' => $data['social_security'],
                    'manual_employee_id' => $employee_id,
                    'hire_date' => $data['hire_date'],
                    'application_date' => $data['application_date'] ?? null,
                    'orientation_date' => $data['orientation_date'] ?? null,
                    'signed_job_description_date' => $data['signed_job_description_date'] ?? null,
                    'signed_policy_procedure_date' => $data['signed_policy_procedure_date'] ?? null,
                    'evaluated_assigned_date' => $data['evaluated_assigned_date'] ?? null,
                    'last_evaluation_date' => $data['last_evaluation_date'] ?? null,
                    'termination_date' => $data['termination_date'] ?? null,
                    'number_of_references' => $data['number_of_references'] ?? null,
                ]);

                $company_id = Auth::user()->company_id;

                if (isset($data['company_id'])) {
                    $company_id = $data['company_id'];
                }

                $employee->company()->associate(Company::where('uuid', $company_id)->first());
                $employee->save();

                //save phone numbers
                $this->phoneNumberService->create($employee, $data);

            });
        } catch (\Exception $e) {
            Log::error("Error creating employee: {$e->getMessage()}");
            $this->exception('Failed to create employee. Please try again.', HttpCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $employee->fresh(['employeeProfile', 'phoneNumbers', 'company']);
    }

    public function get(array $filters = [], bool $paginate = true, int $pageNumber = 1, ?int $perPage=null)
    {
        $user = Auth::user();
        $company_id = $user->hasRole(Role::ROLE_COMPANY_ADMIN) ? $user->company_id : null;

        $query = $this->employeeRepository->getAll($filters, $company_id);

        return $paginate ? $this->paginate($query, function (Model $user) {
            return new EmployeeResource($user);
        }, $pageNumber, $perPage ?? config('env.no_of_paginated_record')) : $query->get();
    }

    public function getStatistics(): array
    {
        $totalEmployees = $this->employeeRepository->getStatistics();

        $statusCounts = EmployeeProfile::select('employee_status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('employee_status')
            ->pluck('count', 'employee_status')
            ->toArray();

        $statusCountsFormatted = [];
        foreach (EmployeeProfile::STATUSES as $key => $label) {
            $label = str_replace(' ', '_', strtolower($label));
            $statusCountsFormatted[$label] = $statusCounts[$key] ?? 0;
        }

        return [
            'total' => $totalEmployees,
            ...$statusCountsFormatted,
        ];
    }

    public function findById(int|string $id, array $relations = []): ?User
    {
        $column = is_int($id) ? 'id' : 'uuid';
        return $this->employeeRepository->get($column, $id)
            ->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))
            ->with($relations)
            ->first();
    }

    public function update(User $employee, array $data): User
    {
        try {

            DB::transaction(function () use (&$employee, $data) {
                if ($data['type'] === 'biodata') {
                    $this->updateBiodata($employee, $data);
                }

                if ($data['type'] === 'address') {
                    $this->updateAddress($employee, $data);
                }

                if($data['type'] === 'background') {
                    $this->updateBackground($employee, $data);
                }
            });
        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . $e->getMessage());
            $this->exception('Failed to update employee. Please try again.', HttpCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $employee->fresh(['employeeProfile', 'phoneNumbers', 'company']);
    }

    public function delete(User $employee)
    {
        try{

            //delete employee profile
            $employee->employeeProfile()->delete();

            //delete phone numbers
            $employee->phoneNumbers()->delete();

            //delete employee
            $employee->delete();
            
        } catch (\Exception $e) {
            Log::error('Error deleting employee: ' . $e->getMessage());
            $this->exception('Failed to delete employee. Please try again.');
        }
    }

    private function updateBiodata(User $employee, array $data)
    {
        $employee->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'gender' => $data['gender'],
            'birth_date' => $data['birth_date'],
            'email' => $data['email'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : $employee->password,
        ]);

        $employee->employeeProfile->update([
            'employee_status' => $data['status'],
            'social_security' => $data['social_security']
        ]);

        if (isset($data['company_id'])) {
            $employee->company()->associate(Company::where('uuid', $data['company_id'])->first());
            $employee->save();
        }
    }

    private function updateAddress(User $employee, array $data)
    {
        $employee->update([
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
        ]);
    }

    private function updateBackground(User $employee, array $data)
    {
        $employee->employeeProfile->update([
            'hire_date' => $data['hire_date'],
            'application_date' => $data['application_date'],
            'orientation_date' => $data['orientation_date'],
            'signed_job_description_date' => $data['signed_job_description_date'],
            'signed_policy_procedure_date' => $data['signed_policy_procedure_date'],
            'evaluated_assigned_date' => $data['evaluated_assigned_date'],
            'last_evaluation_date' => $data['last_evaluation_date'],
            'termination_date' => $data['termination_date'],
            'number_of_references' => $data['number_of_references'],
        ]);
    }
}
