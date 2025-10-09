<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use App\Models\EmployeeProfile;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
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
            'social_security' => $this->employeeProfile?->social_security,
            'company' => $this->company?->name,
            'address' => [
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'zip' => $this->zip,
            ],
            'phone_numbers' => [
                ['type' => 'login_phone', 'phone_number' => $this->phone],
                ...$this->phoneNumbers?->map(fn($phone) => [
                    'type' => PhoneNumber::MOBILE_TYPES[$phone->phone_type] ?? null,
                    'phone_number' => $phone->phone,
                ])->toArray()
            ],
            'background' => [
                'hire_date' => $this->employeeProfile?->hire_date,
                'application_date' => $this->employeeProfile?->application_date,
                'orientation_date' => $this->employeeProfile?->orientation_date,
                'signed_job_description_date' => $this->employeeProfile?->signed_job_description_date,
                'signed_policy_procedure_date' => $this->employeeProfile?->signed_policy_procedure_date,
                'evaluated_assigned_date' => $this->employeeProfile?->evaluated_assigned_date,
                'last_evaluation_date' => $this->employeeProfile?->last_evaluation_date,
                'termination_date' => $this->employeeProfile?->termination_date,
                'number_of_references' => $this->employeeProfile?->number_of_references,
            ],
        ];
    }
}
