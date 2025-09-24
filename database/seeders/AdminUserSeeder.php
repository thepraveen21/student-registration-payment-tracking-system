<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_ADMIN_EMAIL', 'admin@example.com');
        $password = env('SEED_ADMIN_PASSWORD', 'ChangeMe123!');
        $phone = env('SEED_ADMIN_PHONE', '+94 70 000 0000');

        $data = [
            'name' => 'System Admin',
            'email' => $email,
            //'phone' => $phone,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        // Add status only if the column exists
        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = true;
        }

        $user = User::updateOrCreate(['email' => $email], $data);

        $this->command?->info("Admin seeded: {$user->email} / {$password}");
    }
}
