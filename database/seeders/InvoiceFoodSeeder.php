<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceFoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoice_food')->insert([
            [
                'id_food' => 1,
                'id_invoice' => 1,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 2,
                'id_invoice' => 1,
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 3,
                'id_invoice' => 2,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 4,
                'id_invoice' => 2,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 5,
                'id_invoice' => 3,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 6,
                'id_invoice' => 3,
                'quantity' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 7,
                'id_invoice' => 4,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 8,
                'id_invoice' => 4,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 9,
                'id_invoice' => 5,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 10,
                'id_invoice' => 5,
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm bản ghi khác
            [
                'id_food' => 2,
                'id_invoice' => 6,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 3,
                'id_invoice' => 6,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 5,
                'id_invoice' => 7,
                'quantity' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 7,
                'id_invoice' => 7,
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 8,
                'id_invoice' => 8,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_food' => 9,
                'id_invoice' => 8,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
