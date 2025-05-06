<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use App\Http\Requests\RateRequest;
use App\Models\Food;

class RateController extends Controller
{
    // Lấy danh sách đánh giá
    public function getData()
    {
        $rates = Rate::all();

        return response()->json([
            'status' => 1,
            'data' => $rates
        ]);
    }

    // Thêm đánh giá mới
    public function store(RateRequest $request)
    {
        $food = Food::find($request->id_food);
        if (!$food) {
            return response()->json([
                'status'  => 0,
                'message' => 'Món ăn không tồn tại.'
            ], 400);
        }

        $rate = Rate::create([
            'id_food' => $request->id_food,
            'star'    => $request->star,
            'detail'  => $request->detail,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Đánh giá đã được thêm thành công.',
            'data'    => $rate
        ]);
    }

    // Cập nhật đánh giá theo ID
    public function update(RateRequest $request, $id)
    {
        $rate = Rate::find($id);

        if (!$rate) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy đánh giá.'
            ]);
        }

        $rate->update([
            'id_food' => $request->id_food,
            'star'    => $request->star,
            'detail'  => $request->detail,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Đánh giá đã được cập nhật.',
            'data'    => $rate
        ]);
    }

    // Xóa đánh giá theo ID
    public function destroy($id)
    {
        $rate = Rate::find($id);

        if (!$rate) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy đánh giá.'
            ]);
        }

        $rate->delete();

        return response()->json([
            'status'  => 1,
            'message' => 'Đánh giá đã được xóa.'
        ]);
    }
}
