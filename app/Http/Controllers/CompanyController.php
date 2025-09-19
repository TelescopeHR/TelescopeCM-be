<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return (new ApiResponse())->success('Success fetching company info', Company::all());
    }
}
