<?php

namespace App\Http\Requests;

use App\Models\Note;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminNoteRequest extends BaseRequest
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
            'mode' => ['sometimes', 'nullable', 'string', Rule::in(['employee', 'client'])],
            'type' => ['required', 'string', Rule::in(array_merge(array_keys(Note::CLIENT_NOTE_TYPES), array_keys(Note::EMPLOYEE_NOTE_TYPES)))],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'employee_id' => ['required_if:mode,employee', 'nullable', 'exists:users,uuid'],
            'client_id' => ['required_if:mode,client', 'nullable', 'exists:users,uuid'],
        ];
    }
}
