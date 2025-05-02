<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function getData()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name'          => $request->name,
            'role'          => $request->role,
            'phone_number'  => $request->phone_number,
            'email'         => $request->email,
            'status'        => $request->status,
            'birth'         => $request->birth,
            'password'      => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Thêm người dùng thành công.',
            'data'    => $user
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng.'], 404);
        }

        $user->update([
            'name'          => $request->name,
            'role'          => $request->role,
            'phone_number'  => $request->phone_number,
            'email'         => $request->email,
            'status'        => $request->status,
            'birth'         => $request->birth,
            'password'      => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Cập nhật người dùng thành công.',
            'data'    => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Xóa người dùng thành công.']);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::where('name', 'like', '%' . $keyword . '%')
                     ->orWhere('email', 'like', '%' . $keyword . '%')
                     ->get();

        return response()->json($users);
    }
}
