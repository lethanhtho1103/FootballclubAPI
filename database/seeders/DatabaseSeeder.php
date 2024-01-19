<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ trong bảng Users
        DB::table('users')->delete();

        // Thêm dữ liệu users
        $users = [
            [
                'user_id' => 'A1234567',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '2002-03-03',
                'nationality' => 'Vietnam',
                'role_id' => 1, // ID của quyền admin
            ]
        ];

        // Chèn dữ liệu vào bảng Users
        DB::table('users')->insert($users);
    }
}
