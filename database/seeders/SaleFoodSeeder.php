<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sale_foods')->insert([
            ['id_food' => 1, 'id_sale' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 2, 'id_sale' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 3, 'id_sale' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 4, 'id_sale' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 5, 'id_sale' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 6, 'id_sale' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 7, 'id_sale' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 8, 'id_sale' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 9, 'id_sale' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 10, 'id_sale' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
