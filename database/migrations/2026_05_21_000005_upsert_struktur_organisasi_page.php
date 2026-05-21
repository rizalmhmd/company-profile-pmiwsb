<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->updateOrInsert(
            ['slug' => 'struktur-organisasi'],
            [
                'title' => 'Struktur Organisasi',
                'category' => 'Profil',
                'content' => json_encode([
                    'hero_description' => 'Struktur organisasi Palang Merah Indonesia Kabupaten Wonosobo.',
                    'org_chart' => [
                        'pengurus' => 'Pengurus',
                        'sekretariat' => 'Sekretariat',
                        'units' => ['Markas', 'Unit Donor Darah', 'Klinik Pratama'],
                    ],
                ], JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('pages')->where('slug', 'struktur-organisasi')->delete();
    }
};

