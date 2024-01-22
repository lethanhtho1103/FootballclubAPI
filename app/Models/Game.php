<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $primaryKey = 'game_id'; // Primary key field name

    protected $fillable = [
        'club_id',
        'stadium_id',
        'game_date',
        'game_time',
        'goals_scored',
        'goals_conceded',
        'result',
        'state',
        'host',
        'remaining_seats',
    ];

    // Relationships
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'club_id');
    }

    public function gameDetails()
    {
        return $this->hasMany(GameDetail::class, 'game_id', 'game_id');
    }
}
