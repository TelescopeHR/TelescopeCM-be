<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'day_of_the_week' => $this->getDayName($this->day_of_week),
            'time_in' => $this->time_from,
            'time_out' => $this->time_to,
        ];
    }

    private function getDayName(int $dayNumber): string
    {
        $days = [
            1 => 'Sunday', 
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday'
        ];

        return $days[$dayNumber] ?? 'Invalid';
    }
}
