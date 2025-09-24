<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ReceptionistUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_RECEPTIONIST_EMAIL', 'receptionist@example.com');
        $password = env('SEED_RECEPTIONIST_PASSWORD', 'ChangeMe123!');
        $phone = env('SEED_RECEPTIONIST_PHONE', '+94 71 000 0000');

        $data = [
            'name' => 'Front Desk',
            'email' => $email,
            //'phone' => $phone,
            'password' => Hash::make($password),
            'role' => 'receptionist',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = true;
        }

        $user = User::updateOrCreate(['email' => $email], $data);

        $this->command?->info("Receptionist seeded: {$user->email} / {$password}");
    }
}
