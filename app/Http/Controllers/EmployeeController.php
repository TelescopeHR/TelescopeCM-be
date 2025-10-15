<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SingleEmployeeResource;
use App\Models\User;
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
        $name = $request->query('name');
        $employee_id = $request->query('employee_id');
        $status = $request->integer('status');
        $pageNumber = $request->integer('page', 1);
        $perPage = $request->integer('per_page');

        $employees = $this->employeeService->get([
            'name' => $name,
            'employee_id' => $employee_id,
            'status' => $status
        ], $paginate, $pageNumber, $perPage);

         if ($paginate) {
            return (new ApiResponse())->paginate("Success fetching employees", $employees);
        }

        return (new ApiResponse())->success('Success fetching employees', EmployeeResource::collection($employees));
    }

    public function statistics(Request $request)
    {
        $stats = $this->employeeService->getStatistics();

        return (new ApiResponse())->success('Success fetching employee statistics', $stats);
    }

    public function show(Request $request, User $employee)
    {
        return (new ApiResponse())->success('Success fetching employee', new SingleEmployeeResource($employee));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $data = $request->all();

        $newEmployee = $this->employeeService->create($data);

        return (new ApiResponse())->success('Success creating employee', new SingleEmployeeResource($newEmployee));
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $data = $request->validated();

        $updatedEmployee = $this->employeeService->update($employee, $data);

        return (new ApiResponse())->success('Success updating employee', new SingleEmployeeResource($updatedEmployee));
    }

    public function delete(User $employee)
    {
        $this->employeeService->delete($employee);

        return (new ApiResponse())->success('Success deleting employee');
    }

    public function status()
    {
        return (new ApiResponse())->success('Success fetching employee statuses', \App\Models\EmployeeProfile::STATUSES);
    }
}
