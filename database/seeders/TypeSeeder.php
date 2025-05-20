<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        Type::insert([
            ['status' => 1, 'name' => 'Món ăn', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 1, 'name' => 'Nước', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
