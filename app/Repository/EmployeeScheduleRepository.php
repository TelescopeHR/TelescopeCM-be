<?php

namespace App\Repository;

use App\Models\Role;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EmployeeScheduleRepository extends BaseRepository
{
     /**
     * Configure the Model
     **/
    public function model()
    {
        return Schedule::class;
    }

    public function getAll(array $filters, $company_id = null): Collection
    {
        $filterByCompany = !empty($company_id);

        return $this->model->when($filterByCompany, function ($query) use ($company_id) {
                $query->whereHas('careWorker', function ($q) use ($company_id) {
                    $q->where('company_id', $company_id);
                });
            })->latest()->get();
    }
}