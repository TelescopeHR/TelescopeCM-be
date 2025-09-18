<?php

namespace App\Services;

use App\Http\Resources\EmployeeResource;
use App\Models\Role;
use App\Models\User;
use App\Support\HttpCode;
use Illuminate\Http\Request;
use App\Models\EmployeeProfile;
use App\Support\GeneralException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EmployeeService extends Service
{
    use GeneralException;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function get(array $filters = [], $paginate = true, $pageNumber=1)
    {
        $query = User::whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_CARE_WORKER))
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
}