<?php

namespace App\Http\Controllers;

use App\Support\HttpCode;
use App\Models\PhoneNumber;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Services\PhoneNumberService;
use App\Http\Requests\SavePhoneNumberRequest;
use App\Http\Resources\EmployeeResource;

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

    public function update(SavePhoneNumberRequest $request, int $userId)
    {
        $data = $request->validated();
        $user = $this->employeeService->findById($userId);

        if (!$user) {
            return (new ApiResponse())->error('Employee not found', HttpCode::HTTP_NOT_FOUND);
        }

        return (new ApiResponse())->success('Success saving phone numbers', new EmployeeResource($this->phoneNumberService->create($user, $data), 'detailed'));
    }
}
