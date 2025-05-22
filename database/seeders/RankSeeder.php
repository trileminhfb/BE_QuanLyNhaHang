<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ranks')->insert([
            ['nameRank' => 'Bronze',    'necessaryPoint' => 0,     'saleRank' => 0,   'image' => 'default/rank1.png',     'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Silver',    'necessaryPoint' => 100,   'saleRank' => 5,   'image' => 'default/rank2.png',    'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Gold',      'necessaryPoint' => 500,   'saleRank' => 10,  'image' => 'default/rank3.png',     'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Platinum',  'necessaryPoint' => 1000,  'saleRank' => 15,  'image' => 'default/rank4.png',     'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Diamond',   'necessaryPoint' => 2000,  'saleRank' => 20,  'image' => 'default/rank5.png', 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Master',    'necessaryPoint' => 3000,  'saleRank' => 25,  'image' => 'default/rank6.png', 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Grandmaster', 'necessaryPoint' => 4000, 'saleRank' => 30, 'image' => 'default/rank7.png', 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Legend',    'necessaryPoint' => 6000,  'saleRank' => 35,  'image' => 'default/rank8.png', 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Mythic',    'necessaryPoint' => 8000,  'saleRank' => 40,  'image' => 'default/rank9.png', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
