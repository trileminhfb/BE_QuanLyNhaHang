<?php

namespace App\Http\Controllers;

use App\Models\ReviewManagement;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewManagementRequest;

class ReviewManagementController extends Controller
{
    // Lấy danh sách tất cả bình luận
    public function getData()
    {
        $reviews = ReviewManagement::all();
        return response()->json($reviews);
    }

    // Thêm bình luận
    public function store(ReviewManagementRequest $request)
    {
        $review = ReviewManagement::create([
            'id_rate' => $request->id_rate,
            'id_user' => $request->id_user,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Thêm bình luận thành công.',
            'data' => $review
        ]);
    }

    // Cập nhật bình luận
    public function update(ReviewManagementRequest $request)
    {
        $review = ReviewManagement::find($request->id);

        if (!$review) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy bình luận.'
            ]);
        }

        $review->update([
            'id_rate' => $request->id_rate,
            'id_user' => $request->id_user,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật bình luận thành công.',
            'data' => $review
        ]);
    }

    // Xóa bình luận
    public function destroy(Request $request)
    {
        $review = ReviewManagement::find($request->id);

        if (!$review) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy bình luận.'
            ]);
        }

        $review->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa bình luận thành công.'
        ]);
    }
}
