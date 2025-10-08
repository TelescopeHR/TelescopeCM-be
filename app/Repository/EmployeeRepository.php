<?php

namespace App\Repository;

use App\Models\Role;
use App\Models\User;
use App\Models\EmployeeProfile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EmployeeRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function findByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function getAll(array $filters, $company_id = null): Builder
    {
        $filterByCompany = !empty($company_id);

        return $this->model->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))
            ->when($filterByCompany, function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            })->when(!empty($filters['name']), function ($q) use ($filters) {
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
    }

    public function getStatistics()
    {
        return $this->model->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))->count();
    }
}