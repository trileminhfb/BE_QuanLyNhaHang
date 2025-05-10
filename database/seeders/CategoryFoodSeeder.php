<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryFoodSeeder extends Seeder
{
    public function run()
    {
        DB::table('category_foods')->insert([
            ['id_category' => 1, 'id_food' => 1],
            ['id_category' => 2, 'id_food' => 3],
            ['id_category' => 3, 'id_food' => 5],
            ['id_category' => 1, 'id_food' => 6],
            ['id_category' => 2, 'id_food' => 8],
        ]);
    }
}
