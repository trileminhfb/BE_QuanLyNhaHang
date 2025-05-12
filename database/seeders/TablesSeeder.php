<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('tables')->insert([
            ['number' => 1, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 2, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 3, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 4, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 5, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 6, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 7, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 8, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 9, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 10, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 11, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 12, 'status' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['number' => 13, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
