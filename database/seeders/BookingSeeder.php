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
                'id_table' => 1,
                'timeBooking' => now()->addDays(1),
                'quantity' => 2,
                'id_customer' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 2,
                'timeBooking' => now()->addDays(2),
                'quantity' => 1,
                'id_customer' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 3,
                'timeBooking' => now()->addDays(3),
                'quantity' => 3,
                'id_customer' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 4,
                'timeBooking' => now()->addDays(4),
                'quantity' => 2,
                'id_customer' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 5,
                'timeBooking' => now()->addDays(5),
                'quantity' => 1,
                'id_customer' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 6,
                'timeBooking' => now()->addDays(6),
                'quantity' => 4,
                'id_customer' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 7,
                'timeBooking' => now()->addDays(7),
                'quantity' => 2,
                'id_customer' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 8,
                'timeBooking' => now()->addDays(8),
                'quantity' => 5,
                'id_customer' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 9,
                'timeBooking' => now()->addDays(9),
                'quantity' => 1,
                'id_customer' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 10,
                'timeBooking' => now()->addDays(10),
                'quantity' => 3,
                'id_customer' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
