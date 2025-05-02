<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use App\Http\Requests\RateRequest;

class RateController extends Controller
{
    public function getData()
    {
        $rates = Rate::all();
        return response()->json($rates);
    }

    public function store(RateRequest $request)
    {
        $rate = Rate::create([
            'id_food' => $request->id_food,
            'star'    => $request->star,
            'detail'  => $request->detail,
        ]);

        return response()->json([
            'message' => 'Đánh giá đã được thêm thành công.',
            'data'    => $rate
        ]);
    }

    public function update(RateRequest $request)
    {
        $rate = Rate::where('id', $request->id)->first();

        if (!$rate) {
            return response()->json(['message' => 'Không tìm thấy đánh giá.'], 404);
        }

        $rate->update([
            'id_food' => $request->id_food,
            'star'    => $request->star,
            'detail'  => $request->detail,
        ]);

        return response()->json([
            'message' => 'Đánh giá đã được cập nhật.',
            'data'    => $rate
        ]);
    }

    public function destroy(Request $request)
    {
        $deleted = Rate::where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Đánh giá đã được xóa.']);
        } else {
            return response()->json(['message' => 'Không tìm thấy đánh giá.'], 404);
        }
    }

    public function search(Request $request)
    {
        $rates = Rate::where('id_food', 'like', '%' . $request->keyword . '%')->get();

        return response()->json($rates);
    }
}
