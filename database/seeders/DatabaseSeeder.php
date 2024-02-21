<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Player;
use App\Models\Coach;
use App\Helpers\UserHelper;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('roles')->delete();

        // Tạo dữ liệu mới
        $roles = [
            ['role_id' => '1' ,'role_name' => 'admin', 'role_detail' => 'Administrator role'],
            ['role_id' => '2' ,'role_name' => 'staff', 'role_detail' => 'Staff role'],
            ['role_id' => '3' ,'role_name' => 'coach', 'role_detail' => 'Coach role'],
            ['role_id' => '4' ,'role_name' => 'player', 'role_detail' => 'Player role'],
            ['role_id' => '5' ,'role_name' => 'customer', 'role_detail' => 'Customer role'],
        ];

        // Chèn dữ liệu vào bảng
        DB::table('roles')->insert($roles);


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


        // Xóa dữ liệu cũ trong bảng Players và Coaches
        Player::truncate();
        Coach::truncate();

        // Dữ liệu cầu thủ Manchester City
        $manCityPlayers = [
            [
                'name' => 'Kevin De Bruyne',
                'email' => 'debruyne@example.com',
                'date_of_birth' => '1991-06-28',
                'nationality' => 'Belgium',
                'position' => 'Midfielder',
                'jersey_number' => 17,
            ],
            [
                'name' => 'Phil Foden',
                'email' => 'foden@example.com',
                'date_of_birth' => '2000-05-28',
                'nationality' => 'England',
                'position' => 'Midfielder',
                'jersey_number' => 47,
            ],
            [
                'name' => 'Ruben Dias',
                'email' => 'dias@example.com',
                'date_of_birth' => '1997-05-14',
                'nationality' => 'Portugal',
                'position' => 'Defender',
                'jersey_number' => 3,
            ],
        ];

        foreach ($manCityPlayers as $playerData) {
            // Tạo user ID độc nhất cho cầu thủ
            $userID = UserHelper::generateUserID('P');

            // Thêm user vào bảng Users
            $user = User::create([
                'user_id' => $userID,
                'name' => $playerData['name'],
                'email' => $playerData['email'],
                'password' => Hash::make('password'),
                'date_of_birth' => $playerData['date_of_birth'],
                'nationality' => $playerData['nationality'],
                'role_id' => 4, // ID của quyền player
            ]);

            // Thêm cầu thủ vào bảng Players
            Player::create([
                'user_id' => $userID,
                'goal' => 0,
                'assist' => 0,
                'position' => $playerData['position'],
                'jersey_number' => $playerData['jersey_number'],
                'detail' => 'abc123'
            ]);
        }

        // Dữ liệu HLV Manchester City
        $manCityCoaches = [
            [
                'name' => 'Pep Guardiola',
                'email' => 'pep@example.com',
                'date_of_birth' => '1971-01-18',
                'nationality' => 'Spain',
                'role_id' => 3, // ID của quyền HLV
            ],
        ];

        foreach ($manCityCoaches as $coachData) {
            // Tạo user ID độc nhất cho HLV
            $coachID = UserHelper::generateUserID('C');

            // Thêm user vào bảng Users
            $user = User::create([
                'user_id' => $coachID,
                'name' => $coachData['name'],
                'email' => $coachData['email'],
                'password' => Hash::make('password'),
                'date_of_birth' => $coachData['date_of_birth'],
                'nationality' => $coachData['nationality'],
                'role_id' => $coachData['role_id'],
            ]);

            // Thêm HLV vào bảng Coaches
            Coach::create([
                'user_id' => $coachID,
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'detail' => 'abc123'
            ]);
        }

    }
}
