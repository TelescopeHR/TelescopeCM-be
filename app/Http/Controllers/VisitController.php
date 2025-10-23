<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Visit;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\VisitService;
use App\Http\Requests\VisitRequest;
use App\Services\EmployeeScheduleService;
use App\Http\Resources\ScheduleVisitResource;

class VisitController extends Controller
{
    public function __construct(
        private readonly VisitService $visitService,
        private readonly EmployeeScheduleService $employeeScheduleService,
    )
    {
        
    }

    public function index(Request $request)
    {
        $totalScheduled = 0;
        $totalVerified = 0;

        $filters = [
            'employee_id' => $request->query('employee_id'),
            'client_id' => $request->query('client_id'),
            'date_from' => $request->query('date_from'),
            'date_to' => $request->query('date_to'),
        ];

        $paginate = $request->boolean('paginate');
        $pageNumber = $request->integer('page_number');
        $perPage = $request->integer('per_page');

        $visits = $this->visitService->get($filters, $paginate, $pageNumber, $perPage);

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
                    'total_scheduled_hours' => round($totalScheduled, 2),
                    'total_verified_hours' => round($totalVerified, 2),
                    'visits' => $visitsData
                ], 'pagination' => $visits['pagination']
            ]);
        }

        return (new ApiResponse())->success('Success fetching visits', [
            'total_scheduled_hours' => round($totalScheduled, 2),
            'total_verified_hours' => round($totalVerified, 2),
            'visits' => ScheduleVisitResource::collection($visits),
        ]);
    }

    public function types()
    {
        return (new ApiResponse())->success('Visit types fetched successfully', Visit::VISIT_TYPES);
    }

    public function create(VisitRequest $request)
    {
        $data = $request->validated();
        $schedule = $this->employeeScheduleService->findOne($data['schedule_id']);

        $visit = $this->visitService->create($schedule, $data);

        return (new ApiResponse())->success('Visit created successfully', new ScheduleVisitResource($visit));
    }

    public function update(VisitRequest $request, Visit $visit)
    {
        $data = $request->validated();
        $schedule = $this->employeeScheduleService->findOne($data['schedule_id']);
        $data['schedule_id'] = $schedule->id;

        $updatedVisit = $this->visitService->update($visit, $data);

        return (new ApiResponse())->success('Visit updated successfully', new ScheduleVisitResource($updatedVisit));
    }

    public function delete(Visit $visit)
    {
        $this->visitService->delete($visit);

        return (new ApiResponse())->success('Visit deleted successfully');
    }
}
