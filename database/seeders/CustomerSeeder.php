<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Nguyễn Văn An',
            'Trần Thị Bích',
            'Lê Hoàng Minh',
            'Phạm Hồng Hạnh',
            'Vũ Văn Nam',
            'Đỗ Thị Lan',
            'Hoàng Gia Bảo',
            'Ngô Minh Châu',
            'Bùi Thanh Tú',
            'Phan Thị Ngọc'
        ];

        $customers = [];

        for ($i = 0; $i < 10; $i++) {
            $customers[] = [
                'phoneNumber' => '09' . rand(1, 9) . rand(0, 9) . rand(1000000, 9999999),
                'mail' => Str::random(10) . '@example.com',
                'birth' => Carbon::now()->subYears(rand(18, 50))->format('Y-m-d'),
                'password' => Hash::make('password123'), 
                'FullName' => $names[$i],
                'image' => 'https://img.lovepik.com/png/20231127/young-businessman-3d-cartoon-avatar-portrait-character-digital_708913_wh1200.png',
                'otp' => rand(0, 1) ? rand(100000, 999999) : null,
                'point' => rand(50, 500),
                'id_rank' => rand(1, 4),
                'isActive' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customers')->insert($customers);
    }
}

