<?php

namespace App\Http\Resources;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminNoteResource extends JsonResource
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
            'type' => array_search($this->type, Note::CLIENT_NOTE_TYPES) ?: array_search($this->type, Note::EMPLOYEE_NOTE_TYPES),
            'title' => $this->title,
            'user' => [
                'id' => $this->user->uuid,
                'first_name' => $this->user?->first_name,
                'last_name' => $this->user?->last_name,
            ],
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
