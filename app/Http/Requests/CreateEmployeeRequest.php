<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends BaseRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'gender' => ['required', 'integer', 'in:0,1,2'],
            'birthday' => ['required', 'date'],
            'status' => ['required', 'integer', Rule::in(array_keys(\App\Models\EmployeeProfile::STATUSES))],
            'profile_picture' => ['sometimes', 'nullable', 'string', 'url'],
            'company_id' => ['sometimes', 'nullable', 'string', 'exists:companies,uuid'],
            'social_security' => ['required', 'string', 'max:11'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
            // 'employee_id' => ['sometimes', 'nullable', 'string', 'max:100', Rule::unique('employee_profiles', 'manual_employee_id')],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'login_phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')],
            'phone_numbers' => ['sometimes', 'nullable', 'array'],
            'phone_numbers.*.type' => ['required_with:phone_numbers', 'integer', Rule::in(array_keys(\App\Models\PhoneNumber::MOBILE_TYPES))],
            'phone_numbers.*.phone_number' => ['required_with:phone_numbers', 'string', 'max:20'],
            'hire_date' => ['required', 'date', 'date_format:Y-m-d'],
            'application_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'orientation_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'signed_job_description_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'signed_policy_procedure_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'evaluated_assigned_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'last_evaluation_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'termination_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'number_of_references' => ['sometimes', 'nullable', 'integer', 'min:0'],
        ];
    }
}
