<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:biodata,address,background,phone_numbers'],
            
            //for biodata
            'first_name' => ['required_if:type,biodata', 'string', 'max:255'],
            'last_name' => ['required_if:type,biodata', 'string', 'max:255'],
            'middle_name' => ['required_if:type,biodata', 'nullable', 'string', 'max:255'],
            'gender' => ['required_if:type,biodata', 'integer', 'in:0,1,2'],
            'birth_date' => ['required_if:type,biodata', 'date'],
            'status' => ['required_if:type,biodata', 'integer', Rule::in(array_keys(\App\Models\EmployeeProfile::STATUSES))],
            'company' => ['sometimes', 'nullable', 'string', 'exists:companies,name'],
            'social_security' => ['required_if:type,biodata', 'string', 'max:11'],
            'email' => ['required_if:type,biodata', 'email', 'max:255', Rule::unique('users')->ignore($this->route('employee_id'), 'uuid')],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            // 'employee_id' => ['required_if:type,biodata', 'string', 'max:100', Rule::unique('employee_profiles', 'manual_employee_id')->ignore($this->route('employee_id'), 'user_id')],
            
            //for address
            'address' => ['required_if:type,address', 'string', 'max:255'],
            'city' => ['required_if:type,address', 'string', 'max:100'],
            'state' => ['required_if:type,address', 'string', 'max:100'],
            'zip' => ['required_if:type,address', 'string', 'max:20'],

            //for background
            'hire_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'application_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'orientation_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'signed_job_description_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'signed_policy_procedure_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'evaluated_assigned_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'last_evaluation_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'termination_date' => ['required_if:type,background', 'date', 'date_format:Y-m-d'],
            'number_of_references' => ['required_if:type,background', 'integer', 'min:0'],
        ];
    }
}
