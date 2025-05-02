<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

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
        $user = User::create([
            'image'         => $request->image,
            'name'          => $request->name,
            'role'          => $request->role,
            'phone_number'  => $request->phone_number,
            'email'         => $request->email,
            'status'        => $request->status,
            'birth'         => $request->birth,
            'password'      => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Thêm người dùng thành công.',
            'data'    => $user
        ]);
    }

    // Cập nhật tài khoản
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy người dùng.'
            ], 404);
        }

        $data = [
            'image'         => $request->image,
            'name'          => $request->name,
            'role'          => $request->role,
            'phone_number'  => $request->phone_number,
            'email'         => $request->email,
            'status'        => $request->status,
            'birth'         => $request->birth,
        ];

        // Chỉ mã hóa mật khẩu nếu người dùng truyền vào
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật người dùng thành công.',
            'data'    => $user
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

        $user->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa người dùng thành công.'
        ]);
    }

    // Tìm kiếm tài khoản theo tên
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::where('name', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json([
            'status' => 1,
            'data' => $users
        ]);
    }
}
