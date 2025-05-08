<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = DB::table('bookings')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')
                ->select(
                    'bookings.id',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'customers.*',
                    'bookings.created_at',
                    'bookings.updated_at'
                )
                ->get();

            return response()->json(['data' => $bookings], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            // Validate request đầu vào
            $validated = $request->validate([
                'phoneNumber'   => 'required|string|max:20',
                'FullName'      => 'required|string|max:255',
                'timeBooking'   => 'required|date_format:Y-m-d H:i:s',
                'quantity'      => 'required|integer|min:1',
            ]);

            // Khi tạo customer:
            $customer = Customer::firstOrCreate(
                ['phoneNumber' => $validated['phoneNumber']],
                [
                    'FullName' => $validated['FullName'],
                    'otp'      => null,
                    'point'    => 0,
                    'id_rank'  => 1,
                ]
            );

            // Tạo booking mới
            $booking = Booking::create([
                'id_customer'  => $customer->id,
                'timeBooking'  => $validated['timeBooking'],
                'quantity'     => $validated['quantity'],
            ]);

            return response()->json([
                'message' => 'Đặt bàn thành công.',
                'booking' => $booking,
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
        // Tìm booking theo ID
        $booking = Booking::find($id);

        // Kiểm tra xem booking có tồn tại không
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            // Tìm booking theo ID
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            // Validate dữ liệu đầu vào
            $validated = $request->validate([
                'phoneNumber'   => 'required|string|max:20',
                'FullName'      => 'required|string|max:255',
                'timeBooking'   => 'required|date_format:Y-m-d H:i:s',
                'quantity'      => 'required|integer|min:1',
            ]);

            // Tìm hoặc tạo Customer
            $customer = Customer::firstOrCreate(
                ['phoneNumber' => $validated['phoneNumber']],
                [
                    'FullName' => $validated['FullName'],
                    'otp'      => null,
                    'point'    => 0,
                    'id_rank'  => 1,
                ]
            );

            // Cập nhật thông tin Customer (nếu đã tồn tại)
            $customer->update([
                'FullName' => $validated['FullName'],
            ]);

            // Cập nhật thông tin Booking
            $booking->update([
                'id_customer'  => $customer->id,
                'timeBooking'  => $validated['timeBooking'],
                'quantity'     => $validated['quantity'],
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
