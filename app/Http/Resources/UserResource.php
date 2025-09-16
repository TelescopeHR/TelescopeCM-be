<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'full_name' => $this->fullName,
            'email' => $this->email,
            'last_login' => Carbon::parse($this->last_login_at)->format('Y-m-d H:i'),
            'avatar_url' => $this->avatar_url
        ];
    }
}
