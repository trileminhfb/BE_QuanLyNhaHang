<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'id_ingredient' => 1,
                'quantity' => 100,
            ],
            [
                'id_ingredient' => 2,
                'quantity' => 150,
            ],
            [
                'id_ingredient' => 3,
                'quantity' => 80,
            ],
            [
                'id_ingredient' => 4,
                'quantity' => 120,
            ],
            [
                'id_ingredient' => 5,
                'quantity' => 90,
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
