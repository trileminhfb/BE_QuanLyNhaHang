<?php

namespace Database\Seeders;

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

            RankSeeder::class,
            CategorySeeder::class,
            CustomerSeeder::class,
            HistoryPointSeeder::class,
            BookingSeeder::class,
            InvoiceSeeder::class,
            FoodSeeder::class,
            TypeSeeder::class,
            TablesSeeder::class,
        ]);
    }

}
