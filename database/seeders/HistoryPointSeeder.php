<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoryPointSeeder extends Seeder
{
    public function run(): void
    { 
        $history = [];
        for ($i = 1; $i <= 10; $i++) {
            $history[] = [
                'id_customer' => $i,
                'point' => rand(10, 100),
                'date' => now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('historyPoints')->insert($history);
    }
}
