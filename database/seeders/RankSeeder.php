<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ranks')->insert([
            ['nameRank' => 'Bronze',   'necessaryPoint' => 0,    'saleRank' => 0,  'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Silver',   'necessaryPoint' => 100,  'saleRank' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Gold',     'necessaryPoint' => 500,  'saleRank' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Platinum', 'necessaryPoint' => 1000, 'saleRank' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Diamond',  'necessaryPoint' => 2000, 'saleRank' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Master',   'necessaryPoint' => 3000, 'saleRank' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Grandmaster', 'necessaryPoint' => 4000, 'saleRank' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Legend',   'necessaryPoint' => 6000, 'saleRank' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Mythic',   'necessaryPoint' => 8000, 'saleRank' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['nameRank' => 'Immortal', 'necessaryPoint' => 10000, 'saleRank' => 50, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
