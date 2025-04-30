<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoryPointRequest;
use App\Models\HistoryPoint;
use Illuminate\Http\Request;

class HistoryPointController extends Controller
{
    // Lấy danh sách tất cả lịch sử điểm
    public function index()
    {
        return response()->json(HistoryPoint::all(), 200);
    }

    // Tạo mới lịch sử điểm
    public function store(HistoryPointRequest $request)
    {
        $historyPoint = HistoryPoint::create($request->validated());

        return response()->json([
            'message' => 'History point created successfully',
            'data' => $historyPoint
        ], 201);
    }

    // Hiển thị chi tiết lịch sử điểm theo ID
    public function show($id)
    {
        $historyPoint = HistoryPoint::find($id);

        if (!$historyPoint) {
            return response()->json(['message' => 'History point not found'], 404);
        }

        return response()->json($historyPoint, 200);
    }

    // Cập nhật lịch sử điểm
    public function update(HistoryPointRequest $request, $id)
    {
        $historyPoint = HistoryPoint::find($id);

        if (!$historyPoint) {
            return response()->json(['message' => 'History point not found'], 404);
        }

        $historyPoint->update($request->validated());

        return response()->json([
            'message' => 'History point updated successfully',
            'data' => $historyPoint
        ], 200);
    }

    // Xóa lịch sử điểm theo ID
    public function destroy($id)
    {
        $historyPoint = HistoryPoint::find($id);

        if (!$historyPoint) {
            return response()->json(['message' => 'History point not found'], 404);
        }

        $historyPoint->delete();

        return response()->json(['message' => 'History point deleted successfully'], 200);
    }
}
