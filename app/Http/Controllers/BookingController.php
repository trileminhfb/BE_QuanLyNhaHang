<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function indexWithDetails()
    {
        try {
            $bookings = DB::table('bookings')
                ->leftJoin('customers', 'bookings.id_cutomer', '=', 'customers.id')
                ->leftJoin('food', 'bookings.id_food', '=', 'food.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->select(
                    'bookings.id',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'customers.FullName as customer_name',
                    'food.name as food_name',
                    'tables.number as table_number',
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
    // public function indexWithDetails()
    // {
    //     try {
    //         $bookings = DB::table('bookings')
    //             ->join('customers', 'bookings.id_cutomer', '=', 'customers.id')
    //             ->select('bookings.*', 'customers.FullName')
    //             ->get();
    //         return response()->json($bookings, 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // Tạo mới một đặt bàn
    public function store(Request $request)
    {
        $booking = Booking::create([
            'id_table'    => $request->id_table,
            'timeBooking' => $request->timeBooking,
            'id_food'     => $request->id_food,
            'quantity'    => $request->quantity,
            'id_cutomer'  => $request->id_cutomer,
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    // Hiển thị thông tin đặt bàn theo ID
    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking, 200);
    }

    // Cập nhật thông tin đặt bàn
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->update([
            'id_table'    => $request->id_table,
            'timeBooking' => $request->timeBooking,
            'id_food'     => $request->id_food,
            'quantity'    => $request->quantity,
            'id_cutomer'  => $request->id_cutomer,
        ]);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ], 200);
    }

    // Xoá đặt bàn theo ID
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
