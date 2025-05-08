<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Food;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\RateRequest;

class RateController extends Controller
{
    // Lấy danh sách đánh giá (có luôn thông tin food và customer)
    public function getData()
    {
        $rates = Rate::with(['customer:id,FullName'])->get();

        return response()->json([
            'status' => 1,
            'data'   => $rates,
        ]);
    }

    // Thêm đánh giá mới
    public function store(RateRequest $request)
    {
        if (! Food::find($request->id_food)) {
            return response()->json([
                'status'  => 0,
                'message' => 'Món ăn không tồn tại.',
            ], 400);
        }

        if (! Customer::find($request->id_customer)) {
            return response()->json([
                'status'  => 0,
                'message' => 'Khách hàng không tồn tại.',
            ], 400);
        }

        $rate = Rate::create([
            'id_food'     => $request->id_food,
            'id_customer' => $request->id_customer,
            'star'        => $request->star,
            'detail'      => $request->detail,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Đánh giá đã được thêm thành công.',
            'data'    => $rate->load(['food', 'customer']),
        ]);
    }

    // Cập nhật đánh giá theo ID
    public function update(RateRequest $request, $id)
    {
        $rate = Rate::find($id);

        if (! $rate) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy đánh giá.',
            ], 404);
        }

        if (! Food::find($request->id_food)) {
            return response()->json([
                'status'  => 0,
                'message' => 'Món ăn không tồn tại.',
            ], 400);
        }

        if (! Customer::find($request->id_customer)) {
            return response()->json([
                'status'  => 0,
                'message' => 'Khách hàng không tồn tại.',
            ], 400);
        }

        $rate->update([
            'id_food'     => $request->id_food,
            'id_customer' => $request->id_customer,
            'star'        => $request->star,
            'detail'      => $request->detail,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Đánh giá đã được cập nhật.',
            'data'    => $rate->fresh()->load(['food', 'customer']),
        ]);
    }

    // Xóa đánh giá theo ID
    public function destroy($id)
    {
        $rate = Rate::find($id);

        if (! $rate) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy đánh giá.',
            ], 404);
        }

        $rate->delete();

        return response()->json([
            'status'  => 1,
            'message' => 'Đánh giá đã được xóa.',
        ]);
    }
}
