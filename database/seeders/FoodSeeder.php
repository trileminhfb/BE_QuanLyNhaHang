<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'name' => 'Phở bò',
                'id_type' => 1, // Món ăn
                'image' => 'https://images.pexels.com/photos/2347311/pexels-photo-2347311.jpeg',
                'bestSeller' => 1,
                'cost' => 50000,
                'detail' => 'Phở bò thơm ngon với nước dùng đậm đà, thịt bò mềm.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Phở gà',
                'id_type' => 1, // Món ăn
                'image' => 'https://images.pexels.com/photos/2347312/pexels-photo-2347312.jpeg',
                'bestSeller' => 1,
                'cost' => 45000,
                'detail' => 'Phở gà với nước dùng trong, thịt gà ta mềm ngọt.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bún bò Huế',
                'id_type' => 1, // Món ăn
                'image' => 'https://images.pexels.com/photos/2347313/pexels-photo-2347313.jpeg',
                'bestSeller' => 1,
                'cost' => 55000,
                'detail' => 'Bún bò Huế cay nồng, đậm chất miền Trung.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gỏi cuốn',
                'id_type' => 1, // Món ăn
                'image' => 'https://images.pexels.com/photos/2347314/pexels-photo-2347314.jpeg',
                'bestSeller' => 1,
                'cost' => 30000,
                'detail' => 'Gỏi cuốn tôm thịt tươi ngon, ăn kèm nước chấm chua ngọt.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chè ba màu',
                'id_type' => 1, // Món ăn
                'image' => 'https://images.pexels.com/photos/2347316/pexels-photo-2347316.jpeg',
                'bestSeller' => 1,
                'cost' => 20000,
                'detail' => 'Chè ba màu ngọt mát, đậm chất truyền thống.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Coca-Cola',
                'id_type' => 2, // Nước
                'image' => 'https://images.pexels.com/photos/2347317/pexels-photo-2347317.jpeg',
                'bestSeller' => 1,
                'cost' => 15000,
                'detail' => 'Nước ngọt Coca-Cola giải khát tuyệt vời.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nước cam ép',
                'id_type' => 2, // Nước
                'image' => 'https://images.pexels.com/photos/2347318/pexels-photo-2347318.jpeg',
                'bestSeller' => 0,
                'cost' => 25000,
                'detail' => 'Nước cam ép tươi, giàu vitamin C.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Trà sữa trân châu',
                'id_type' => 2, // Nước
                'image' => 'https://images.pexels.com/photos/2347319/pexels-photo-2347319.jpeg',
                'bestSeller' => 1,
                'cost' => 30000,
                'detail' => 'Trà sữa trân châu thơm ngon, trân châu dai giòn.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Thêm các món khác nếu cần...
        ]);
    }
}
