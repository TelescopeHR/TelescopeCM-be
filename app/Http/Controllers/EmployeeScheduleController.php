<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Services\EmployeeScheduleService;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Support\ApiResponse;

class EmployeeScheduleController extends Controller
{
    public function __construct(private readonly EmployeeScheduleService $employeeScheduleService)
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

        return (new ApiResponse())->success('Success fetching schedules', $schedules);
    }

    public function detail(Schedule $schedule)
    {
        $data = [
            'weekly_schedule' => $schedule->times,
            'client' => $schedule->patient,
            'care_plan' => $schedule->carePlan,
            'visits' => $schedule->visits,
        ];

        return (new ApiResponse())->success('Success fetching schedule details', $data);
    }
}
