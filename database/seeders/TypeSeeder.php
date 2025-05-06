<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        Type::insert([
            [
                'id_category' => 1,
                'status' => 1,
                'name' => 'Món chính',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_category' => 1,
                'status' => 1,
                'name' => 'Tráng miệng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_category' => 2,
                'status' => 1,
                'name' => 'Đồ uống',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
