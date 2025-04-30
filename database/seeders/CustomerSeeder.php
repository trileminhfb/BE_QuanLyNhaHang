<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'std' => '09' . rand(0,9) . rand(0,9) . rand(1000000, 9999999),
                'FullName' => $names[$i],
                'image' => 'https://khothietke.net/wp-content/uploads/2021/04/Khovector-007-298x300.jpg',
                'otp' => rand(0, 1) ? rand(100000, 999999) : null,
                'point' => rand(50, 500),
                'id_rank' => rand(1, 4),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customers')->insert($customers);
    }
}
