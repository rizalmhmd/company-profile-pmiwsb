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

        // If Klinik menu has "Struktur Organisasi", repurpose it to "Struktur Klinik".
        $org = DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('name', 'Struktur Organisasi')
            ->first();

        if ($org) {
            DB::table('menus')
                ->where('id', $org->id)
                ->update([
                    'name' => 'Struktur Klinik',
                    'url' => '/profil/struktur/klinik',
                    'order' => 1,
                    'is_active' => true,
                    'updated_at' => now(),
                ]);
        } else {
            // Ensure "Struktur Klinik" exists as first item.
            $existing = DB::table('menus')
                ->where('parent_id', $klinikId)
                ->where('name', 'Struktur Klinik')
                ->first();

            if (!$existing) {
                DB::table('menus')
                    ->where('parent_id', $klinikId)
                    ->where('order', '>=', 1)
                    ->increment('order');

                DB::table('menus')->insert([
                    'name' => 'Struktur Klinik',
                    'url' => '/profil/struktur/klinik',
                    'parent_id' => $klinikId,
                    'order' => 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('menus')
                    ->where('id', $existing->id)
                    ->update([
                        'url' => '/profil/struktur/klinik',
                        'order' => 1,
                        'is_active' => true,
                        'updated_at' => now(),
                    ]);
            }
        }

        // Deactivate any other Klinik children still pointing to profil struktur organisasi to avoid duplicates/confusion.
        DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('url', '/profil/struktur/organisasi')
            ->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        $klinikId = DB::table('menus')->whereNull('parent_id')->where('name', 'KLINIK')->value('id');
        if (!$klinikId) {
            return;
        }

        // Reactivate any deactivated org links.
        DB::table('menus')
            ->where('parent_id', $klinikId)
            ->where('url', '/profil/struktur/organisasi')
            ->update([
                'is_active' => true,
                'updated_at' => now(),
            ]);
    }
};

