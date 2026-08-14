<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = env('SUPERADMIN_PASSWORD');
        if (app()->environment('production') && empty($password)) {
            throw new RuntimeException('SUPERADMIN_PASSWORD must be set in production.');
        }

        User::create([
            'name' => "SuperAdmin",
            'email' => "superadmin@gmail.com",
            'password' => Hash::make($password ?: 'password'),
            'email_verified_at' => now(),
        ]);
    }
}
