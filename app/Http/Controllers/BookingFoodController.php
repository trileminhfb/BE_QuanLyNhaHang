<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoongkingFoodRequest;
use App\Models\booking_food;
use Illuminate\Http\Request;

class BookingFoodController extends Controller
{

    public function index()
    {
        $foods = booking_food::with('food')->get();
        return response()->json($foods);
    }

    public function store(Request $request)
    {
        $data = $request->only(['id_booking', 'id_foods', 'quantity']);

        $bookingFood = booking_food::create($data);

        return response()->json([
            'message' => '✅ Đã lưu món ăn vào booking!',
            'data'    => $bookingFood
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
                'message' => '❌ Không tìm thấy món ăn để xóa!'
            ], 404);
        }

        $bookingFood->delete();

        return response()->json([
            'message' => '✅ Món ăn đã được xóa thành công!'
        ]);
    }
    
}
