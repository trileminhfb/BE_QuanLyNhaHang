<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            [
                'id_category' => 1,
                'status' => 1,
                'name' => 'Loại 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_category' => 2,
                'status' => 1,
                'name' => 'Loại 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_category' => 3,
                'status' => 0,
                'name' => 'Loại 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
