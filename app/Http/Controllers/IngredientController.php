<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Http\Requests\IngredientRequest;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    // Lấy danh sách tất cả nguyên liệu
    public function getData()
    {
        $ingredients = Ingredient::all();

        return response()->json([
            'status' => 1,
            'data' => $ingredients
        ]);
    }

    public function store(IngredientRequest $request)
    {
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('ingredients', 'public');
        }

        $ingredient = Ingredient::create([
            'name_ingredient' => $request->name_ingredient,
            'image'           => $imageName ?? null,
            'unit'            => $request->unit,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Thêm nguyên liệu thành công.',
            'data' => $ingredient
        ]);
    }

    public function update(Request $request, $id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return response()->json([
                'status' => 0,
                'message' => 'Nguyên liệu không tồn tại.'
            ]);
        }

        $imagePath = $ingredient->image;

        if ($request->originImg != $imagePath) {
            $imagePath = $request->file('image')->store('ingredients', 'public');
        }
        $ingredient->update([
            'name_ingredient' => $request->name_ingredient,
            'image'           => trim($imagePath, 'storage/'[1]),
            'unit'            => $request->unit,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật nguyên liệu thành công.',
            'data' => $ingredient
        ]);
    }

    // Xóa nguyên liệu theo ID
    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return response()->json([
                'status' => 0,
                'message' => 'Nguyên liệu không tồn tại.'
            ]);
        }

        $ingredient->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa nguyên liệu thành công.'
        ]);
    }

    // Tìm kiếm nguyên liệu theo tên
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $ingredients = Ingredient::when($keyword, function ($query, $keyword) {
            return $query->where('name_ingredient', 'like', '%' . $keyword . '%');
        })->get();

        return response()->json([
            'status' => 1,
            'data' => $ingredients
        ]);
    }
}
