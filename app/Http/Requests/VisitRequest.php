<?php

namespace App\Http\Requests;

use App\Models\Visit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitRequest extends BaseRequest
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
            'date' => ['required', 'date'],
            'schedule_id' => ['required', 'uuid', 'exists:schedules,uuid'],
            'visit_type' => ['required', 'string', Rule::in(Visit::VISIT_TYPES)],
            'verified_in' => ['sometimes', 'nullable', 'date_format:H:i'],
            'verified_out' => ['sometimes', 'nullable', 'date_format:H:i'],
        ];
    }
}
