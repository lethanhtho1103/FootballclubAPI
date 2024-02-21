<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLineup extends Model
{
    use HasFactory;

    protected $table = 'team_lineup';

    protected $primaryKey = 'lineup_id';

    protected $fillable = [
        'game_id',
        'user_id',
        'position',
        'is_starting_player',
        'formation'
    ];

    public $timestamps = false; // Không sử dụng timestamps

}
