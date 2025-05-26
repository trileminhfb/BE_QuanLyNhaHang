<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'type',
            'categoryFoods.food'
        ])->get();

        if ($categories->isEmpty()) {
            return response()->json(['message' => '❌ Không tìm thấy danh mục!'], 404);
        }

        return response()->json($categories, 200);
    }


    public function getClient()
    {
        $categories = Category::with([
            'type' => function ($query) {
                $query->where('status', 1);
            },
            'categoryFoods.food' => function ($query) {
                $query->where('status', 1);
            }
        ])
            ->where('status', 1)
            ->get();

        if ($categories->isEmpty()) {
            return response()->json(['message' => '❌ Không tìm thấy danh mục!'], 404);
        }

        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'status', 'id_type']);

        // Tạo mới danh mục
        $category = Category::create($data);

        // Xử lý food_ids nếu có
        if ($request->has('food_ids')) {
            $food_ids = $request->input('food_ids');

            if (is_array($food_ids) && !empty($food_ids)) {
                $foodData = array_filter(array_map(function ($food_id) use ($category) {
                    return DB::table('foods')->where('id', $food_id)->exists() ? [
                        'id_category' => $category->id,
                        'id_food'     => $food_id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ] : null;
                }, $food_ids));

                if ($foodData) {
                    DB::table('category_foods')->insert($foodData);
                }
            }
        }

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

        // Lấy dữ liệu cần update
        $data = $request->only(['name', 'status', 'id_type']);

        // Kiểm tra status có tồn tại và có giá trị hợp lệ không
        if (isset($data['status']) && !in_array($data['status'], [0, 1], true)) {
            return response()->json(['message' => '❌ Giá trị status không hợp lệ, chỉ nhận 0 hoặc 1!'], 400);
        }

        $category->update(array_filter($data, function ($value) {
            return !is_null($value);
        }));

        if ($request->has('food_ids')) {
            $food_ids = $request->input('food_ids');
            DB::table('category_foods')->where('id_category', $id)->delete();

            if (is_array($food_ids) && !empty($food_ids)) {
                $foodData = array_filter(array_map(function ($food_id) use ($id) {
                    return DB::table('foods')->where('id', $food_id)->exists() ? [
                        'id_category' => $id,
                        'id_food' => $food_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ] : null;
                }, $food_ids));

                if ($foodData) {
                    DB::table('category_foods')->insert($foodData);
                }
            }
        }

        return response()->json([
            'message'  => '🎉 Danh mục đã được cập nhật!',
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
