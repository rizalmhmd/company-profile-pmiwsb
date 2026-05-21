<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')
            ->whereIn('slug', ['struktur-markas', 'struktur-klinik'])
            ->update([
                'category' => 'Profil',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('pages')
            ->where('slug', 'struktur-markas')
            ->update([
                'category' => 'Markas',
                'updated_at' => now(),
            ]);

        DB::table('pages')
            ->where('slug', 'struktur-klinik')
            ->update([
                'category' => 'Klinik',
                'updated_at' => now(),
            ]);
    }
};

