<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
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
            $customer = Auth::guard('sanctum')->user();
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
            $fullName = $request->input('FullName');
            $timeBooking = $request->input('timeBooking');
            $status = $request->input('status');
            $autoChanged = false;
            $diffMinutes = null;

            if ($phoneNumber) {
                $customer = Customer::firstOrCreate(
                    ['phoneNumber' => $phoneNumber],
                    [
                        'FullName' => $fullName ?? '',
                        'otp' => null,
                        'point' => 0,
                        'id_rank' => 1,
                    ]
                );

                if ($fullName) {
                    $customer->update(['FullName' => $fullName]);
                }

                $booking->id_customer = $customer->id;
            }

            if ($timeBooking) {
                $booking->timeBooking = $timeBooking;
            }

            if (!is_null($status)) {
                $booking->status = $status;
            }

            // Nếu status là 2 và timeBooking quá 30 phút thì chuyển sang 4
            if ($status == 2 && $booking->timeBooking) {
                $bookingTime = Carbon::parse($booking->timeBooking);
                $now = Carbon::now();
                $diffMinutes = $now->diffInMinutes($bookingTime, false); // âm nếu đã quá

                if ($diffMinutes < -30) {
                    $booking->status = 4;
                    $autoChanged = true;
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

    public function delete($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
    public function deleteFoodInBooking($bookingId, $foodId)
    {
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Giả sử foods là JSON, giải mã thành mảng
        $foods = is_string($booking->foods) ? json_decode($booking->foods, true) : $booking->foods;

        if (!is_array($foods)) {
            return response()->json(['message' => 'Invalid foods data'], 400);
        }

        // Lọc bỏ món ăn với id_foods tương ứng
        $foods = array_filter($foods, fn ($food) => $food['id_foods'] != $foodId);

        if (empty($foods)) {
            $booking->delete(); // Xóa booking nếu không còn món
            return response()->json(['message' => 'Booking deleted as no food left'], 200);
        }

        $booking->foods = array_values($foods);
        $booking->save();

        return response()->json(['message' => 'Food removed from booking'], 200);
    }

    public function deleteFood($bookingId, $foodId)
    {
        try {
            $booking = Booking::find($bookingId);
            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            $deleted = DB::table('booking_foods')
                ->where('id_booking', $bookingId)
                ->where('id_foods', $foodId)
                ->delete();

            if (!$deleted) {
                return response()->json(['message' => 'Food not found in booking'], 404);
            }

            return response()->json(['message' => 'Food removed from booking successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function historyBooking(Request $request)
    {
        $bookings = Booking::where('id_customer', $request->user()->id)
            ->with(['bookingFoods.food'])
            ->get();

        $data = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'timeBooking' => $booking->timeBooking,
                'status' => $booking->status,
                'foods' => $booking->bookingFoods->map(function ($bf) {
                    return [
                        'id_foods' => $bf->food->id,
                        'name' => $bf->food->name,
                        'quantity' => $bf->quantity,
                    ];
                }),
            ];
        });

        return response()->json(['data' => $data]);
    }


}
