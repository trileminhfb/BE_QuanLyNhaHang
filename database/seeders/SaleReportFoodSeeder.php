<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleReportFood;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaleReportFoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sale_report_foods')->insert([
            [
                'id_sale_report' => 1,
                'id_food'        => 5,
                'quantity'       => 10,
                'total_price'    => 500000.00,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id_sale_report' => 1,
                'id_food'        => 7,
                'quantity'       => 5,
                'total_price'    => 250000.00,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id_sale_report' => 2,
                'id_food'        => 3,
                'quantity'       => 15,
                'total_price'    => 1200000.00,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
