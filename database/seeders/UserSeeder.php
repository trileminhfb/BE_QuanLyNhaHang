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
                'image' => 'manager.jpg',
                'name' => 'Nguyễn Văn A',
                'role' => 'admin',
                'phone_number' => '0911111111',
                'email' => 'manager@example.com',
                'status' => 'active',
                'birth' => '1985-05-15',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'chef.jpg',
                'name' => 'Trần Thị B',
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
                'image' => 'staff1.jpg',
                'name' => 'Lê Văn C',
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
                'image' => 'staff2.jpg',
                'name' => 'Phạm Thị D',
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
                'image' => 'admin.jpg',
                'name' => 'Admin',
                'role' => 'admin',
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
                'image' => 'default.jpg',
                'name' => 'John Doe',
                'role' => 'admin',
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
                'image' => 'default.jpg',
                'name' => 'Super Admin',
                'role' => 'admin',
                'phone_number' => '0931234527',
                'email' => 'admin@admin.com',
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
