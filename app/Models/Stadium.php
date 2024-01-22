<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $primaryKey = 'stadium_id';

    protected $fillable = [
        'name',
        'address',
        'image',
        'capacity',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function games()
    {
        return $this->hasMany(Game::class, 'club_id', 'club_id');
    }
}
