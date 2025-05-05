<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'image' => 'manager.jpg',
                'name' => 'Nguyễn Văn A',
                'role' => 'Quản lý',
                'phone_number' => '0911111111',
                'email' => 'manager@example.com',
                'status' => 'active',
                'birth' => '1985-05-15',
                'password' => Hash::make('password123'),
            ],
            [
                'image' => 'chef.jpg',
                'name' => 'Trần Thị B',
                'role' => 'Đầu bếp',
                'phone_number' => '0922222222',
                'email' => 'chef@example.com',
                'status' => 'active',
                'birth' => '1990-08-20',
                'password' => Hash::make('password123'),
            ],
            [
                'image' => 'staff1.jpg',
                'name' => 'Lê Văn C',
                'role' => 'Nhân viên',
                'phone_number' => '0933333333',
                'email' => 'staff1@example.com',
                'status' => 'active',
                'birth' => '1995-03-10',
                'password' => Hash::make('password123'),
            ],
            [
                'image' => 'staff2.jpg',
                'name' => 'Phạm Thị D',
                'role' => 'Nhân viên',
                'phone_number' => '0944444444',
                'email' => 'staff2@example.com',
                'status' => 'active',
                'birth' => '1997-11-25',
                'password' => Hash::make('password123'),
            ],
            [
                'image' => 'admin.jpg',
                'name' => 'Admin',
                'role' => 'Quản trị viên',
                'phone_number' => '0955555555',
                'email' => 'admin@example.com',
                'status' => 'active',
                'birth' => '1980-01-01',
                'password' => Hash::make('admin123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
//         // Thêm một người dùng mẫu
//         DB::table('users')->insert([
//             'name' => 'John Doe',
//             'role' => 'admin',
//             'phone_number' => '0931234567',
//             'email' => 'john@example.com',
//             'status' => 'active',
//             'birth' => '1990-01-01',
//             'email_verified_at' => now(),
//             'password' => Hash::make('password123'), // Mật khẩu đã mã hóa
//             'remember_token' => Str::random(10),
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Thêm nhiều người dùng mẫu
//         DB::table('users')->insert([
//             'name' => 'Jane Smith',
//             'role' => 'user',
//             'phone_number' => '0939876543',
//             'email' => 'jane@example.com',
//             'status' => 'active',
//             'birth' => '1995-05-15',
//             'email_verified_at' => now(),
//             'password' => Hash::make('password123'), // Mật khẩu đã mã hóa
//             'remember_token' => Str::random(10),
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
        // Thêm một người dùng mẫu
        DB::table('users')->updateOrInsert(
            ['phone_number' => '0931234567'], // Điều kiện tồn tại
            [
                'name' => 'John Doe',
                'role' => 'admin',
                'email' => 'john@example.com',
                'status' => 'active',
                'birth' => '1990-01-01',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
