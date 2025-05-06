<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::with(['type', 'categoryFoods.food'])->get();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'status'   => 'required|integer',
            'id_type'  => 'nullable|integer',
        ]);

        $category = Category::create($data);

        return response()->json([
            'message'  => '🎉 Danh mục đã được tạo thành công!',
            'category' => $category,
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => '❌ Không tìm thấy danh mục!'], 404);
        }

        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => '❌ Không tìm thấy danh mục!'], 404);
        }

        $data = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'status'   => 'sometimes|integer',
            'id_type'  => 'nullable|integer',
        ]);

        $category->update($data);

        return response()->json([
            'message'  => '✅ Danh mục đã được cập nhật!',
            'category' => $category,
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => '❌ Không tìm thấy danh mục!'], 404);
        }

        $category->delete();

        return response()->json(['message' => '🗑️ Danh mục đã được xóa!'], 200);
    }
}
