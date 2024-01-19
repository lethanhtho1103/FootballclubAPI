<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\UserHelper;
use App\Models\User;
use App\Models\Player;

class ManCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
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
            ]);
        }
    }
}
