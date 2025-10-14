<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeScheduleController extends Controller
{
    public function __construct(private readonly EmployeeService $employeeService)
    {
        
    }
}
