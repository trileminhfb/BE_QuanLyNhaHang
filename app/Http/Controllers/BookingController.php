<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingFood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::with([
                'customer',
                'bookingFoods.food'
            ])->get();

            return response()->json(['data' => $bookings], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createBooking(Request $request)
    {
        try {
            $customer = Auth::guard('sanctum')->user(); // để dễ hiểu
            if (!$customer) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $status = $request->input('status', 1);
            $timeBooking = $request->input('timeBooking');

            $booking = Booking::create([
                'id_customer' => $customer->id,
                'timeBooking' => $timeBooking,
                'status' => $status,
            ]);

            return response()->json([
                'message' => 'Booking created successfully.',
                'booking' => $booking,
                'customer' => $customer,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $booking = Booking::with([
                'customer',
                'bookingFoods.food'
            ])->find($id);

            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            return response()->json(['data' => $booking], 200);
        } catch (\Exception $e) {
            // Debugging the error message
            Log::error('Error retrieving booking: ' . $e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            $phoneNumber = $request->input('phoneNumber');
            $fullName    = $request->input('FullName');
            $timeBooking = $request->input('timeBooking');
            $status      = $request->input('status');
            $autoChanged = false;
            $diffMinutes = null;

            // Nếu có phoneNumber thì xử lý cập nhật hoặc tạo customer
            if ($phoneNumber) {
                $customer = Customer::firstOrCreate(
                    ['phoneNumber' => $phoneNumber],
                    [
                        'FullName' => $fullName ?? '',
                        'otp'      => null,
                        'point'    => 0,
                        'id_rank'  => 1,
                    ]
                );

                if ($fullName) {
                    $customer->update(['FullName' => $fullName]);
                }

                $booking->id_customer = $customer->id;
            }

            // Cập nhật timeBooking nếu có
            if ($timeBooking) {
                $booking->timeBooking = $timeBooking;
            }

            // Cập nhật status nếu có
            if (!is_null($status)) {
                $booking->status = $status;

                // Nếu status là 2 và timeBooking quá 30 phút thì chuyển sang 4
                if ($status == 2 && $booking->timeBooking) {
                    $bookingTime = Carbon::parse($booking->timeBooking);
                    $now = Carbon::now();
                    $diffMinutes = $now->diffInMinutes($bookingTime, false); // âm nếu đã quá

                    if ($diffMinutes < 0) {
                        // timeBooking trong quá khứ → KHÔNG cập nhật status nữa
                    } else if ($diffMinutes >= 30) {
                        $booking->status = 4;
                    }
                }
            }

            $booking->save();

            return response()->json([
                'message' => 'Cập nhật đặt bàn thành công.',
                'auto_status_changed' => $autoChanged,
                'time_difference_minutes' => $diffMinutes,
                'booking' => $booking,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function autoUpdateStatus()
    {
        try {
            $now = Carbon::now();

            // Lấy tất cả các bản ghi chưa có status là 4
            $bookings = Booking::where('status', '!=', 4)->get();

            $updatedCount = 0;

            foreach ($bookings as $booking) {
                // Kiểm tra nếu timeBooking đã vượt quá 1 giờ so với thời điểm hiện tại
                if (Carbon::parse($booking->timeBooking)->addHour()->lte($now)) {
                    $booking->status = 4;
                    $booking->save();
                    $updatedCount++;
                }
            }

            return response()->json([
                'message' => 'Cập nhật thành công.',
                'updated_count' => $updatedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
