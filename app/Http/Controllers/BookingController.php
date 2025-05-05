<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
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
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->select(
                    'bookings.id',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'customers.*',
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
    public function store(BookingRequest $request)
    {
        try {
            // Lưu đặt bàn vào cơ sở dữ liệu
            $booking = Booking::create($request->validated());

            return response()->json([
                'message' => 'Đặt bàn thành công.',
                'booking' => $booking
            ], 201);  // Trả về status 201 (Created)
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);  // Trả về lỗi 500 nếu có lỗi
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
        // Tìm booking theo ID
        $booking = Booking::find($id);
    
        // Nếu không tìm thấy
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
    
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'id_table'    => 'required|integer|exists:tables,id', // giả sử bảng tables có id
            'timeBooking' => 'required|date_format:Y-m-d H:i:s',
            'quantity'    => 'required|integer|min:1',
            'id_customer' => 'required|integer|exists:customers,id', // giả sử bảng customers có id
        ]);
    
        // Cập nhật booking
        $booking->update($validated);
    
        // Trả về kết quả
        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ], 200);
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
