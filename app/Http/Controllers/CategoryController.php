<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Lấy danh sách danh mục
    public function index()
    {
        return response()->json(Category::all(), 200);
    }

    // Tạo mới danh mục
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Category created', 'category' => $category], 201);
    }

    // Lấy danh mục theo ID
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category, 200);
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'string|max:255',
            'status' => 'integer',
        ]);

        $category->update($request->only('name', 'status'));
        return response()->json(['message' => 'Category updated', 'category' => $category], 200);
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted'], 200);
    }
}
