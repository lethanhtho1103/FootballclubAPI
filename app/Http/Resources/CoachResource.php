<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoachResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'date_of_birth' => $this->user->date_of_birth,
            'nationality' => $this->user->nationality,
            'flag' => $this->user->flag,
            'image' => $this->user->image,
            'position' => $this->position,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'contract' => $this->contract
        ];
    }
}
