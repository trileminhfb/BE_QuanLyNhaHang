<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Rán', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Nướng', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Chiên Mắm', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Hấp', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Cay', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Xào', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Nấu Lẩu', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Sốt', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Phô Mai', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Gà Truyền Thống', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
