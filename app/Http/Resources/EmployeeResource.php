<?php

namespace App\Http\Resources;

use App\Models\EmployeeProfile;
use App\Models\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'employee_id' => $this->employeeProfile?->manual_employee_id,
            'phone' => $this->phone,
            'gender' => $this->gender_text,
            'birthday' => Carbon::parse($this->birthday)->format('Y-m-d'),
            'employee_status' => EmployeeProfile::STATUSES[$this->employeeProfile?->employee_status] ?? null,
            'profile_picture' => $this->avatar,
            'email' => $this->email,
            'created_at' => $this->created_at?->toDateTimeString(), 
        ];
    }
}
