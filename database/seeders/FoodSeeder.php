<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'name' => 'Gà rán truyền thống',
                'id_type' => 1,
                'id_category' => 1,
                'bestSeller' => 1,
                'cost' => 50000,
                'detail' => 'Gà rán giòn thơm, đậm đà hương vị truyền thống.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà sốt cay Hàn Quốc',
                'id_type' => 2,
                'id_category' => 1,
                'bestSeller' => 0,
                'cost' => 60000,
                'detail' => 'Gà chiên phủ sốt cay đặc trưng Hàn Quốc.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà chiên phô mai',
                'id_type' => 2,
                'id_category' => 2,
                'bestSeller' => 0,
                'cost' => 65000,
                'detail' => 'Lớp phô mai tan chảy kết hợp gà giòn rụm.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
