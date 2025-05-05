<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoongkingFoodRequest;
use App\Models\BookingFood;
use Illuminate\Http\Request;

class BoongkingFoodController extends Controller
{
    /**
     * Hiển thị danh sách các món ăn trong booking.
     */
    public function index()
    {
        $foods = BookingFood::all();  // Lấy tất cả dữ liệu từ bảng boongking_foods
        return response()->json($foods);
    }

    /**
     * Lưu thông tin món ăn vào bảng boongking_foods.
     */ public function store(StoreBoongkingFoodRequest $request)
    {
        try {
            $validatedData = $request->all();  // Skipping validation for now

            $boongkingFood = BookingFood::create($validatedData);

            return response()->json([
                'message' => 'Dữ liệu đã được lưu thành công!',
                'data' => $boongkingFood
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hiển thị chi tiết một món ăn cụ thể theo ID.
     */
    public function show($id)
    {
        $boongkingFood = BookingFood::find($id);  // Tìm món ăn theo ID

        if (!$boongkingFood) {
            return response()->json(['message' => 'Không tìm thấy món ăn!'], 404);
        }

        return response()->json($boongkingFood);
    }

    /**
     * Cập nhật thông tin món ăn.
     */
    public function update(StoreBoongkingFoodRequest $request, $id)
    {
        $boongkingFood = BookingFood::find($id);  // Tìm món ăn theo ID

        if (!$boongkingFood) {
            return response()->json(['message' => 'Không tìm thấy món ăn để cập nhật!'], 404);
        }

        // Xác thực dữ liệu
        $validatedData = $request->validated();

        // Cập nhật dữ liệu
        $boongkingFood->update($validatedData);

        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $boongkingFood
        ]);
    }

    /**
     * Xóa món ăn khỏi bảng boongking_foods.
     */
    public function destroy($id)
    {
        $boongkingFood = BookingFood::find($id);  // Tìm món ăn theo ID

        if (!$boongkingFood) {
            return response()->json(['message' => 'Không tìm thấy món ăn để xóa!'], 404);
        }

        // Xóa món ăn
        $boongkingFood->delete();

        return response()->json(['message' => 'Món ăn đã được xóa thành công!']);
    }
}
