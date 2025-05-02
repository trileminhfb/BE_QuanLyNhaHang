<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            [
                'id_food' => 1,
                'star' => 5,
                'detail' => 'Rất ngon, phục vụ nhanh!',
            ],
            [
                'id_food' => 1,
                'star' => 4,
                'detail' => 'Món ăn ổn, sẽ quay lại.',
            ],
            [
                'id_food' => 2,
                'star' => 3,
                'detail' => 'Hơi mặn, cần cải thiện.',
            ],
            [
                'id_food' => 3,
                'star' => 5,
                'detail' => 'Ngon tuyệt vời!',
            ],
            [
                'id_food' => 2,
                'star' => 2,
                'detail' => 'Thời gian chờ lâu.',
            ],
        ];

        foreach ($rates as $rate) {
            Rate::create($rate);
        }
    }
}
