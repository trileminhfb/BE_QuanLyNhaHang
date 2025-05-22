<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách người dùng mẫu
        $users = [
            [
                'image' => 'default/user1.png',
                'name' => 'Lê Minh Trí',
                'role' => 'admin',
                'phone_number' => '0934961544',
                'email' => 'admin@admin.com',
                'status' => 'active',
                'birth' => '1985-05-15',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'default/user2.png',
                'name' => 'Trần Văn Khánh',
                'role' => 'staff',
                'phone_number' => '0922222222',
                'email' => 'chef@example.com',
                'status' => 'active',
                'birth' => '1990-08-20',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'default/user3.png',
                'name' => 'Huỳnh Hiếu',
                'role' => 'staff',
                'phone_number' => '0933333333',
                'email' => 'staff1@example.com',
                'status' => 'active',
                'birth' => '1995-03-10',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'default/user4.png',
                'name' => 'Võ Hưng Tĩnh',
                'role' => 'staff',
                'phone_number' => '0944444444',
                'email' => 'staff2@example.com',
                'status' => 'active',
                'birth' => '1997-11-25',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'default/user5.png',
                'name' => 'Lê Nguyễn Văn Thành Đạt',
                'role' => 'manager',
                'phone_number' => '0955555555',
                'email' => 'admin@example.com',
                'status' => 'active',
                'birth' => '1980-01-01',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'default/user6.png',
                'name' => 'John Doe',
                'role' => 'manager',
                'phone_number' => '0931234567',
                'email' => 'john@example.com',
                'status' => 'active',
                'birth' => '1990-01-01',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'default/user7.png',
                'name' => 'Super Manager',
                'role' => 'manager',
                'phone_number' => '0931234527',
                'email' => 'manager@manager.com',
                'status' => 'active',
                'birth' => '1990-01-01',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Chèn dữ liệu
        foreach ($users as $user) {
            User::updateOrCreate(
                ['phone_number' => $user['phone_number']],
                $user
            );
        }
    }
}
