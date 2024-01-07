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
            ],
            [
                'user_id' => 'S0123456',
                'name' => 'Vicker Nau',
                'email' => 'viker@gmail.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '2002-03-03',
                'nationality' => 'Vietnam',
                'role_ID' => 2, // ID của quyền staff
            ],
            [
                'user_id' => 'C0123456',
                'name' => 'Coach',
                'email' => 'coach@gmail.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '1995-05-05',
                'nationality' => 'Portol',
                'role_ID' => 3, // ID của quyền coach
            ],
            [
                'user_id' => 'P0123456',
                'name' => 'Jack Grealish',
                'email' => 'jack@gmail.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '2000-10-10',
                'nationality' => 'England',
                'role_ID' => 4, // ID của quyền player
            ],
        ];

        // Chèn dữ liệu vào bảng Users
        DB::table('users')->insert($users);
    }
}
