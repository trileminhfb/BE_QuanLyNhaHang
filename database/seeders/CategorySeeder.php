<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id_type' => 1, 'status' => 1, 'name' => 'Món nước', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món nướng', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món chiên', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món hấp', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món xào', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món mặn', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món ăn truyền thống', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món quốc tế', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món luộc', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món chay', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món ăn nhanh', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món khai vị', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món tráng miệng', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món ăn nhẹ', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món phụ', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 1, 'status' => 1, 'name' => 'Món ăn sáng', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 2, 'status' => 1, 'name' => 'Nước ngọt', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 2, 'status' => 1, 'name' => 'Nước ép', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 2, 'status' => 1, 'name' => 'Đồ uống có gas', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 2, 'status' => 1, 'name' => 'Đồ uống không cồn', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 2, 'status' => 1, 'name' => 'Đồ uống lạnh', 'created_at' => now(), 'updated_at' => now()],
            ['id_type' => 2, 'status' => 1, 'name' => 'Đồ uống nóng', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
