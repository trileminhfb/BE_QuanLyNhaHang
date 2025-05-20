<?php

namespace App\Http\Controllers;

use App\Models\CategoryFood;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFoodRequest;
use Illuminate\Support\Facades\DB;

class CategoryFoodController extends Controller
{

    public function getData()
    {
        $data = DB::table('category_foods')
            ->join('categories', 'category_foods.id_category', '=', 'categories.id')
            ->join('foods', 'category_foods.id_food', '=', 'foods.id')
            ->select('category_foods.id', 'categories.name as category_name', 'foods.name as food_name', 'foods.cost', 'foods.detail')
            ->get();

        return response()->json([
            'status' => 1,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {

        if (!isset($request->id_food) || !is_array($request->id_food) || count($request->id_food) < 1) {
            return response()->json([
                'status'  => 0,
                'message' => 'id_food phải là một mảng và chứa ít nhất một phần tử.'
            ], 400);
        }


        if (!isset($request->id_category)) {
            return response()->json([
                'status'  => 0,
                'message' => 'id_category không được để trống.'
            ], 400);
        }


        $categoryFoodData = [];
        foreach ($request->id_food as $foodId) {

            if (!\App\Models\Food::find($foodId)) {
                return response()->json([
                    'status'  => 0,
                    'message' => "Food ID $foodId không tồn tại."
                ], 400);
            }

            $categoryFoodData[] = [
                'id_category' => $request->id_category,
                'id_food'     => $foodId,
            ];
        }


        CategoryFood::insert($categoryFoodData);

        return response()->json([
            'status'  => 1,
            'message' => 'Tạo mới thành công.',
            'data'    => $categoryFoodData
        ], 201);
    }

    public function show($id)
    {
        $item = DB::table('category_foods')
            ->join('categories', 'category_foods.id_category', '=', 'categories.id')
            ->join('foods', 'category_foods.id_food', '=', 'foods.id')
            ->where('category_foods.id', $id)
            ->select('category_foods.id', 'categories.name as category_name', 'foods.name as food_name', 'foods.cost', 'foods.detail')
            ->first(); 

        if (!$item) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy bản ghi.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'data'   => $item
        ]);
    }

    public function update(Request $request, $id)
    {

        $item = CategoryFood::find($id);


        if (!$item) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy bản ghi.'
            ], 404);
        }


        if (!isset($request->id_category)) {
            return response()->json([
                'status'  => 0,
                'message' => 'id_category không được để trống.'
            ], 400);
        }


        if (!isset($request->id_food) || !is_array($request->id_food) || count($request->id_food) < 1) {
            return response()->json([
                'status'  => 0,
                'message' => 'id_food phải là một mảng và chứa ít nhất một phần tử.'
            ], 400);
        }


        foreach ($request->id_food as $foodId) {
            if (!\App\Models\Food::find($foodId)) {
                return response()->json([
                    'status'  => 0,
                    'message' => "Food ID $foodId không tồn tại."
                ], 400);
            }
        }


        $item->foods()->detach();


        foreach ($request->id_food as $foodId) {
            $item->foods()->attach($foodId);
        }


        $item->update([
            'id_category' => $request->id_category
        ]);


        $item->load('foods');

        return response()->json([
            'status'  => 1,
            'message' => 'Cập nhật thành công.',
            'data'    => $item
        ]);
    }

    public function destroy($id)
    {
        $item = CategoryFood::find($id);

        if (!$item) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy bản ghi.'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status'  => 1,
            'message' => 'Xoá thành công.'
        ]);
    }
}
