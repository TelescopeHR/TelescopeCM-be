<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeScheduleResource extends JsonResource
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
            'schedule_id' => $this->schedule_id,
            'type' => [
                'id' => $this->type?->id,
                'name' => $this->type?->name
            ],
            'start_date' => $this->date_from,
            'end_date' => $this->date_to,
            'rate' => $this->rate,
            'hours' => $this->getTotalHours(),
            'status' => $this->status_text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'weekly_schedule' => ScheduleTimeResource::collection($this->times),
            'client' => [
                'id' => $this->patient?->uuid,
                'first_name' => $this->patient?->first_name,
                'last_name' => $this->patient?->last_name,
                'middle_name' => $this->patient?->middle_name,
            ]
            // 'employee' => new EmployeeResource($this->careWorker),
            // 'care_plan' => $this->carePlan,
        ];
    }

    public function getTotalHours(): int
    {
        // Calculate total hours from schedule times
        $totalHours = 0;
        collect($this->times)->map(function($time) use(&$totalHours){
            $start = Carbon::parse($time->time_from);
            $end = Carbon::parse($time->time_to);

            if ($start && $end) {
                $diffInMinutes = $start->diffInMinutes($end);
                $totalHours += $diffInMinutes / 60;
            }
        });

        return $totalHours;
    }
}
