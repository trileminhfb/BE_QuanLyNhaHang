<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateCompletedBookings extends Command
{
    protected $signature = 'bookings:update-completed';
    protected $description = 'Tự động cập nhật status booking thành Completed nếu đã quá thời gian đặt';

    public function handle()
    {
        $now = Carbon::now();

        $updated = Booking::where('status', '!=', 4)
            ->where('timeBooking', '<=', $now)
            ->update(['status' => 4]);

        $this->info("Đã cập nhật {$updated} booking thành Completed (status = 4)");
    }
}
