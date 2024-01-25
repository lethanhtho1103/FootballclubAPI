<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\UserHelper;
use App\Models\User;
use App\Models\Player;
use App\Models\Coach;

class ManCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dữ liệu cầu thủ Manchester City
        $manCityPlayers = [
            // [
            //     'name' => 'Kevin De Bruyne',
            //     'email' => 'debruyne@example.com',
            //     'date_of_birth' => '1991-06-28',
            //     'nationality' => 'Belgium',
            //     'position' => 'Midfielder',
            //     'jersey_number' => 17,
            // ],
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
