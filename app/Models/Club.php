<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubs';

    protected $primaryKey = 'club_id'; // Primary key field name

    protected $fillable = [
        'name',
        'image',
    ];

    public $timestamps = false; // Không sử dụng timestamps

    // Relationships
    public function games()
    {
        return $this->hasMany(Game::class, 'club_id', 'club_id');
    }
}
