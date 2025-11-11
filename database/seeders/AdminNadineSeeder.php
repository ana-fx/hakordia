<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminNadineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Nadine',
            'email' => 'admin@nadine.com',
            'password' => Hash::make('Hakordia.gg123'),
            'is_admin' => true,
        ]);
    }
}

