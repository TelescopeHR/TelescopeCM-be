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