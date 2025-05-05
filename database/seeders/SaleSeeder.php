<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales')->insert([
            [
                'nameSale' => 'Khuyến mãi Tết',
                'status' => 1,
                'startTime' => Carbon::parse('2025-01-20 00:00:00'),
                'endTime' => Carbon::parse('2025-02-05 23:59:59'),
                'percent' => 20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Mừng sinh nhật quán',
                'status' => 0,
                'startTime' => Carbon::parse('2024-10-01 00:00:00'),
                'endTime' => Carbon::parse('2024-10-10 23:59:59'),
                'percent' => 15.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Giảm giá mùa hè',
                'status' => 1,
                'startTime' => Carbon::parse('2025-06-01 00:00:00'),
                'endTime' => Carbon::parse('2025-06-15 23:59:59'),
                'percent' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Black Friday',
                'status' => 1,
                'startTime' => Carbon::parse('2025-11-29 00:00:00'),
                'endTime' => Carbon::parse('2025-11-30 23:59:59'),
                'percent' => 30.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Mừng Quốc tế Phụ nữ',
                'status' => 0,
                'startTime' => Carbon::parse('2025-03-08 00:00:00'),
                'endTime' => Carbon::parse('2025-03-08 23:59:59'),
                'percent' => 8.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Flash Sale cuối tuần',
                'status' => 1,
                'startTime' => Carbon::parse('2025-05-10 00:00:00'),
                'endTime' => Carbon::parse('2025-05-12 23:59:59'),
                'percent' => 25.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Giảm giá combo gia đình',
                'status' => 1,
                'startTime' => Carbon::parse('2025-07-01 00:00:00'),
                'endTime' => Carbon::parse('2025-07-15 23:59:59'),
                'percent' => 18.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Sale cuối tháng',
                'status' => 1,
                'startTime' => Carbon::parse('2025-05-25 00:00:00'),
                'endTime' => Carbon::parse('2025-05-31 23:59:59'),
                'percent' => 12.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Giảm giá ngày lễ tình nhân',
                'status' => 0,
                'startTime' => Carbon::parse('2025-02-14 00:00:00'),
                'endTime' => Carbon::parse('2025-02-14 23:59:59'),
                'percent' => 22.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nameSale' => 'Khuyến mãi 1/6 thiếu nhi',
                'status' => 1,
                'startTime' => Carbon::parse('2025-06-01 00:00:00'),
                'endTime' => Carbon::parse('2025-06-03 23:59:59'),
                'percent' => 14.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
