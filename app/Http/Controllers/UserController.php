<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminChangePasswordRequest;
use App\Http\Requests\GetUserInforRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Load toàn bộ tài khoản
    public function getData()
    {
        $users = User::all();
        return response()->json([
            'status' => 1,
            'data' => $users
        ]);
    }

    // Thêm mới tài khoản
    public function store(UserRequest $request)
    {
        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        $user = User::create([
            'image' => $path,
            'name' => $request->name,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'status' => $request->status,
            'birth' => $request->birth,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Thêm người dùng thành công.',
            'data' => $user
        ]);
    }

    // Cập nhật tài khoản
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy người dùng.'
            ], 404);
        }

        $path = $user->image;

        if ($request->hasFile('image')) {
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            $path = $request->file('image')->store('images', 'public');
        }

        $data = [
            'image' => $path,
            'name' => $request->name,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'status' => $request->status,
            'birth' => $request->birth,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật thông tin thành công.',
            'data' => $user
        ]);
    }

    // Xóa tài khoản
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy người dùng.'
            ], 404);
        }

        // Xóa ảnh nếu có
        if ($user->image && Storage::exists('public/' . $user->image)) {
            Storage::delete('public/' . $user->image);
        }

        $user->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa người dùng thành công.'
        ]);
    }

    // Đăng nhập
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 1,
                'message' => 'Đăng nhập thành công',
                'key' => $user->createToken('key_admin')->plainTextToken,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'role' => $user->role,
                'status_user' => $user->status,
                'image' => $user->image,
                'birth' => $user->birth,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Tài khoản hoặc mật khẩu không đúng'
            ]);
        }
    }

    // Kiểm tra đăng nhập
    public function checkLogin(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user && $user instanceof \App\Models\User) {
            return response()->json([
                'status' => 1,
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Chưa đăng nhập.',
        ], 401);
    }

    // Đổi mật khẩu
    public function changePasswordProfile(AdminChangePasswordRequest $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\User)) {
            return response()->json([
                'status' => 0,
                'message' => 'Người dùng không hợp lệ.',
            ], 401);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 0,
                'message' => 'Mật khẩu cũ không đúng.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => 'Đổi mật khẩu thành công.',
        ]);
    }

    // Lấy thông tin người dùng
    public function getUserInfo()
    {
        $user = Auth::guard('sanctum')->user();

        if ($user && $user instanceof \App\Models\User) {
            return response()->json([
                'status' => 1,
                'data' => $user->only(['id', 'name', 'email', 'phone_number', 'role', 'status', 'image', 'birth']),
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Có lỗi xảy ra.',
        ], 401);
    }

    // Cập nhật thông tin người dùng
    public function updateUserInfo(GetUserInforRequest $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user && $user instanceof \App\Models\User) {
            $data = $request->only(['name', 'phone_number', 'birth']);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $data['image'] = $imagePath;
            } else {
                if (str_contains($user->image, 'storage/')) {
                    $data['image'] = explode('storage/', $user->image)[1];
                }
            }

            $user->update($data);

            return response()->json([
                'status' => 1,
                'message' => 'Cập nhật thông tin thành công.',
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Có lỗi xảy ra.',
        ], 401);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Đăng xuất thành công.',
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Người dùng không hợp lệ.',
        ], 401);
    }
}
