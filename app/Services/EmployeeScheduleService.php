<?php

namespace App\Services;

use App\Support\GeneralException;
use Illuminate\Support\Facades\DB;
use App\Repository\EmployeeScheduleRepository;

class EmployeeScheduleService extends BaseService
{
    use GeneralException;

    public function __construct(
        private readonly EmployeeScheduleRepository $employeeScheduleRepository
    ){
        
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $scheduleData = $data;
            $alldayEvent = $data['allDayEvent'] ?? null;
            $selectedDays = isset($data['selected_days']) && !empty($data['selected_days'])
                ? array_map('intval', explode(',', $data['selected_days']))
                : [];
        
            unset($scheduleData['week_time_from']);
            unset($scheduleData['week_time_to']);
            unset($scheduleData['selected_days']);
            
            //if all day event is not null then create and array of selected days 1 to 7
            if ($alldayEvent) {
                $selectedDays = range(1, 7);
            } 
            
            $schedule = $this->employeeScheduleRepository->create($scheduleData);
          
            foreach ($selectedDays as $day) {
                ScheduleTime::create([
                    'schedule_id' => $schedule->id,
                    'day_of_week' => $day,
                    'time_from' => $data['week_time_from'],
                    'time_to' => $data['week_time_to'],
                    'created_by' => auth()->id(),
                ]);
            }
            // Create visit records for each scheduled day
            $this->createVisitsForSchedule($schedule, $selectedDays, $data);

            return $schedule;
        });
    }
}