<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            [
                'id_food'     => 1,
                'id_customer' => 1,
                'star'        => 5,
                'detail'      => 'Rất ngon, phục vụ nhanh!',
                'time'        => Carbon::now(),
            ],
            [
                'id_food'     => 1,
                'id_customer' => 2,
                'star'        => 4,
                'detail'      => 'Món ăn ổn, sẽ quay lại.',
                'time'        => Carbon::now()->subMinutes(10),
            ],
            [
                'id_food'     => 2,
                'id_customer' => 3,
                'star'        => 3,
                'detail'      => 'Hơi mặn, cần cải thiện.',
                'time'        => Carbon::now()->subHours(1),
            ],
            [
                'id_food'     => 3,
                'id_customer' => 4,
                'star'        => 5,
                'detail'      => 'Ngon tuyệt vời!',
                'time'        => Carbon::now()->subDays(1),
            ],
            [
                'id_food'     => 2,
                'id_customer' => 5,
                'star'        => 2,
                'detail'      => 'Thời gian chờ lâu.',
                'time'        => Carbon::now()->subMinutes(30),
            ],
        ];

        foreach ($rates as $rate) {
            Rate::create($rate);
        }
    }
}
