<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')
            ->where('slug', 'registrasi')
            ->update([
                'slug' => 'jadwal-dokter',
                'updated_at' => now(),
            ]);

        DB::table('menus')
            ->where('url', '/donor/registrasi')
            ->update([
                'url' => '/donor/jadwal-dokter',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('pages')
            ->where('slug', 'jadwal-dokter')
            ->update([
                'slug' => 'registrasi',
                'updated_at' => now(),
            ]);

        DB::table('menus')
            ->where('url', '/donor/jadwal-dokter')
            ->update([
                'url' => '/donor/registrasi',
                'updated_at' => now(),
            ]);
    }
};

