<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pmiwonosobo.or.id'],
            [
                'name' => 'Admin PMI',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'perawat@pmiwonosobo.or.id'],
            [
                'name' => 'Perawat PMI',
                'password' => Hash::make('password'),
                'role' => 'perawat',
            ]
        );

        $this->call([
            PageSeeder::class,
            MenuSeeder::class,
            FooterSettingSeeder::class,
        ]);
    }
}
