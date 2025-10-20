<?php

namespace App\Repository;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ClientRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

     public function getAll(array $filters, array $select=[], $company_id = null): Builder
    {
        $filterByCompany = !empty($company_id);

        return $this->model->whereHas('roles', fn($q) => $q->where('role_id', Role::ROLE_ID_PATIENT))
            ->when(!empty($select), function($q) use($select){
                $q->select($select);
            })
            ->when($filterByCompany, function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            })
            ->when(!empty($filters['name']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->where('first_name', 'like', '%' . $filters['name'] . '%')
                        ->orWhere('last_name', 'like', '%' . $filters['name'] . '%');
                });
            })
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $q->whereHas('clientProfile', function ($q) use ($filters) {
                    $q->where('client_status', $filters['status']);
                });
            })->latest();
    }

}