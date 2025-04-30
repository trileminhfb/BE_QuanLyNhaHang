<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RankSeeder::class,
            CategorySeeder::class,
            CustomerSeeder::class,
            HistoryPointSeeder::class,
            BookingSeeder::class,
            InvoiceSeeder::class,
            // (có seeder khác thì thêm vô đây luôn)
        ]);
    }
}
