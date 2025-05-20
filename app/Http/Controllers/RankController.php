<?php

namespace App\Http\Controllers;

use App\Http\Requests\RankRequest;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RankController extends Controller
{
    public function index()
    {
        return response()->json(Rank::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nameRank' => 'required|string|max:255',
            'necessaryPoint' => 'required|integer|min:0',
            'saleRank' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý hình ảnh
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('ranks', 'public');
        }

        $rank = Rank::create([
            'nameRank' => $request->nameRank,
            'necessaryPoint' => $request->necessaryPoint,
            'saleRank' => $request->saleRank,
            'image' => $imageName,
        ]);

        return response()->json([
            'message' => 'Rank created successfully',
            'data' => $rank
        ], 201);
    }


    public function show($id)
    {
        $rank = Rank::find($id);

        if (!$rank) {
            return response()->json(['message' => 'Rank not found'], 404);
        }

        return response()->json($rank, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nameRank' => 'required|string|max:255',
            'necessaryPoint' => 'required|integer|min:0',
            'saleRank' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $rank = Rank::find($id);

        if (!$rank) {
            return response()->json(['message' => 'Rank not found'], 404);
        }

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ranks', 'public');
        } else {
            $imagePath = explode('storage/', $rank->image)[1]; // Giữ ảnh cũ nếu không upload ảnh mới
        }

        $rank->update([
            'nameRank' => $request->nameRank,
            'necessaryPoint' => $request->necessaryPoint,
            'saleRank' => $request->saleRank,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Rank updated successfully',
            'data' => $rank
        ], 200);
    }

    public function destroy($id)
    {
        $rank = Rank::find($id);

        if (!$rank) {
            return response()->json(['message' => 'Rank not found'], 404);
        }

        // Xóa hình ảnh nếu có
        if ($rank->image && Storage::exists('public/' . $rank->image)) {
            Storage::delete('public/' . $rank->image);
        }

        $rank->delete();

        return response()->json(['message' => 'Rank deleted successfully'], 200);
    }
}
