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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EmployeeService extends BaseService
{
    use GeneralException;

    public function __construct(private readonly PhoneNumberService $phoneNumberService)
    {
        
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function create(array $data): User
    {
        try {
            DB::transaction(function () use (&$employee, $data) {
                $employee = User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'middle_name' => $data['middle_name'] ?? null,
                    'gender' => $data['gender'],
                    'birth_date' => $data['birth_date'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'zip' => $data['zip'],
                    'phone' => $data['login_phone'],
                ]);
                $employee->roles()->attach(Role::ROLE_ID_CARE_WORKER);
                
                $employee->employeeProfile()->create([
                    'employee_status' => $data['status'],
                    'social_security' => $data['social_security'],
                    'manual_employee_id' => $data['employee_id'] ?? null,
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

                if (isset($data['company'])) {
                    $employee->company()->associate(Company::where('name', $data['company'])->first());
                    $employee->save();
                }

                //save phone numbers
                $this->phoneNumberService->create($employee, $data);

            });
        } catch (\Exception $e) {
            Log::error("Error creating employee: {$e->getMessage()}");
            $this->exception('Failed to create employee. Please try again.', HttpCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $employee->fresh(['employeeProfile', 'phoneNumbers', 'company']);
    }

    public function get(array $filters = [], $paginate = true, $pageNumber = 1)
    {
        $query = $this->model->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))
            ->when(!empty($filters['name']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->where('first_name', 'like', '%' . $filters['name'] . '%')
                        ->orWhere('last_name', 'like', '%' . $filters['name'] . '%');
                });
            })
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $q->whereHas('employeeProfile', function ($q) use ($filters) {
                    $q->whereIn('employee_status', $filters['status']);
                });
            })->orderBy('created_at');

        return $paginate ? $this->paginate($query, function (Model $user) {
            return new EmployeeResource($user);
        }, $pageNumber, config('env.no_of_paginated_record')) : $query->get();
    }

    public function getStatistics(): array
    {
        $totalEmployees = $this->model->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))->count();

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

    public function findById(int $id, array $relations = []): ?User
    {
        return $this->model
            ->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))
            ->where('id', $id)
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
            $this->exception('Failed to update employee. Please try again.');
        }

        return $employee->fresh(['employeeProfile', 'phoneNumbers', 'company']);
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
            'social_security' => $data['social_security'],
            'manual_employee_id' => $data['employee_id'],
        ]);

        if (isset($data['company'])) {
            $employee->company()->associate(Company::where('name', $data['company'])->first());
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
