<?php

namespace App\Http\Requests;

use App\Models\ScheduleTime;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScheduleRequest extends BaseRequest
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
            'patient_id' => ['required', 'uuid', 'exists:users,uuid'],
            'care_worker_id' => ['required', 'uuid', 'exists:users,uuid'],
            // 'care_plan_id' => ['required', 'integer', 'exists:user_care_plans,id'],
            'type_id' => ['required', 'integer', 'exists:schedule_types,id'],
            'date_from' => ['required', 'date', 'date_format:Y-m-d'],
            'date_to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'rate' => ['required', 'numeric', 'min:0', 'lte:100000'],
            'status' => ['required', 'integer', 'between:0,2'],
            'time_from' => ['required', 'date_format:H:i'],
            'time_to' => ['required', 'date_format:H:i', 'after:time_from'],
            'selected_days' => ['required', 'array', ],
            'selected_days.*' => ['string', Rule::in(ScheduleTime::DAYS_OF_WEEK)],
            'all_day_event' => ['sometimes', 'nullable', 'boolean'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $patient = User::where('uuid', $this->patient_id)->first();
        $careWorker = User::where('uuid', $this->care_worker_id)->first();
        $carePlan = $patient->userCarePlan;
        
        $validated = array_merge(parent::validated(), [
            'patient_id' => $patient->id,
            'care_worker_id' => $careWorker->id,
            'care_plan_id' => $carePlan?->id,
        ]);

        return data_get($validated, $key, $default);
    }
}
