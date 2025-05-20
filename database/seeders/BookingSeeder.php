<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'timeBooking' => now()->addDays(1),
                'id_customer' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->subDays(2),
                'id_customer' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now(),
                'id_customer' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(4),
                'id_customer' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(5),
                'id_customer' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(6),
                'id_customer' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(7),
                'id_customer' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(8),
                'id_customer' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(9),
                'id_customer' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'timeBooking' => now()->addDays(10),
                'id_customer' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
