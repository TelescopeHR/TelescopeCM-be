<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
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
use App\Repository\ClientRepository;
use App\Repository\EmployeeRepository;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ClientService extends BaseService
{
    use GeneralException;

    protected $model;

    public function __construct(
        private readonly ClientRepository $clientRepository,
    )
    {
    }

    // public function create(array $data): ?User
    // {

    // }

    public function findOne(string $clientId): ?User
    {
        return $this->clientRepository->findOne($clientId) ?? $this->exception('Client not found.', HttpCode::HTTP_NOT_FOUND);
    }

    public function get(array $filters = [], array $select = [], bool $paginate = true, int $pageNumber = 1, ?int $perPage=null)
    {
        $user = Auth::user();
        $company_id = $user->hasRole(Role::ROLE_COMPANY_ADMIN) ? $user->company_id : null;

        $query = $this->clientRepository->getAll($filters, $select, $company_id);

        return $paginate ? $this->paginate($query, function (Model $client) {
            return new ClientResource($client);
        }, $pageNumber, $perPage ?? config('env.no_of_paginated_record')) : $query->get();
    }
}