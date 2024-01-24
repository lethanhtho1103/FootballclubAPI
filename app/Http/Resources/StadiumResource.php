<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StadiumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stadium_id' => $this->stadium_id,
            'name' => $this->name,
            'address' => $this->address,
            'image' => $this->image,
            'capacity' => $this->capacity,
        ];
    }
}
