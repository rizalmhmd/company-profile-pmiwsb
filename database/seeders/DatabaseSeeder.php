<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin PMI',
            'email' => 'admin@pmiwonosobo.or.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Perawat PMI',
            'email' => 'perawat@pmiwonosobo.or.id',
            'password' => Hash::make('password'),
            'role' => 'perawat',
        ]);
    }
}
