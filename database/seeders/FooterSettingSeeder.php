<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterSetting;

class FooterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterSetting::updateOrCreate(
            ['id' => 1],
            [
                'about_pmi' => 'PMI Wonosobo adalah lembaga kemanusiaan yang berdedikasi untuk melayani masyarakat di Kabupaten Wonosobo melalui berbagai program kemanusiaan.',
                'address' => 'Jl. Jenderal Sudirman No. 12, Wonosobo, Jawa Tengah',
                'phone' => '0286 123456',
                'email' => 'pmiwonosobo@gmail.com',
                'facebook' => '#',
                'instagram' => '#',
                'twitter' => '#',
                'youtube' => '#',
                'copyright' => '2026 PMI Kabupaten Wonosobo. All Rights Reserved.',
            ]
        );
    }
}
