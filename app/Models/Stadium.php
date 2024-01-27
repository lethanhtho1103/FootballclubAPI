<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums';

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
        return $this->hasMany(Game::class, 'stadium_id', 'stadium_id');
    }
}
