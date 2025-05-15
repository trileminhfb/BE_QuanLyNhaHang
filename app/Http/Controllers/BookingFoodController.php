<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoongkingFoodRequest;
use App\Models\booking_food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingFoodController extends Controller
{

    public function index()
    {
        $foods = booking_food::with('food')->get();
        return response()->json($foods);
    }

    public function store(Request $request)
    {
        // Bước 1: Kiểm tra dữ liệu đầu vào
        $request->validate([
            'id_booking' => 'required|exists:bookings,id',
            'foods' => 'required|array|min:1',
            'foods.*.id_foods' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|integer|min:1',
        ]);

        // Bước 2: Duyệt từng món ăn và lưu vào bảng booking_foods
        foreach ($request->foods as $food) {
            DB::table('booking_foods')->insert([
                'id_booking' => $request->id_booking,
                'id_foods' => $food['id_foods'],
                'quantity' => $food['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Bước 3: Trả về kết quả
        return response()->json([
            'message' => 'Đặt món thành công!'
        ], 201);
    }

    public function show($id)
    {
        $bookingFood = booking_food::with('food')->find($id);

        if (!$bookingFood) {
            return response()->json(['message' => '❌ Không tìm thấy món ăn đã đặt!'], 404);
        }

        return response()->json($bookingFood);
    }

    public function update(Request $request, $id)
    {
        $bookingFood = booking_food::find($id);

        if (!$bookingFood) {
            return response()->json(['message' => ' Không tìm thấy món ăn để cập nhật!'], 404);
        }

        $data = $request->only(['id_booking', 'id_food', 'quantity']);

        $bookingFood->update($data);

        return response()->json([
            'message' => ' Dữ liệu đã được cập nhật thành công!',
            'data'    => $bookingFood
        ]);
    }

    public function destroy($id)
    {
        $bookingFood = booking_food::find($id);

        if (!$bookingFood) {
            return response()->json([
                'message' => ' Không tìm thấy món ăn để xóa!'
            ], 404);
        }
        $bookingFood->delete();

        return response()->json([
            'message' => ' Món ăn đã được xóa thành công!'
        ]);
    }

}
