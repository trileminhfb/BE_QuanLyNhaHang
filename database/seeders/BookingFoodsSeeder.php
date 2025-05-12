<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingFoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('booking_foods')->insert([
            [
                'id_foods' => 1,
                'quantity' => 10,
                'id_booking' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_foods' => 2,
                'quantity' => 5,
                'id_booking' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
