<?php

namespace App\Http\Controllers;

use App\Models\ReviewManagement;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewManagementRequest;

class ReviewManagementController extends Controller
{
    public function getData()
    {
        $reviews = ReviewManagement::all();
        return response()->json($reviews);
    }

    public function store(ReviewManagementRequest $request)
    {
        $review = ReviewManagement::create([
            'id_rate' => $request->id_rate,
            'id_user' => $request->id_user,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Thêm bình luận thành công.',
            'data'    => $review
        ]);
    }

    public function update(ReviewManagementRequest $request)
    {
        $review = ReviewManagement::where('id', $request->id)->first();

        if (!$review) {
            return response()->json(['message' => 'Không tìm thấy bình luận.'], 404);
        }

        $review->update([
            'id_rate' => $request->id_rate,
            'id_user' => $request->id_user,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Cập nhật bình luận thành công.',
            'data'    => $review
        ]);
    }

    public function destroy(Request $request)
    {
        $deleted = ReviewManagement::where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Xóa bình luận thành công.']);
        } else {
            return response()->json(['message' => 'Không tìm thấy bình luận.'], 404);
        }
    }

    public function search(Request $request)
    {
        $reviews = ReviewManagement::where('comment', 'like', '%' . $request->keyword . '%')->get();

        return response()->json($reviews);
    }
}
