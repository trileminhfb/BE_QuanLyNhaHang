<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carts')->insert([
            ['id_food' => 1, 'id_table' => 1, 'quantity' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 2, 'id_table' => 2, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 3, 'id_table' => 3, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 4, 'id_table' => 4, 'quantity' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 5, 'id_table' => 5, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 6, 'id_table' => 6, 'quantity' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 7, 'id_table' => 7, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 8, 'id_table' => 8, 'quantity' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 9, 'id_table' => 9, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_food' => 10, 'id_table' => 10, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
