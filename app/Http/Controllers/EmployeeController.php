<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SingleEmployeeResource;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Support\HttpCode;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeService $employeeService)
    {
        
    }

    public function index(Request $request)
    {
        $paginate = $request->boolean('paginate', false);
        $filters = $request->array('filters');
        $pageNumber = $request->integer('page', 1);
        $perPage = $request->integer('per_page');

        $employees = $this->employeeService->get($filters, $paginate, $pageNumber, $perPage);

         if ($paginate) {
            return (new ApiResponse())->paginate("Success fetching employees", $employees);
        }

        return (new ApiResponse())->success('Success fetching employees', EmployeeResource::collection($employees, null));
    }

    public function statistics(Request $request)
    {
        $stats = $this->employeeService->getStatistics();

        return (new ApiResponse())->success('Success fetching employee statistics', $stats);
    }

    public function show(Request $request, $employeeId)
    {
        $employee = $this->employeeService->findById($employeeId, ['employeeProfile', 'phoneNumbers', 'company']);

        if (!$employee) {
            return (new ApiResponse())->error('Employee not found', HttpCode::HTTP_NOT_FOUND);
        }

        return (new ApiResponse())->success('Success fetching employee', new SingleEmployeeResource($employee));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $data = $request->all();

        $newEmployee = $this->employeeService->create($data);

        return (new ApiResponse())->success('Success creating employee', new SingleEmployeeResource($newEmployee));
    }

    public function update(UpdateEmployeeRequest $request, $employeeId)
    {
        $data = $request->validated();

        $employee = $this->employeeService->findById($employeeId);

        if (!$employee) {
            return (new ApiResponse())->error('Employee not found', HttpCode::HTTP_NOT_FOUND);
        }

        $updatedEmployee = $this->employeeService->update($employee, $data);

        return (new ApiResponse())->success('Success updating employee', new SingleEmployeeResource($updatedEmployee));
    }

    public function status()
    {
        return (new ApiResponse())->success('Success fetching employee statuses', \App\Models\EmployeeProfile::STATUSES);
    }
}
