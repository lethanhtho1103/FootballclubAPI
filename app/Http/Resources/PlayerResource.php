<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'goal' => $this->goal,
            'assist' => $this->assist,
            'position' => $this->position,
            'jersey_number' => $this->jersey_number,
            'detail' => $this->detail,
        ];
    }
}
