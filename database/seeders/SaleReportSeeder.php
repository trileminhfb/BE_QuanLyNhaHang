<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaleReportSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sale_reports')->insert([
            [
                'report_type'      => 'daily',
                'report_date'      => '2024-05-10',
                'total_revenue'    => 1500000.00,
                'total_orders'     => 25,
                'top_food_name'    => 'Cơm chiên hải sản',
                'top_food_quantity'=> 10,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'report_type'      => 'weekly',
                'report_date'      => '2024-05-01',
                'total_revenue'    => 8200000.00,
                'total_orders'     => 110,
                'top_food_name'    => 'Lẩu thái',
                'top_food_quantity'=> 35,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]
        ]);
    }
}
