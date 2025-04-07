<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Http\Requests\IngredientRequest;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
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
        Ingredient::create([
            'name_ingredient' => $request->name_ingredient,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Thêm nguyên liệu thành công.'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ingredients,id',
            'name_ingredient' => 'required|string|min:2|max:100|unique:ingredients,name_ingredient,' . $request->id,
        ]);

        Ingredient::where('id', $request->id)->update([
            'name_ingredient' => $request->name_ingredient,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật nguyên liệu thành công.'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ingredients,id',
        ]);

        Ingredient::where('id', $request->id)->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa nguyên liệu thành công.'
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'nullable|string'
        ]);

        $keyword = $request->keyword;

        $ingredients = Ingredient::where('name_ingredient', 'like', '%' . $keyword . '%')->get();

        return response()->json([
            'status' => 1,
            'data' => $ingredients
        ]);
    }
}
