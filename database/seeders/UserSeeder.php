<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Thêm một người dùng mẫu
        DB::table('users')->insert([
            'name' => 'John Doe',
            'role' => 'admin',
            'phone_number' => '0931234567',
            'email' => 'john@example.com',
            'status' => 'active',
            'birth' => '1990-01-01',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Mật khẩu đã mã hóa
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Thêm nhiều người dùng mẫu
        DB::table('users')->insert([
            'name' => 'Jane Smith',
            'role' => 'user',
            'phone_number' => '0939876543',
            'email' => 'jane@example.com',
            'status' => 'active',
            'birth' => '1995-05-15',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Mật khẩu đã mã hóa
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
