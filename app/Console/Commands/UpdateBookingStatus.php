<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-booking-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        \App\Models\Booking::where('status', 2)
            ->where('timeBooking', '<=', $now->subMinutes(30))
            ->update(['status' => 4]);

        $this->info('Booking status updated.');
    }
}
