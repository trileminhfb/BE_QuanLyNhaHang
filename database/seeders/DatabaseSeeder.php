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
            CategoryFoodSeeder::class,
            CustomerSeeder::class,
            HistoryPointSeeder::class,
            BookingSeeder::class,
            InvoiceSeeder::class,
            SaleFoodSeeder::class,
            SaleSeeder::class,
            FoodSeeder::class,
            TablesSeeder::class,
            TypeSeeder::class,
            CartSeeder::class,
            BookingFoodsSeeder::class,
            InvoiceFoodSeeder::class
        ]);
    }
}
