<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Support\GeneralException;
use Illuminate\Support\Facades\DB;
use App\Repository\VisitRepository;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ScheduleVisitResource;
use App\Repository\EmployeeScheduleRepository;
use App\Http\Resources\EmployeeScheduleResource;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class VisitService extends BaseService
{
    use GeneralException;

    public function __construct(
        private readonly VisitRepository $visitRepository
    ){
        
    }

    public function create(Schedule $schedule, array $data): Visit
    {
        $timeFrom = $schedule->times->first()?->time_from;
        $timeOut = $schedule->times->first()?->time_to;

        return $this->visitRepository->create([
            'client_id' => $schedule->patient_id,
            'care_worker_id' => $schedule?->care_worker_id,
            'schedule_id' => $schedule->id,
            'type' => $data['visit_type'] ?? null,
            'pay_rate' => $schedule?->rate ?? 0,
            'date_at' => $data['date'],
            'time_in' => $timeFrom,
            'time_out' => $timeOut,
            'verified_in' => $data['verified_in'] ?? null, 
            'verified_out' => $data['verified_out'] ?? null, 
            'created_by' => Auth::id(),
        ]);
    }

    public function createForSchedule(Schedule $schedule, array $selectedDays, array $data)
    {
        if (empty($selectedDays) || !isset($data['date_from']) || !isset($data['date_to'])) {
            return;
        }

        $startDate = Carbon::parse($data['date_from']);
        $endDate = Carbon::parse($data['date_to']);
        $timeFrom = Carbon::parse($data['time_from'])->format('H:i:s') ?? '08:00:00';
        $timeOut = Carbon::parse($data['time_to'])->format('H:i:s') ?? '18:00:00';

        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            // Carbon uses 0=Sunday, 1=Monday, etc., but our days are 1=Sunday, 2=Monday, etc.
            $days = [
                0 => 1, // Sunday
                1 => 2, // Monday
                2 => 3, // Tuesday
                3 => 4, // Wednesday
                4 => 5, // Thursday
                5 => 6, // Friday
                6 => 7, // Saturday
            ];

            $dayOfWeek = $days[$currentDate->dayOfWeek];
           
            if (in_array($dayOfWeek, $selectedDays)) {
                $this->visitRepository->create([
                    'client_id' => $schedule->patient_id,
                    'care_worker_id' => $schedule->care_worker_id,
                    'schedule_id' => $schedule->id,
                    'type' => "Employee" ?? null,
                    'pay_rate' => $schedule->rate ?? 0,
                    'date_at' => $currentDate->format('Y-m-d'),
                    'time_in' => $timeFrom,
                    'time_out' => $timeOut,
                    'verified_in' => null, // Will be set by mobile app
                    'verified_out' => null, // Will be set by mobile app
                    'created_by' => Auth::id(),
                ]);
            }
            
            $currentDate->addDay();
        }
    }

    public function getByScheduleId(Schedule $schedule, array $filters = [], bool $paginate = true, int $pageNumber = 1, ?int $perPage=null)
    {
        $query = $this->visitRepository->getBy('schedule_id', $schedule->id, $filters);

        return $paginate ? $this->paginate($query->latest(), function (Model $visit) {
            return new ScheduleVisitResource($visit);
        }, $pageNumber, $perPage ?? config('env.no_of_paginated_record')) : $query->latest()->get();
    }
    
}