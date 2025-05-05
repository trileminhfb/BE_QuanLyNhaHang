<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = DB::table('bookings')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')  // Sửa từ 'food' thành 'foods'
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->select(
                    'bookings.id',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'customers.FullName as customer_name',
                    'foods.name as food_name',  // Sửa từ 'food' thành 'foods'
                    'tables.number as table_number',
                    'bookings.created_at',
                    'bookings.updated_at'
                );

            if ($request->has('id')) {
                $query->where('bookings.id', $request->id);
            }

            $bookings = $query->get();

            return response()->json(['data' => $bookings], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'table_number'  => 'required|integer',
            'food_name'     => 'required|string',
            'timeBooking'   => 'required|date',
            'quantity'      => 'required|integer|min:1',
        ]);

        // Lấy ID từ tên khách
        $customer = DB::table('customers')
            ->whereRaw('LOWER(FullName) = ?', [strtolower($request->customer_name)])
            ->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Lấy ID từ số bàn
        $table = DB::table('tables')
            ->where('number', $request->table_number)
            ->first();

        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        // Lấy ID từ tên món (sửa từ 'food' thành 'foods' nếu cần)
        $food = DB::table('foods')  // Đã sửa tên bảng thành 'foods'
            ->whereRaw('LOWER(name) = ?', [strtolower($request->food_name)])
            ->first();

        if (!$food) {
            return response()->json(['error' => 'Food not found'], 404);
        }

        // Tạo booking
        $booking = Booking::create([
            'id_table'    => $table->id,
            'timeBooking' => $request->timeBooking,
            'id_food'     => $food->id,
            'quantity'    => $request->quantity,
            'id_customer' => $customer->id,
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // Tìm booking theo ID
        $booking = Booking::find($id);

        // Kiểm tra xem booking có tồn tại không
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Validate request input
        $request->validate([
            'customer_name' => 'required|string',
            'table_number'  => 'required|integer',
            'food_name'     => 'required|string',
            'timeBooking'   => 'required|date',
            'quantity'      => 'required|integer|min:1',
        ]);

        // Lấy ID từ tên khách
        $customer = DB::table('customers')
            ->whereRaw('LOWER(FullName) = ?', [strtolower($request->customer_name)])
            ->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Lấy ID từ số bàn
        $table = DB::table('tables')
            ->where('number', $request->table_number)
            ->first();
        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        // Lấy ID từ tên món
        $food = DB::table('foods')  // Đã sửa tên bảng thành 'foods'
            ->whereRaw('LOWER(name) = ?', [strtolower($request->food_name)])
            ->first();
        if (!$food) {
            return response()->json(['error' => 'Food not found'], 404);
        }

        // Cập nhật booking
        $booking->update([
            'id_table'    => $table->id,
            'timeBooking' => $request->timeBooking,
            'id_food'     => $food->id,
            'quantity'    => $request->quantity,
            'id_customer' => $customer->id,
        ]);

        // Trả về thông tin booking sau khi cập nhật
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
