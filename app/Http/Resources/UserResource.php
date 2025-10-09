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
            'id' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'email' => $this->email,
            'company' => $this->company,
            'gender' => $this->gender_text,
            'birthday' => Carbon::parse($this->birthday)->format('Y-m-d'),
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'status' => $this->status,
            'roles' => $this->whenLoaded('roles'),
            'last_login' => Carbon::parse($this->last_login_at)->format('Y-m-d H:i'),
            'profile_picture' => $this->avatar
        ];
    }
}
