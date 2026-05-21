<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $profilId = DB::table('menus')->whereNull('parent_id')->where('name', 'PROFIL')->value('id');
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');

        if (!$profilId || !$klinikId) {
            return;
        }

        $strukturId = DB::table('menus')
            ->where('parent_id', $profilId)
            ->where('name', 'Struktur Organisasi')
            ->value('id');

        if (!$strukturId) {
            return;
        }

        // Make room as first item under Klinik
        DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('order', '>=', 1)
            ->increment('order');

        DB::table('menus')
            ->where('id', $strukturId)
            ->update([
                'parent_id' => $klinikId,
                'order' => 1,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        $profilId = DB::table('menus')->whereNull('parent_id')->where('name', 'PROFIL')->value('id');
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');

        if (!$profilId || !$klinikId) {
            return;
        }

        $strukturId = DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('name', 'Struktur Organisasi')
            ->value('id');

        if (!$strukturId) {
            return;
        }

        // Remove the item then close the gap
        DB::table('menus')
            ->where('id', $strukturId)
            ->update([
                'parent_id' => $profilId,
                'order' => 2,
                'updated_at' => now(),
            ]);

        DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('order', '>', 1)
            ->decrement('order');
    }
};

