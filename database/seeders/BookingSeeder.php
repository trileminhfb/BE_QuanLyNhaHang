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
                'id_food' => 1,
                'quantity' => 2,
                'id_cutomer' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 2,
                'timeBooking' => now()->addDays(2),
                'id_food' => 2,
                'quantity' => 1,
                'id_cutomer' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 3,
                'timeBooking' => now()->addDays(3),
                'id_food' => 3,
                'quantity' => 3,
                'id_cutomer' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 4,
                'timeBooking' => now()->addDays(4),
                'id_food' => 4,
                'quantity' => 2,
                'id_cutomer' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 5,
                'timeBooking' => now()->addDays(5),
                'id_food' => 5,
                'quantity' => 1,
                'id_cutomer' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 6,
                'timeBooking' => now()->addDays(6),
                'id_food' => 6,
                'quantity' => 4,
                'id_cutomer' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 7,
                'timeBooking' => now()->addDays(7),
                'id_food' => 7,
                'quantity' => 2,
                'id_cutomer' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 8,
                'timeBooking' => now()->addDays(8),
                'id_food' => 8,
                'quantity' => 5,
                'id_cutomer' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 9,
                'timeBooking' => now()->addDays(9),
                'id_food' => 9,
                'quantity' => 1,
                'id_cutomer' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_table' => 10,
                'timeBooking' => now()->addDays(10),
                'id_food' => 10,
                'quantity' => 3,
                'id_cutomer' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
