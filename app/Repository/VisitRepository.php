<?php

namespace App\Repository;

use App\Models\Schedule;
use App\Models\Visit;

class VisitRepository extends BaseRepository
{
     /**
     * Configure the Model
     **/
    public function model()
    {
        return Visit::class;
    }

    public function getBy(string $field, string $value, array $filters = [])
    {
        return $this->model->where($field, $value)
        ->when((!empty($filters['date_from'] && !empty($filters['date_to']))), function ($q) use ($filters) {
            $q->whereDate('date_at', '>=', $filters['date_from'])
            ->whereDate('date_at', '<=', $filters['date_to']);
        })->latest();
    }

    public function getAll(array $filters = [], $company_id = null)
    {
        $filterByCompany = !empty($company_id);

        return $this->model->when($filterByCompany, function ($query) use ($company_id) {
            $query->whereHas('careWorker', function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            });
        })
        ->when(!empty($filters['employee_id']), function ($q) use ($filters) {
            $q->where('care_worker_id', $filters['employee_id']);
        })
        ->when(!empty($filters['client_id']), function ($q) use ($filters) {
            $q->where('client_id', $filters['client_id']);
        })
        ->when((!empty($filters['date_from'] && !empty($filters['date_to']))), function ($q) use ($filters) {
            $q->whereDate('date_at', '>=', $filters['date_from'])
            ->whereDate('date_at', '<=', $filters['date_to']);
        })->orderBy('updated_at', 'desc');
    }

    public function createOrUpdate(array $data): Visit
    {
        return $this->model->updateOrCreate(
            [
                'date_at' => $data['date_at'],
                'schedule_id' => $data['schedule_id'],
            ],
            $data
        );
    }
}