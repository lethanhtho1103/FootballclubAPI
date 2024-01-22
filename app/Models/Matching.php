<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    protected $primaryKey = 'matching_id';

    protected $fillable = [
        'away_club',
        'stadium_id',
        'match_date',
        'match_time',
        'goals_scored',
        'goals_conceded',
        'result',
        'state',
        'host',
        'remaining_seats',
    ];

    protected $dates = [
        'match_date',
        'match_time',
        'created_at',
        'updated_at',
    ];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class, 'stadium_id', 'stadium_id');
    }

    public function details()
    {
        return $this->hasMany(MatchingDetail::class, 'matching_id', 'matching_id');
    }
}
