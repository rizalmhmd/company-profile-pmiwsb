<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');
        if (!$klinikId) {
            return;
        }

        $existing = DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('name', 'Struktur Organisasi')
            ->first();

        if (!$existing) {
            // Shift existing Klinik children down to make room at order=1
            DB::table('menus')
                ->where('parent_id', $klinikId)
                ->where('order', '>=', 1)
                ->increment('order');

            DB::table('menus')->insert([
                'name' => 'Struktur Organisasi',
                'url' => '/profil/struktur/organisasi',
                'parent_id' => $klinikId,
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        DB::table('menus')
            ->where('id', $existing->id)
            ->update([
                'url' => '/profil/struktur/organisasi',
                'is_active' => true,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');
        if (!$klinikId) {
            return;
        }

        DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('name', 'Struktur Organisasi')
            ->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
    }
};

