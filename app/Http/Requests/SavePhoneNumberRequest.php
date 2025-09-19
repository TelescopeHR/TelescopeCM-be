<?php

namespace App\Http\Requests;

use App\Models\PhoneNumber;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class SavePhoneNumberRequest extends BaseRequest
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
            'phone_numbers' => ['required', 'array'],
            'phone_numbers.*.type' => ['required_with:phone_numbers', 'integer', Rule::in(array_keys(\App\Models\PhoneNumber::MOBILE_TYPES))],
            'phone_numbers.*.phone_number' => ['required_with:phone_numbers', 'string', 'max:20'],
        ];
    }
}
