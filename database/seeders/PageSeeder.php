<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'category' => 'Profil',
                'content' => [
                    'hero_description' => 'Arah dan tujuan perjuangan Palang Merah Indonesia dalam melayani umat manusia.',
                    'sections' => [
                        [
                            'title' => 'VISI',
                            'items' => ['Terwujudnya PMI yang profesional dan berintegritas serta bergerak bersama masyarakat.']
                        ],
                        [
                            'title' => 'MISI',
                            'items' => [
                                'Menjadi organisasi kemanusiaan terdepan yang memberikan layanan berkualitas.',
                                'Meningkatkan integritas dan kemandirian organisasi.',
                                'Meningkatkan kesiapsiagaan dan ketangguhan masyarakat.'
                            ]
                        ]
                    ]
                ],
            ],
            [
                'title' => '7 Prinsip Dasar',
                'slug' => '7-prinsip',
                'category' => 'Profil',
                'content' => [
                    'hero_description' => 'Landasan utama Gerakan Palang Merah dan Bulan Sabit Merah Internasional.',
                    'principles' => [
                        ['title' => 'Kemanusiaan', 'subtitle' => 'HUMANITY', 'description' => 'Mencegah dan meringankan penderitaan manusia.', 'icon' => 'heart', 'color' => 'red'],
                        ['title' => 'Kesamaan', 'subtitle' => 'IMPARTIALITY', 'description' => 'Tidak membeda-bedakan atas dasar kebangsaan.', 'icon' => 'scale', 'color' => 'orange'],
                        ['title' => 'Kenetralan', 'subtitle' => 'NEUTRALITY', 'description' => 'Tidak melibatkan diri dalam pertikaian.', 'icon' => 'shield', 'color' => 'blue']
                    ]
                ],
            ],
            [
                'title' => 'Mars & Hymne',
                'slug' => 'mars-hymne',
                'category' => 'Profil',
                'content' => [
                    'hero_description' => 'Lagu kebanggaan dan semangat kemanusiaan Palang Merah Indonesia.',
                    'mars_title' => 'MARS PMI',
                    'mars_content' => "Palang Merah Indonesia...",
                    'hymne_title' => 'HYMNE PMI',
                    'hymne_content' => "Palang Merah Indonesia..."
                ],
            ],
            [
                'title' => 'Sejarah PMI',
                'slug' => 'sejarah',
                'category' => 'Profil',
                'content' => [
                    'hero_description' => 'Jejak langkah dan dedikasi Palang Merah Indonesia dari masa ke masa.',
                    'sections' => [
                        [
                            'title' => 'Masa Sebelum Perang Dunia Ke-II',
                            'items' => ['Pada tanggal 21 Oktober 1873 Pemerintah Kolonial Belanda mendirikan Palang Merah di Indonesia dengan nama Nederlands Rode Kruis Afdeling Indie (Nerkai).']
                        ],
                        [
                            'title' => 'Lahirnya Palang Merah Indonesia',
                            'items' => ['Akhirnya Perhimpunan Palang Merah Indonesia berhasil dibentuk pada 17 September 1945 yang di ketuai oleh Drs. Mohammad Hatta.']
                        ]
                    ]
                ],
            ],
            [
                'title' => 'Pertolongan Pertama (PPPK)',
                'slug' => 'pertolongan-pertama',
                'category' => 'Markas',
                'content' => [
                    'hero_description' => 'Layanan bantuan pertama pada kecelakaan dan keadaan darurat medis.',
                    'sections' => [
                        [
                            'title' => 'Cakupan Layanan',
                            'items' => ['P3K Acara Keramaian', 'P3K Bencana Alam', 'Pelatihan P3K']
                        ]
                    ]
                ],
            ],
            [
                'title' => 'Layanan Ambulance',
                'slug' => 'sibats',
                'category' => 'Markas',
                'content' => [
                    'hero_description' => 'Kesiapsiagaan layanan transportasi medis darurat 24 jam.',
                    'sections' => [
                        [
                            'title' => 'Informasi Layanan',
                            'items' => ['Siap sedia 24 jam', 'Peralatan medis lengkap', 'Tenaga terlatih']
                        ]
                    ]
                ],
            ],
            [
                'title' => 'Struktur Markas',
                'slug' => 'struktur-markas',
                'category' => 'Markas',
                'content' => [
                    'hero_description' => 'Manajemen dan operasional Markas PMI Kabupaten Wonosobo.',
                    'sections' => [
                        [
                            'title' => 'Kepala Markas',
                            'items' => ['Nama Pejabat']
                        ]
                    ]
                ],
            ],
            [
                'title' => 'Jadwal Dokter',
                'slug' => 'registrasi',
                'category' => 'Klinik',
                'content' => [
                    'hero_description' => 'Informasi waktu praktik dokter di Klinik PMI.',
                    'schedules' => [
                        ['doctor' => 'dr. Fulan', 'specialty' => 'Umum', 'days' => 'Senin - Jumat', 'time' => '08:00 - 14:00']
                    ]
                ],
            ],
            [
                'title' => 'Struktur Klinik',
                'slug' => 'struktur-klinik',
                'category' => 'Klinik',
                'content' => [
                    'hero_description' => 'Manajemen dan tenaga medis Klinik PMI Kabupaten Wonosobo.',
                    'sections' => [
                        [
                            'title' => 'Waktu Pelayanan',
                            'items' => ['Senin - Sabtu: 08:00 - 20:00', 'Minggu: Tutup']
                        ]
                    ]
                ],
            ],
            [
                'title' => 'Produk Darah',
                'slug' => 'produk',
                'category' => 'Donor Darah',
                'content' => [
                    'hero_description' => 'Layanan produk darah yang tersedia di UDD PMI.',
                    'products' => [
                        ['name' => 'WB', 'title' => 'Whole Blood', 'usage' => 'Operasi Besar']
                    ]
                ],
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
