<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryFoodSeeder extends Seeder
{
    public function run()
    {
        DB::table('category_foods')->insert([
            ['id_category' => 7, 'id_food' => 1], // Phở bò - Món ăn truyền thống
            ['id_category' => 1, 'id_food' => 1], // Phở bò - Món nước
            ['id_category' => 7, 'id_food' => 2], // Phở gà - Món ăn truyền thống
            ['id_category' => 1, 'id_food' => 2], // Phở gà - Món nước
            ['id_category' => 7, 'id_food' => 3], // Bún bò Huế - Món ăn truyền thống
            ['id_category' => 1, 'id_food' => 3], // Bún bò Huế - Món nước
            ['id_category' => 7, 'id_food' => 4], // Gỏi cuốn - Món ăn truyền thống
            ['id_category' => 10, 'id_food' => 4], // Gỏi cuốn - Món chay
            ['id_category' => 12, 'id_food' => 4], // Gỏi cuốn - Món khai vị
            ['id_category' => 7, 'id_food' => 5], // Chè ba màu - Món ăn truyền thống
            ['id_category' => 13, 'id_food' => 5], // Chè ba màu - Món tráng miệng
            ['id_category' => 17, 'id_food' => 6], // Coca-Cola - Nước ngọt
            ['id_category' => 19, 'id_food' => 6], // Coca-Cola - Đồ uống có gas
            ['id_category' => 18, 'id_food' => 7], // Nước cam ép - Nước ép
            ['id_category' => 20, 'id_food' => 7], // Nước cam ép - Đồ uống không cồn
            ['id_category' => 21, 'id_food' => 7], // Nước cam ép - Đồ uống lạnh
            ['id_category' => 17, 'id_food' => 8], // Trà sữa trân châu - Nước ngọt
            ['id_category' => 20, 'id_food' => 8], // Trà sữa trân châu - Đồ uống không cồn
            ['id_category' => 21, 'id_food' => 8], // Trà sữa trân châu - Đồ uống lạnh
            // Thêm các ánh xạ khác nếu cần...
        ]);
    }
}
