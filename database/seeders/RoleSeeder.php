<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ trong bảng Roles
        DB::table('roles')->delete();

        // Tạo dữ liệu mới
        $roles = [
            ['role_id' => '1' ,'role_name' => 'admin', 'role_detail' => 'Administrator role'],
            ['role_id' => '2' ,'role_name' => 'staff', 'role_detail' => 'Staff role'],
            ['role_id' => '3' ,'role_name' => 'coach', 'role_detail' => 'Coach role'],
            ['role_id' => '4' ,'role_name' => 'player', 'role_detail' => 'Player role'],
        ];

        // Chèn dữ liệu vào bảng
        DB::table('roles')->insert($roles);
    }
}
