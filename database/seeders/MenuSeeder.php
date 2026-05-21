<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['name' => 'BERANDA', 'url' => '/', 'order' => 1],
            ['name' => 'PROFIL', 'url' => null, 'order' => 2, 'children' => [
                ['name' => 'Visi Misi', 'url' => '/profile/visi-misi', 'order' => 1],
                ['name' => 'Struktur Organisasi', 'url' => '/profile/struktur-organisasi', 'order' => 2],
                ['name' => '7 Prinsip', 'url' => '/profile/7-prinsip', 'order' => 3],
                ['name' => 'Sejarah PMI', 'url' => '/profile/sejarah', 'order' => 4],
            ]],
            ['name' => 'UNIT DONOR DARAH', 'url' => null, 'order' => 3, 'children' => [
                ['name' => 'Stok Darah', 'url' => '/donor/info/stok', 'order' => 1],
                ['name' => 'Jadwal Donor/ Mobil Unit', 'url' => '/donor/jadwal', 'order' => 2],
            ]],
            ['name' => 'MARKAS', 'url' => null, 'order' => 4, 'children' => [
                ['name' => 'PPPK', 'url' => '/markas/pertolongan-pertama', 'order' => 1],
                ['name' => 'Layanan Ambulance', 'url' => '/markas/sibats', 'order' => 2],
            ]],
            ['name' => 'KLINIK', 'url' => null, 'order' => 5, 'children' => [
                ['name' => 'Struktur Klinik', 'url' => '/klinik/struktur', 'order' => 1],
                ['name' => 'Jenis Pelayanan', 'url' => '/donor/info/produk', 'order' => 2],
                ['name' => 'Jadwal Dokter Praktek', 'url' => '/donor/jadwal-dokter', 'order' => 3],
            ]],
            ['name' => 'BERITA', 'url' => '/markas/berita', 'order' => 6],
            ['name' => 'HUBUNGI KAMI', 'url' => null, 'order' => 7, 'children' => [
                ['name' => 'Whatsapp', 'url' => 'https://wa.me/6285742750060', 'order' => 1],
            ]],
        ];

        foreach ($menus as $menuData) {
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);
            
            $menu = \App\Models\Menu::updateOrCreate(
                ['parent_id' => null, 'name' => $menuData['name']],
                $menuData
            );
            
            foreach ($children as $childData) {
                $childData['parent_id'] = $menu->id;
                \App\Models\Menu::updateOrCreate(
                    ['parent_id' => $menu->id, 'name' => $childData['name']],
                    $childData
                );
            }
        }
    }
}
