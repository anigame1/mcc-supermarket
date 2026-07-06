<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // This is a known demo/system account, not a real person's login,
        // so it's safe (and desirable) to reset its password back to the
        // documented default on every deploy rather than only creating it
        // once and leaving it untouched.
        Admin::updateOrCreate(
            ['email' => 'admin@mccsupermarket.com'],
            [
                'name' => 'MCC Admin',
                'password' => 'password',
            ],
        );
    }
}
