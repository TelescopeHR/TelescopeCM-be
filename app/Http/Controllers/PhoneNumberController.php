<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\HttpCode;
use App\Models\PhoneNumber;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Services\PhoneNumberService;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\SavePhoneNumberRequest;
use App\Http\Resources\SingleEmployeeResource;

class PhoneNumberController extends Controller
{
    public function __construct(
        private readonly PhoneNumberService $phoneNumberService,
        private readonly EmployeeService $employeeService
    )
    {
        
    }

    public function type(Request $request)
    {
       return (new ApiResponse())->success('Success fetching phone types', \App\Models\PhoneNumber::MOBILE_TYPES);
    }

    public function update(SavePhoneNumberRequest $request, User $user)
    {
        $data = $request->validated();

        return (new ApiResponse())->success('Success saving phone numbers', new SingleEmployeeResource($this->phoneNumberService->create($user, $data)));
    }
}
