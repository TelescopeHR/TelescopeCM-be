<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\EmployeeScheduleResource;
use App\Http\Resources\ScheduleVisitResource;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Services\EmployeeScheduleService;
use App\Services\VisitService;

class EmployeeScheduleController extends Controller
{
    public function __construct(
        private readonly EmployeeScheduleService $employeeScheduleService,
        private readonly VisitService $visitService
    )
    {
        
    }

    public function index(User $employee, Request $request)
    {
        $paginate = $request->boolean('paginate');
        $pageNumber = $request->integer('page_number');
        $perPage = $request->integer('per_page');

        $schedules = $this->employeeScheduleService->getByEmployeeId($employee, [], $paginate, $pageNumber, $perPage);

        if($paginate){
            return (new ApiResponse())->paginate('Success fetching schedule', $schedules);
        }

        return (new ApiResponse())->success('Success fetching schedules', EmployeeScheduleResource::collection($schedules));
    }

    public function create(ScheduleRequest $request)
    {
        $data = $request->validated();
        $schedule = $this->employeeScheduleService->create($data);

        return (new ApiResponse())->success('Schedule created successfully', new EmployeeScheduleResource($schedule));
    }

    public function detail(Schedule $schedule)
    {
        $data = [
            'client' => [
                'id' => $schedule->patient?->uuid,
                'first_name' => $schedule->patient?->first_name,
                'last_name' => $schedule->patient?->last_name,
                'middle_name' => $schedule->patient?->middle_name,
                'address' => $schedule->patient?->address,
                'city' => $schedule->patient?->city,
                'status' => $schedule->patient?->status_text,
                'phone' => $schedule->patient?->phone,
            ],
            'care_plan' => $schedule->carePlan,
        ];

        return (new ApiResponse())->success('Success fetching schedule details', $data);
    }

    public function visits(Request $request, Schedule $schedule)
    {
        $totalScheduled = 0;
        $totalVerified = 0;

        $filters = [
            'date_from' => $request->query('date_from'),
            'date_to' => $request->query('date_to'),
        ];

        $paginate = $request->boolean('paginate');
        $pageNumber = $request->integer('page_number');
        $perPage = $request->integer('per_page');

        $visits = $this->visitService->getByScheduleId($schedule, $filters, $paginate, $pageNumber, $perPage);

        $visitsData = $paginate ? $visits['data'] : $visits;

        foreach ($visitsData as $visit) {
            // Scheduled time
            if (!empty($visit['time_in']) && !empty($visit['time_out'])) {
                $inTime = Carbon::parse('1970-01-01 ' . $visit['time_in']);
                $outTime = Carbon::parse('1970-01-01 ' . $visit['time_out']);

                // Handle overnight (next-day) case
                if ($outTime->lessThan($inTime)) {
                    $outTime->addDay();
                }

                $diffInHours = $inTime->diffInHours($outTime, false);
                $totalScheduled += $diffInHours;
            }

            // Verified time
            if (!empty($visit['verified_in']) && !empty($visit['verified_out'])) {
                $verifiedIn = Carbon::parse('1970-01-01 ' . $visit['verified_in']);
                $verifiedOut = Carbon::parse('1970-01-01 ' . $visit['verified_out']);

                // Handle next-day case (overnight shifts)
                if ($verifiedOut->lessThan($verifiedIn)) {
                    $verifiedOut->addDay();
                }

                $verifiedMinutes = $verifiedIn->diffInHours($verifiedOut, false);
                $totalVerified += $verifiedMinutes;
            }
        }

        if($paginate){
            return (new ApiResponse())->paginate('Success fetching visits', [
                'data' => [
                    'total_scheduled_hours' => $totalScheduled,
                    'total_verified_hours' => $totalVerified,
                    'visits' => $visitsData
                ], 'pagination' => $visits['pagination']
            ]);
        }

        return (new ApiResponse())->success('Success fetching schedule visits', [
            'total_scheduled_hours' => $totalScheduled,
            'total_verified_hours' => $totalVerified,
            'visits' => ScheduleVisitResource::collection($visits),
        ]);
    }

    public function getTypes()
    {
        $types = $this->employeeScheduleService->getTypes();

        return (new ApiResponse())->success('Success fetching schedule types', $types);
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $update = $this->employeeScheduleService->update($schedule, $request->validated());

        return (new ApiResponse())->success('Schedule updated successfully', new EmployeeScheduleResource($update));
    }
}
