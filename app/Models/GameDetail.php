<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{

    protected $table = 'game_detail';

    protected $primaryKey = 'game_detail_id';

    protected $fillable = [
        'game_id',
        'user_id',
        'player_name',
        'jersey_number',
        'is_away',
        'type',
        'time',
    ];

    public $timestamps = false; // Không sử dụng timestamps

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }
}
