<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::with('rank')->get();

            return response()->json([
                'customers' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Xử lý ảnh base64 nếu có
        if ($request->filled('image_base64')) {
            $imageData = $request->image_base64;

            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $image = substr($imageData, strpos($imageData, ',') + 1);
                $image = base64_decode($image);
                $extension = strtolower($type[1]);
                $imageName = 'customer_' . time() . '.' . $extension;
                Storage::disk('public')->put("images/{$imageName}", $image);
                $data['image'] = "images/{$imageName}";
            }
        }

        // Xử lý ảnh nếu upload bằng form-data (file)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        $otp = rand(100000, 999999); // Tạo OTP

        $customer = Customer::create([
            'mail' => $request->mail,
            'FullName' => $request->FullName,
            'phoneNumber' => $request->phoneNumber,
            'birth' => $request->birth,
            'image' => $data['image'] ?? null,
            'password' => isset($request->password) ? Hash::make($request->password) : null,
            'otp' => $otp,
            'point' => 0,
            'id_rank' => 1,
            'isActive' => false,
        ]);

        // Gửi OTP qua email
        Mail::to($request->mail)->send(new OtpMail($otp, $request->FullName));

        return response()->json([
            'message' => 'Đăng ký thành công. Vui lòng xác nhận OTP được gửi qua email.',
            'id' => $customer->id
        ], 201);
    }

    public function show($id)
    {

        $customer = Customer::with('rank')->find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng'
            ], 404);
        }

        return response()->json([
            'message' => 'Khách hàng đã được lấy thành công',
            'customer' => $customer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json([
                    'message' => 'Không tìm thấy khách hàng'
                ], 404);
            }

            // Validate dữ liệu đầu vào
            $validated = $request->validate([
                'phoneNumber' => 'nullable|string|unique:customers,phoneNumber,' . $id,
                'FullName' => 'nullable|string|max:255',
                'otp' => 'nullable|string|max:6',
                'point' => 'nullable|integer',
                'id_rank' => 'nullable|integer',
                'mail' => 'nullable|email|max:255',
                'birth' => 'nullable|date',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|string|min:6|confirmed',
                'image_base64' => 'nullable|string', // Thêm validation cho image_base64    
            ]);

            $data = $validated;

            // Xử lý ảnh base64 nếu có
            if ($request->filled('image_base64')) {
                $imageData = $request->image_base64;
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $image = substr($imageData, strpos($imageData, ',') + 1);
                    $image = base64_decode($image);
                    $extension = strtolower($type[1]);
                    $imageName = 'customer_' . time() . '.' . $extension;
                    Storage::disk('public')->put("images/{$imageName}", $image);
                    $data['image'] = "images/{$imageName}";

                    // Xóa ảnh cũ nếu có
                    if ($customer->image) {
                        Storage::disk('public')->delete($customer->image);
                    }
                }
            } elseif ($request->hasFile('image')) {
                // Xử lý ảnh upload qua file
                $imagePath = $request->file('image')->store('images', 'public');
                $data['image'] = $imagePath;

                // Xóa ảnh cũ nếu có
                if ($customer->image) {
                    Storage::disk('public')->delete($customer->image);
                }
            } else {
                // Giữ ảnh cũ nếu không có ảnh mới
                $data['image'] = $customer->image;
            }

            // Cập nhật mật khẩu nếu có
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Cập nhật khách hàng
            $customer->update($data);

            DB::commit();

            return response()->json([
                'message' => 'Khách hàng đã được cập nhật thành công',
                'customer' => $customer
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng'
            ], 404);
        }

        // Xóa ảnh khi xóa khách hàng
        if ($customer->image) {
            Storage::disk('public')->delete($customer->image);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Khách hàng đã được xóa thành công'
        ], 200);
    }

    public function addPoint(Request $request, $id)
    {
        $request->validate([
            'point' => 'required|integer|min:1',   // số điểm cần cộng, tối thiểu 1
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json([
                    'message' => 'Không tìm thấy khách hàng'
                ], 404);
            }

            // + Điểm
            $customer->point += $request->point;

            /** ------------ Cập nhật rank tự động ------------ */
            $newRankId = 1;

            if ($customer->point >= 1000) {
                $newRankId = 4;          // VIP
            } elseif ($customer->point >= 500) {
                $newRankId = 3;          // Vàng
            } elseif ($customer->point >= 200) {
                $newRankId = 2;          // Bạc
            }

            $customer->id_rank = $newRankId;
            /** ----------------------------------------------- */

            $customer->save();

            DB::commit();

            return response()->json([
                'message'  => 'Cộng điểm & cập nhật rank thành công',
                'customer' => $customer
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi: ' . $th->getMessage()
            ], 500);
        }
    }
}
