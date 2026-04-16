<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo các Roles (Vai trò)
        // Dùng firstOrCreate để chạy Seeder nhiều lần không bị lỗi trùng lặp
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);

        // 2. Tạo tài khoản Super Admin mặc định
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@cellphones.local'], // Điều kiện tìm kiếm
            [
                'name' => 'Quản Trị Viên',
                'password' => Hash::make('password123'), // Hash password để bảo mật
                'email_verified_at' => now(),
            ]
        );

        // 3. Gán Role Admin cho tài khoản vừa tạo
        $adminUser->assignRole($adminRole);
    }
}
