<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RankSeeder::class,
            CategorySeeder::class,
            CustomerSeeder::class,
            HistoryPointSeeder::class,
            BookingSeeder::class,
            InvoiceSeeder::class,
            FoodSeeder::class,
            TypeSeeder::class,
            IngredientSeeder::class,
            WarehouseSeeder::class,
            TablesSeeder::class,
            UserSeeder::class,
        ]);
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
