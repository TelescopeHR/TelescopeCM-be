<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'file_name' => $this->file_name,
            'file' => $this->file,
            'description' => $this->description,
            'expiration_date' => $this->expiration_date,
            'user' => [
                'id' => $this->user?->uuid,
                'first_name' => $this->user?->first_name,
                'last_name' => $this->user?->last_name,
            ],
            'created_at' => $this->created_at
        ];
    }
}
