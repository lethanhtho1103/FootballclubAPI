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
            ['role_id' => '1', 'role_name' => 'admin', 'role_detail' => 'Administrator role'],
            ['role_id' => '2', 'role_name' => 'staff', 'role_detail' => 'Staff role'],
            ['role_id' => '3', 'role_name' => 'coach', 'role_detail' => 'Coach role'],
            ['role_id' => '4', 'role_name' => 'player', 'role_detail' => 'Player role'],
            ['role_id' => '5', 'role_name' => 'customer', 'role_detail' => 'Customer role'],
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
            ],
            [
                'user_id' => 'U0000001',
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '2002-03-03',
                'nationality' => 'Vietnam',
                'role_id' => 5, // ID của quyền admin
            ],
        ];

        // Chèn dữ liệu vào bảng Users
        DB::table('users')->insert($users);


        // Xóa dữ liệu cũ trong bảng Players và Coaches
        Player::truncate();
        Coach::truncate();

        // Dữ liệu cầu thủ Manchester City
        $manCityPlayers = [
            // Gk
            [
                'name' => 'Scott Carson',
                'email' => 'carson@example.com',
                'date_of_birth' => '1991-09-03',
                'nationality' => 'England',
                'position' => 'Goalkeeper',
                'jersey_number' => 33,
            ],
            [
                'name' => 'Ederson',
                'email' => 'ederson@example.com',
                'date_of_birth' => '1993-08-17',
                'nationality' => 'Brazil',
                'position' => 'Goalkeeper',
                'jersey_number' => 31,
            ],
            [
                'name' => 'Stefan Ortega Moreno',
                'email' => 'stefan@example.com',
                'date_of_birth' => '1992-11-06',
                'nationality' => 'Germany',
                'position' => 'Goalkeeper',
                'jersey_number' => 18,
            ],

            // Def
            [
                'name' => 'Manuel Akanji',
                'email' => 'akanji@example.com',
                'date_of_birth' => '1995-07-19',
                'nationality' => 'Switzerland',
                'position' => 'Defender',
                'jersey_number' => 25,
            ],
            [
                'name' => 'Nathan Ake',
                'email' => 'ake@example.com',
                'date_of_birth' => '1995-02-18',
                'nationality' => 'Netherlands',
                'position' => 'Defender',
                'jersey_number' => 6,
            ],
            [
                'name' => 'João Cancelo',
                'email' => 'cancelo@example.com',
                'date_of_birth' => '1994-05-27',
                'nationality' => 'Portugal',
                'position' => 'Defender',
                'jersey_number' => 7,
            ],
            [
                'name' => 'Ruben Dias',
                'email' => 'dias@example.com',
                'date_of_birth' => '1997-05-14',
                'nationality' => 'Portugal',
                'position' => 'Defender',
                'jersey_number' => 3,
            ],
            [
                'name' => 'Sergio Gomez',
                'email' => 'gomez@example.com',
                'date_of_birth' => '1999-06-30',
                'nationality' => 'Spain',
                'position' => 'Defender',
                'jersey_number' => 21,
            ],
            [
                'name' => 'Josko Gvardiol',
                'email' => 'gvardiol@example.com',
                'date_of_birth' => '2002-01-23',
                'nationality' => 'Croatia',
                'position' => 'Defender',
                'jersey_number' => 24,
            ],
            [
                'name' => 'Rico Lewis',
                'email' => 'lewis@example.com',
                'date_of_birth' => '2000-12-05',
                'nationality' => 'England',
                'position' => 'Defender',
                'jersey_number' => 82,
            ],
            [
                'name' => 'John Stones',
                'email' => 'stones@example.com',
                'date_of_birth' => '1994-05-28',
                'nationality' => 'England',
                'position' => 'Defender',
                'jersey_number' => 5,
            ],
            [
                'name' => 'Kyle Walker',
                'email' => 'walker@example.com',
                'date_of_birth' => '1990-05-28',
                'nationality' => 'England',
                'position' => 'Defender',
                'jersey_number' => 2,
            ],
            [
                'name' => 'Joshua Wilson-Esbrand',
                'email' => 'wilson-esbrand@example.com',
                'date_of_birth' => '2001-04-02',
                'nationality' => 'England',
                'position' => 'Defender',
                'jersey_number' => 97,
            ],

            // Mid
            [
                'name' => 'Oscar Bobb',
                'email' => 'bobb@example.com',
                'date_of_birth' => '2001-09-15',
                'nationality' => 'Norway',
                'position' => 'Midfielder',
                'jersey_number' => 52,
            ],
            [
                'name' => 'Kevin De Bruyne',
                'email' => 'debruyne@example.com',
                'date_of_birth' => '1991-06-28',
                'nationality' => 'Belgium',
                'position' => 'Midfielder',
                'jersey_number' => 17,
            ],
            [
                'name' => 'Jeremy Doku',
                'email' => 'doku@example.com',
                'date_of_birth' => '2002-05-27',
                'nationality' => 'Belgium',
                'position' => 'Midfielder',
                'jersey_number' => 11,
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
                'name' => 'Jack Grealish',
                'email' => 'grealish@example.com',
                'date_of_birth' => '1995-09-10',
                'nationality' => 'England',
                'position' => 'Midfielder',
                'jersey_number' => 10,
            ],
            [
                'name' => 'Mateo Kovacic',
                'email' => 'kovacic@example.com',
                'date_of_birth' => '1994-05-06',
                'nationality' => 'Croatia',
                'position' => 'Midfielder',
                'jersey_number' => 8,
            ],
            [
                'name' => 'Matheus Nunes',
                'email' => 'nunes@example.com',
                'date_of_birth' => '1999-11-30',
                'nationality' => 'Portugal',
                'position' => 'Midfielder',
                'jersey_number' => 27,
            ],

            [
                'name' => 'Rodrigo',
                'email' => 'rodrigo@example.com',
                'date_of_birth' => '1996-03-23',
                'nationality' => 'Spain',
                'position' => 'Midfielder',
                'jersey_number' => 16,
            ],
            [
                'name' => 'Bernardo Silva',
                'email' => 'silva@example.com',
                'date_of_birth' => '1994-08-10',
                'nationality' => 'Portugal',
                'position' => 'Midfielder',
                'jersey_number' => 20,
            ],

            // Fw
            [
                'name' => 'Julian Alvarez',
                'email' => 'alvarez@example.com',
                'date_of_birth' => '2000-01-31',
                'nationality' => 'Argentina',
                'position' => 'Forward',
                'jersey_number' => 10,
            ],
            [
                'name' => 'Erling Haaland',
                'email' => 'haaland@example.com',
                'date_of_birth' => '2000-07-21',
                'nationality' => 'Norway',
                'position' => 'Forward',
                'jersey_number' => 9,
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

        // Contracts
        // Truncate bảng contracts
        DB::table('contracts')->truncate();

        // Thêm dữ liệu hợp đồng cho 24 cầu thủ
        $contracts = [
            ['user_id' => 'P0000001', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 1000000,'pdf' => 'pdf',  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000002', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 900000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000003', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 850000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000004', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 800000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000005', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 750000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000006', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 700000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000007', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 650000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000008', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 600000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000009', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 550000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000010', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 500000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000011', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 950000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000012', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 900000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000013', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 850000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000014', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 800000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000015', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 750000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000016', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 700000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000017', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 650000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000018', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 600000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000019', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 550000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000020', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 500000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000021', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 950000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000022', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 900000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000023', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 850000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'P0000024', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 800000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 'C0000001', 'type' => 'individual', 'date_created' => '2024-02-25', 'expiration_date' => '2025-02-25', 'salary' => 800000, 'pdf' => 'pdf', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Chèn dữ liệu vào bảng contracts
        DB::table('contracts')->insert($contracts);
    }
}
