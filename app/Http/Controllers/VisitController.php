<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Services\EmployeeScheduleService;
use Illuminate\Http\Request;
use App\Services\VisitService;
use App\Support\ApiResponse;

class VisitController extends Controller
{
    public function __construct(
        private readonly VisitService $visitService,
        private readonly EmployeeScheduleService $employeeScheduleService,
    )
    {
        
    }

    public function types()
    {
        return (new ApiResponse())->success('Visit types fetched successfully', Visit::VISIT_TYPES);
    }

    public function create(Request $request)
    {
        $data = $request->validated();
        $schedule = $this->employeeScheduleService->findOne($data['schedule_id']);

        $visit = $this->visitService->create($schedule, $data);

        return (new ApiResponse())->success('Visit created successfully', $visit);
    }


}
