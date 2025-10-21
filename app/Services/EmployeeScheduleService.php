<?php

namespace App\Services;

use App\Models\User;
use App\Models\Schedule;
use App\Models\ScheduleTime;
use App\Models\ScheduleType;
use App\Support\GeneralException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Repository\EmployeeScheduleRepository;
use App\Http\Resources\EmployeeScheduleResource;

class EmployeeScheduleService extends BaseService
{
    use GeneralException;

    public function __construct(
        private readonly EmployeeScheduleRepository $employeeScheduleRepository,
        private readonly VisitService $visitService
    ) {}

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $alldayEvent = $data['all_day_event'] ?? false;
            $days = [
                'Sunday' => 1,
                'Monday' => 2,
                'Tuesday' => 3,
                'Wednesday' => 4,
                'Thursday' => 5,
                'Friday' => 6,
                'Saturday' => 7
            ];

            $selectedDays = [];
            if (isset($data['selected_days']) && is_array($data['selected_days'])) {
                foreach ($data['selected_days'] as $dayName) {
                    if (isset($days[$dayName])) {
                        $selectedDays[] = $days[$dayName];
                    }
                }
            }

            // //if all day event is not null then create an array of selected days 1 to 7
            // if ($alldayEvent) {
            //     $selectedDays = range(1, 7);
            // }

            $schedule = $this->employeeScheduleRepository->create([
                'patient_id' => $data['patient_id'],
                'care_worker_id' => $data['care_worker_id'],
                'care_plan_id' => $data['care_plan_id'],
                'type_id' => $data['type_id'],
                'date_from' => $data['date_from'],
                'date_to' => $data['date_to'],
                'rate' => $data['rate'],
                'status' => $data['status'],
                'created_by' => Auth::id(),
            ]);

            foreach ($selectedDays as $day) {
                ScheduleTime::create([
                    'schedule_id' => $schedule->id,
                    'day_of_week' => $day,
                    'time_from' => $data['time_from'],
                    'time_to' => $data['time_to'],
                    'created_by' => Auth::id(),
                ]);
            }

            // Create visit records for each scheduled day
            $this->visitService->createForSchedule($schedule, $selectedDays, $data);

            return $schedule;
        });
    }

    public function update(Schedule $schedule, array $data)
    {
        return DB::transaction(function () use (&$schedule, $data) {
            $alldayEvent = $data['all_day_event'] ?? false;
            $days = [
                'Sunday' => 1,
                'Monday' => 2,
                'Tuesday' => 3,
                'Wednesday' => 4,
                'Thursday' => 5,
                'Friday' => 6,
                'Saturday' => 7
            ];

            $selectedDays = [];
            if (isset($data['selected_days']) && is_array($data['selected_days'])) {
                foreach ($data['selected_days'] as $dayName) {
                    if (isset($days[$dayName])) {
                        $selectedDays[] = $days[$dayName];
                    }
                }
            }

            // //if all day event is not null then create an array of selected days 1 to 7
            // if ($alldayEvent) {
            //     $selectedDays = range(1, 7);
            // }

            $schedule = $this->employeeScheduleRepository->update([
                'patient_id' => $data['patient_id'],
                'care_worker_id' => $data['care_worker_id'],
                'care_plan_id' => $data['care_plan_id'],
                'type_id' => $data['type_id'],
                'date_from' => $data['date_from'],
                'date_to' => $data['date_to'],
                'rate' => $data['rate'],
                'status' => $data['status'],
            ], $schedule->id);

            // Delete existing schedule times
            ScheduleTime::where('schedule_id', $schedule->id)->delete();

            // Delete existing visits for this schedule (they will be recreated)
            $schedule->visits()->delete();

            foreach ($selectedDays as $day) {
                ScheduleTime::create([
                    'schedule_id' => $schedule->id,
                    'day_of_week' => $day,
                    'time_from' => $data['time_from'],
                    'time_to' => $data['time_to'],
                    'created_by' => Auth::id(),
                ]);
            }

            // Create visit records for each scheduled day
            $this->visitService->createForSchedule($schedule, $selectedDays, $data);

            return $schedule->refresh();
        });
    }

    public function getByEmployeeId(User $employee, array $filters = [], bool $paginate = true, int $pageNumber = 1, ?int $perPage = null)
    {
        $query = $this->employeeScheduleRepository->findById('care_worker_id', $employee->id)->whereHas('carePlan');

        return $paginate ? $this->paginate($query->latest(), function (Model $schedule) {
            return new EmployeeScheduleResource($schedule);
        }, $pageNumber, $perPage ?? config('env.no_of_paginated_record')) : $query->latest()->get();
    }

    public function findOne(string $id): Schedule
    {
        return $this->employeeScheduleRepository->findOne($id);
    }

    public function getTypes(): array
    {
        return ScheduleType::all()->toArray();
    }

    public function delete(Schedule $schedule)
    {
        try{

            // Delete existing schedule times
            ScheduleTime::where('schedule_id', $schedule->id)->delete();

            // Delete existing visits for this schedule
            $schedule->visits()->delete();
            
            $schedule->delete();
            
        } catch (\Exception $e) {
            Log::error('Error deleting schedule: ' . $e->getMessage());
            $this->exception('Failed to delete schedule. Please try again.');
        }
    }
}
