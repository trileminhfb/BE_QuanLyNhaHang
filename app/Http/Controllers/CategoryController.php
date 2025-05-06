<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Lấy danh sách danh mục
    public function index()
    {
        $categories = Category::with(['types', 'categoryFoods.food'])->get();

        return response()->json($categories, 200);
    }


    // Tạo mới danh mục
    public function store(CategoryRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'id_type' => 'nullable|integer',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'id_type' => $request->id_type,
        ]);

        return response()->json(['message' => 'Danh mục đã được tạo', 'category' => $category], 201);
    }

    // Lấy danh mục theo ID
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tìm thấy'], 404);
        }
        return response()->json($category, 200);
    }

    // Cập nhật danh mục
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tìm thấy'], 404);
        }

        $request->validate([
            'name' => 'string|max:255',
            'status' => 'integer',
            'id_type' => 'nullable|integer',
        ]);

        $category->update($request->only('name', 'status', 'id_type'));
        return response()->json(['message' => 'Danh mục đã được cập nhật', 'category' => $category], 200);
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tìm thấy'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Danh mục đã bị xóa'], 200);
    }
}
