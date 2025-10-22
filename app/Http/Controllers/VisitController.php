<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitRequest;
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

    public function create(VisitRequest $request)
    {
        $data = $request->validated();
        $schedule = $this->employeeScheduleService->findOne($data['schedule_id']);

        $visit = $this->visitService->create($schedule, $data);

        return (new ApiResponse())->success('Visit created successfully', $visit);
    }

    public function update(VisitRequest $request, Visit $visit)
    {
        $data = $request->validated();
        $schedule = $this->employeeScheduleService->findOne($data['schedule_id']);
        $data['schedule_id'] = $schedule->id;

        $updatedVisit = $this->visitService->update($visit, $data);

        return (new ApiResponse())->success('Visit updated successfully', $updatedVisit);
    }

    public function delete(Visit $visit)
    {
        $this->visitService->delete($visit);

        return (new ApiResponse())->success('Visit deleted successfully');
    }
}
