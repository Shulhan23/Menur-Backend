<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'adminweb@desamenur.com'],
            [
                'name' => 'Admin Website',
                'password' => Hash::make('D35AMENUR2025'),
            ]
        );
    }
}
