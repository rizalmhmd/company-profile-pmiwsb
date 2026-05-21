<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $profilId = DB::table('menus')->whereNull('parent_id')->where('name', 'PROFIL')->value('id');
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');

        if (!$profilId) {
            return;
        }

        $item = DB::table('menus')
            ->where('name', 'Struktur Organisasi')
            ->whereIn('parent_id', array_filter([$profilId, $klinikId]))
            ->orderByRaw('parent_id = ? desc', [$profilId])
            ->first();

        if (!$item) {
            return;
        }

        // Ensure it's under PROFIL and points to the correct page.
        DB::table('menus')
            ->where('id', $item->id)
            ->update([
                'parent_id' => $profilId,
                'url' => '/profil/struktur/organisasi',
                'order' => 2,
                'updated_at' => now(),
            ]);

        // Avoid duplicate items showing under Klinik.
        if ($klinikId) {
            DB::table('menus')
                ->where('parent_id', $klinikId)
                ->where('name', 'Struktur Organisasi')
                ->where('id', '!=', $item->id)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');
        $profilId = DB::table('menus')->whereNull('parent_id')->where('name', 'PROFIL')->value('id');

        if (!$klinikId) {
            return;
        }

        $item = DB::table('menus')
            ->where('parent_id', $profilId)
            ->where('name', 'Struktur Organisasi')
            ->where('url', '/profil/struktur/organisasi')
            ->first();

        if (!$item) {
            return;
        }

        DB::table('menus')
            ->where('id', $item->id)
            ->update([
                'parent_id' => $klinikId,
                'url' => '/profil/struktur/markas',
                'order' => 1,
                'is_active' => true,
                'updated_at' => now(),
            ]);
    }
};

