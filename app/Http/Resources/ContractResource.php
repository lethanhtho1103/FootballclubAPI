<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contract_id' => $this->contract_id,
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'date_created' => $this->date_created,
            'expiration_date' => $this->expiration_date,
            'salary' => $this->salary,
            'pdf' => $this->pdf,
            'type' => $this->type,
        ];
    }
}
