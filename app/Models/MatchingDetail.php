<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchingDetail extends Model
{
    protected $fillable = [
        'matching_id',
        'user_id',
        'player_name',
        'jersey_number',
        'is_away',
        'type',
        'time',
    ];

    protected $dates = [
        'time',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function matching()
    {
        return $this->belongsTo(Matching::class, 'matching_id', 'matching_id');
    }
}
