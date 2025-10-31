<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftNoteResource extends JsonResource
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
            'user' => [
                'id' => $this->user->uuid,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
            ],
            'message' => $this->message,
            'date_at' => $this->date_at,
            'visit' => new ScheduleVisitResource($this->visit),
            'care_needs' => $this->visit->tasks,
            'mood_type' => $this->visit->moodTypes[0]->title ?? null
        ];
    }
}
