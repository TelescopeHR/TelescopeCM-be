<?php

namespace App\Services;

use App\Models\User;
use App\Support\GeneralException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Repository\EmployeeScheduleRepository;
use App\Http\Resources\EmployeeScheduleResource;
use App\Http\Resources\ScheduleVisitResource;
use App\Models\Schedule;
use App\Repository\VisitRepository;

class VisitService extends BaseService
{
    use GeneralException;

    public function __construct(
        private readonly VisitRepository $visitRepository
    ){
        
    }

    public function create(array $data)
    {
    }

    public function getByScheduleId(Schedule $schedule, array $filters = [], bool $paginate = true, int $pageNumber = 1, ?int $perPage=null)
    {
        $query = $this->visitRepository->getBy('schedule_id', $schedule->id, $filters);

        return $paginate ? $this->paginate($query->latest(), function (Model $visit) {
            return new ScheduleVisitResource($visit);
        }, $pageNumber, $perPage ?? config('env.no_of_paginated_record')) : $query->latest()->get();
    }
    
}