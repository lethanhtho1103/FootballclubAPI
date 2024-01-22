<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $primaryKey = 'club_id'; // Primary key field name

    protected $fillable = [
        'name',
        'logo',
    ];

    // Relationships
    public function games()
    {
        return $this->hasMany(Game::class, 'club_id', 'club_id');
    }
}
