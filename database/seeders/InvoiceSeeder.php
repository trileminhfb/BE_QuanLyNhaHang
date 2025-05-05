<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = [];
        for ($i = 1; $i <= 10; $i++) {
            $invoices[] = [
                'id_table' => rand(1, 10),
                'timeEnd' => now()->addHours($i),
                'total' => rand(100000, 500000),
                'id_user' => rand(1, 5),
                'id_customer' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('invoices')->insert($invoices);
    }
}
