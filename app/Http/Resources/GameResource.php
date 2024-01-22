<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'game_id' => $this->game_id,
            'club' => $this->club,
            'stadium' => $this->stadium,
            'game_date' => $this->game_date,
            'game_time' => $this->game_time,
            'goals_scored' => $this->goals_scored,
            'goals_conceded' => $this->goals_conceded,
            'result' => $this->result,
            'state' => $this->state,
            'host' => $this->host,
            'remaining_seats' => $this->remaining_seats,
        ];
    }
}
