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
                'name' => 'Gà rán truyền thống',
                'id_type' => 1,
                'image' => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg',
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
                'image' => 'https://images.pexels.com/photos/4106480/pexels-photo-4106480.jpeg',
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
                'image' => 'https://images.pexels.com/photos/209540/pexels-photo-209540.jpeg',
                'bestSeller' => 0,
                'cost' => 65000,
                'detail' => 'Lớp phô mai tan chảy kết hợp gà giòn rụm.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà nướng mật ong',
                'id_type' => 1,
                'image' => 'https://images.pexels.com/photos/616404/pexels-photo-616404.jpeg',
                'bestSeller' => 1,
                'cost' => 70000,
                'detail' => 'Gà nướng đậm đà, vị mật ong ngọt dịu.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà quay nguyên con',
                'id_type' => 1,
                'image' => 'https://images.pexels.com/photos/1123252/pexels-photo-1123252.jpeg',
                'bestSeller' => 1,
                'cost' => 150000,
                'detail' => 'Gà quay da giòn, thơm ngon cho cả gia đình.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà viên chiên giòn',
                'id_type' => 2,
                'image' => 'https://images.pexels.com/photos/1600711/pexels-photo-1600711.jpeg',
                'bestSeller' => 0,
                'cost' => 40000,
                'detail' => 'Viên gà chiên xù, thích hợp cho trẻ nhỏ.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cánh gà chiên nước mắm',
                'id_type' => 1,
                'image' => 'https://images.pexels.com/photos/2091888/pexels-photo-2091888.jpeg',
                'bestSeller' => 1,
                'cost' => 55000,
                'detail' => 'Cánh gà chiên giòn, sốt nước mắm thơm nức.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà sốt bơ tỏi',
                'id_type' => 2,
                'image' => 'https://images.pexels.com/photos/1267320/pexels-photo-1267320.jpeg',
                'bestSeller' => 0,
                'cost' => 62000,
                'detail' => 'Sốt bơ tỏi beo béo, thơm lừng.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà rán kiểu Mỹ',
                'id_type' => 1,
                'image' => 'https://images.pexels.com/photos/4518651/pexels-photo-4518651.jpeg',
                'bestSeller' => 0,
                'cost' => 58000,
                'detail' => 'Gà rán lớp bột dày, chuẩn vị Mỹ.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gà nướng tiêu đen',
                'id_type' => 1,
                'image' => 'https://images.pexels.com/photos/461198/pexels-photo-461198.jpeg',
                'bestSeller' => 0,
                'cost' => 69000,
                'detail' => 'Vị tiêu đen đậm đà, cay nhẹ hấp dẫn.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
