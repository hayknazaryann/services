<?php

namespace App\Http\Resources\User;

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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_code' => $this->profile->phone_code ?? null,
            'phone_number' => $this->profile->phone_number ?? null,
            'address' => $this->profile->address ?? null,
            'specialization' => $this->profile->specialization ?? null,
            'about' => $this->profile->about ?? null,
            'avatar' => $this->profile->avatar ?? null,
//            'birthdate' => $this->profile->birthdate ?? null,
            'birthdate' => $this->profile->birthdate ? Carbon::parse($this->profile->birthdate)->format('F j, Y') : null,
        ];
    }
}
