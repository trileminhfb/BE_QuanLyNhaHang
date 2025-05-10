<?php

namespace App\Http\Controllers;

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

            $phoneNumber = $request->input('phoneNumber');
            $fullName    = $request->input('FullName');
            $timeBooking = $request->input('timeBooking');
            $status      = $request->input('status', 1);


            if (!$phoneNumber) {
                return response()->json(['message' => 'Phone number is required'], 400);
            }


            $customer = Customer::firstOrCreate(
                ['phoneNumber' => $phoneNumber],
                [
                    'FullName' => $fullName,
                    'otp'      => null,
                    'point'    => 0,
                    'id_rank'  => 1,
                ]
            );


            $booking = Booking::create([
                'id_customer'  => $customer->id,
                'timeBooking'  => $timeBooking,
                'status'       => $status,
            ]);

            return response()->json([
                'message'  => 'Booking created successfully.',
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

                // Nếu có fullName thì cập nhật lại tên
                if ($fullName) {
                    $customer->update([
                        'FullName' => $fullName,
                    ]);
                }

                $booking->id_customer = $customer->id;
            }

            // Cập nhật các trường booking nếu có truyền lên
            if ($timeBooking) {
                $booking->timeBooking = $timeBooking;
            }

            if ($status) {
                $booking->status = $status;
            }

            $booking->save();

            return response()->json([
                'message'  => 'Cập nhật đặt bàn thành công.',
                'booking'  => $booking,
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
}
