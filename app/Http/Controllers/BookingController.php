<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingFood;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::with([
                'customer',
                'bookingFoods.food' // eager load food từ bookingFoods
            ])->get();

            return response()->json(['data' => $bookings], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // fix: như cái ni là cần nè, thêm 3 bước
    public function createBooking(Request $request)
    {
        try {
            // Lấy dữ liệu đầu vào mà không cần validate
            $phoneNumber = $request->input('phoneNumber');
            $fullName    = $request->input('FullName');
            $timeBooking = $request->input('timeBooking');
            $status      = $request->input('status');

            // Tạo hoặc tìm Customer
            $customer = Customer::firstOrCreate(
                ['phoneNumber' => $phoneNumber],
                [
                    'FullName' => $fullName,
                    'otp'      => null,
                    'point'    => 0,
                    'id_rank'  => 1,
                ]
            );

            // Tạo booking mới
            $booking = Booking::create([
                'id_customer'  => $customer->id,
                'timeBooking'  => $timeBooking,
                'status'       => $status,
            ]);

            return response()->json([
                'message'  => 'Đặt bàn thành công.',
                'booking'  => $booking,
                'customer' => $customer,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
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

            $validated = $request->validate([
                'phoneNumber'   => 'required|string|max:20',
                'FullName'      => 'required|string|max:255',
                'timeBooking'   => 'required|date_format:Y-m-d H:i:s',
                'quantity'      => 'required|integer|min:1',
                'status'        => 'required|in:1,2,3',
            ]);

            $customer = Customer::firstOrCreate(
                ['phoneNumber' => $validated['phoneNumber']],
                [
                    'FullName' => $validated['FullName'],
                    'otp'      => null,
                    'point'    => 0,
                    'id_rank'  => 1,
                ]
            );

            $customer->update([
                'FullName' => $validated['FullName'],
            ]);

            $booking->update([
                'id_customer'  => $customer->id,
                'timeBooking'  => $validated['timeBooking'],
                'quantity'     => $validated['quantity'],
                'status'       => $validated['status'],
            ]);

            return response()->json([
                'message'  => 'Cập nhật đặt bàn thành công.',
                'booking'  => $booking,
                'customer' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
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
