<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\EmployeeService;

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

        $employees = $this->employeeService->get($filters, $paginate, $pageNumber);

         if ($paginate) {
            return (new ApiResponse())->paginate("Success fetching employees", $employees);
        }

        return (new ApiResponse())->success('Success fetching employees', EmployeeResource::collection($employees));
    }
}
