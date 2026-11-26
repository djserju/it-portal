<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('app.admin_password');
        $legacyPasswordHash = '$2y$10$trWE3jZvcYncqX9qi52tKuWvU.RpMUSoDURLekFGImmpNGLREwGKW';

        $admin = User::firstOrCreate(
            ['email' => 'admin@ucc.edu.jm'],
            [
                'name' => 'IT Portal Admin',
                'password' => $password ? Hash::make($password) : $legacyPasswordHash,
            ],
        );

        if ($admin->email_verified_at === null) {
            $admin->forceFill(['email_verified_at' => now()])->save();
        }
    }
}
