<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'role_id'; // Thiết lập khóa chính
    public $timestamps = false; // Không sử dụng timestamps

    protected $fillable = [
        'role_name',
        'role_detail',
    ];

    // Định nghĩa mối quan hệ với bảng Users
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}
