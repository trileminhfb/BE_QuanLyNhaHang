<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{

    public function index()
    {
        $foods = Food::with(['type:id,name', 'categories:id,name'])->get();

        $formatted = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->name,
                'id_type' => $food->id_type,
                'image' => $food->image,
                'bestSeller' => $food->bestSeller,
                'cost' => $food->cost,
                'detail' => $food->detail,
                'status' => $food->status,
                'created_at' => $food->created_at,
                'updated_at' => $food->updated_at,

                'type' => $food->type ? ['id' => $food->type->id, 'name' => $food->type->name] : null,
                'categories' => $food->categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->all()
            ];
        });

        return response()->json($formatted);
    }

    public function getFood(Request $request)
    {
        $status = $request->query('status');
        $bestSeller = $request->query('bestSeller');

        $query = Food::with(['type:id,name', 'categories:id,name']);

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        if (!is_null($bestSeller)) {
            $query->where('bestSeller', $bestSeller);
        }

        $foods = $query->get();

        $formatted = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->name,
                'id_type' => $food->id_type,
                'image' => $food->image,
                'bestSeller' => $food->bestSeller,
                'cost' => $food->cost,
                'detail' => $food->detail,
                'status' => $food->status,
                'created_at' => $food->created_at,
                'updated_at' => $food->updated_at,
                'type' => $food->type ? ['id' => $food->type->id, 'name' => $food->type->name] : null,
                'categories' => $food->categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->all()
            ];
        });

        return response()->json($formatted);
    }
    public function show($id)
    {
        $food = Food::with(['type', 'categories'])->find($id);

        if (!$food) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        return response()->json($food);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Kiểm tra và xử lý hình ảnh nếu có
        if ($request->hasFile('image')) {
            // Đảm bảo rằng file là hình ảnh và không vượt quá kích thước cho phép
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Lưu file vào thư mục public/storage (có thể điều chỉnh đường dẫn lưu tùy ý)
            $imagePath = $request->file('image')->store('images', 'public');

            // Thêm đường dẫn của hình ảnh vào mảng dữ liệu
            $data['image'] = $imagePath;
        }

        // Tách category_ids ra vì nó không phải cột trong bảng foods
        $categoryIds = $data['category_ids'] ?? [];
        if (is_string($categoryIds)) {
            $categoryIds = explode(',', $categoryIds);
        }
        $categoryIds = array_map('intval', $categoryIds);

        unset($data['category_ids']); // Xóa category_ids khỏi mảng dữ liệu

        // Kiểm tra xem món ăn đã tồn tại chưa
        $existingFood = Food::where('name', $data['name'])->first();

        if ($existingFood) {
            // Nếu món ăn đã tồn tại, bạn có thể cập nhật bản ghi này thay vì tạo mới
            $existingFood->update($data);
            $food = $existingFood;
        } else {
            // Nếu món ăn chưa tồn tại, tạo mới bản ghi
            try {
                $food = Food::create($data); // Tạo bản ghi mới trong bảng foods
            } catch (\Exception $e) {
                // Xử lý lỗi nếu có khi lưu vào cơ sở dữ liệu
                return response()->json([
                    'message' => 'Tạo không thành công',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        // Gán category nếu có
        if (!empty($categoryIds)) {
            try {
                $food->categories()->sync($categoryIds); // Gán các category cho food
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Lỗi khi gán category',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        // Trả về phản hồi JSON với dữ liệu food đã được tạo hoặc cập nhật
        return response()->json([
            'message' => 'Tạo thành công',
            'data' => $food->load('type:id,name', 'categories:id,name')
        ], 201);
    }

    public function activeSales()
    {
        $activeSales = Food::where('status', 1)->get();

        return response()->json([
            'status' => 1,
            'data' => $activeSales
        ]);
    }

    public function update(Request $request, $id)
    {
        // Tìm món ăn theo id
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        // Lấy dữ liệu từ request
        $data = $request->all();

        // Kiểm tra nếu có file hình ảnh mới được upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Lưu file vào thư mục storage/app/public/images
            $data['image'] = $imagePath;
        }

        // Tách category_ids ra vì nó không phải là cột của bảng foods
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        // Cập nhật thông tin món ăn
        try {
            $food->update($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Cập nhật không thành công',
                'error' => $e->getMessage()
            ], 500);
        }

        // Gán lại các category cho food (xóa cũ, thêm mới)
        try {
            $food->categories()->sync($categoryIds);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi gán category',
                'error' => $e->getMessage()
            ], 500);
        }

        // Trả về phản hồi thành công
        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $food->load('type:id,name', 'categories:id,name')
        ], 200);
    }

    public function destroy($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        $food->categories()->detach();
        $food->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
