<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Lấy danh sách tất cả các đặt bàn
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings, 200);
    }

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
