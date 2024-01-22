<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
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

    public function matches()
    {
        return $this->hasMany(Matching::class, 'stadium_id', 'stadium_id');
    }
}
