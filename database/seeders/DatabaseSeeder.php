<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            IngredientSeeder::class,
            WarehouseSeeder::class,
            WarehouseInvoiceSeeder::class,
            UserSeeder::class,
            RateSeeder::class,
            ReviewManagementSeeder::class,

        ]);
    }

}
