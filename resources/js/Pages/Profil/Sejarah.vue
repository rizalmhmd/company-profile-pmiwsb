<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const page = usePage();
</script>

<template>
    <Head title="Sejarah Lengkap PMI" />
    <MainLayout>
        <HeroSection 
            title="Sejarah Lengkap PMI" 
            subtitle="Tentang Kami" 
            description="Jejak langkah dan dedikasi Palang Merah Indonesia dari masa ke masa."
        />

        <div class="container mx-auto px-4 py-16 -mt-8 relative z-20">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 max-w-4xl mx-auto backdrop-blur-sm bg-white/95">
                <article class="prose prose-red max-w-none">
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-2 h-10 bg-red-600 rounded-full"></span>
                            Masa Sebelum Perang Dunia Ke-II
                        </h2>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            Berdirinya Palang Merah di Indonesia sebenarnya sudah dimulai sejak masa sebelum Perang Dunia Ke-II. Saat itu, tepatnya pada tanggal 21 Oktober 1873 Pemerintah Kolonial Belanda mendirikan Palang Merah di Indonesia dengan nama <strong>Nederlands Rode Kruis Afdeling Indie (Nerkai)</strong>, yang kemudian dibubarkan pada saat pendudukan Jepang.
                        </p>
                    </div>

                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-2 h-10 bg-red-600 rounded-full"></span>
                            Perjuangan Mendirikan PMI
                        </h2>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            Perjuangan untuk mendirikan Palang Merah Indonesia sendiri diawali sekitar tahun 1932. Kegiatan tersebut dipelopori oleh <strong>Dr. RCL Senduk</strong> dan <strong>Dr Bahder Djohan</strong>. Rencana tersebut mendapat dukungan luas terutama dari kalangan terpelajar Indonesia. Mereka berusaha keras membawa rancangan tersebut ke dalam sidang Konferensi Nerkai pada tahun 1940 walaupun akhirnya ditolak mentah-mentah.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            Terpaksa rancangan itu disimpan untuk menunggu kesempatan yang tepat. Seperti tak kenal menyerah, saat pendudukan Jepang, mereka kembali mencoba untuk membentuk Badan Palang Merah Nasional, namun sekali lagi upaya itu mendapat halangan dari Pemerintah Tentara Jepang sehingga untuk kedua kalinya rancangan itu harus kembali disimpan.
                        </p>
                    </div>

                    <div class="mb-12 bg-red-50 p-8 rounded-2xl border-l-4 border-red-600">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Lahirnya Palang Merah Indonesia</h2>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            Tujuh belas hari setelah proklamasi kemerdekaan 17 Agustus 1945, yaitu pada tanggal <strong>3 September 1945</strong>, Presiden Soekarno mengeluarkan perintah untuk membentuk suatu badan Palang Merah Nasional. Atas perintah Presiden, maka Dr. Buntaran yang saat itu menjabat sebagai Menteri Kesehatan Republik Indonesia Kabinet I, pada tanggal 5 September 1945 membentuk Panitia 5 yang terdiri dari: <strong>dr R. Mochtar (Ketua), dr. Bahder Djohan (Penulis), dan dr Djuhana; dr Marzuki; dr. Sitanala (anggota)</strong>.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Akhirnya Perhimpunan Palang Merah Indonesia berhasil dibentuk pada <strong>17 September 1945</strong> yang di ketuai oleh <strong>Drs. Mohammad Hatta</strong>. Didalam satu negara hanya ada satu perhimpunan nasional, maka 16 Januari 1950 pemerintah belanda membubarkan NERKAI dan menyerahkan asetnya ke PMI. Pihak NERKAI diwakili oleh dr. B. Van Trich sedangkan dari PMI diwakili oleh dr. Bahder Djohan.
                        </p>
                    </div>

                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-2 h-10 bg-red-600 rounded-full"></span>
                            Pengakuan Internasional
                        </h2>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            PMI merintis kegiatannya melalui bantuan korban perang revolusi kemerdekaan Republik Indonesia dan pengembalian tawanan perang sekutu maupun Jepang. Oleh karena kinerja tersebut, PMI mendapat pengakuan secara Internasional oleh Komite Palang Merah Internasional (ICRC) pada <strong>15 Juni 1950</strong> dengan menjadi anggota Palang Merah Internasional.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Setelah itu PMI diterima menjadi anggota Perhimpunan Nasional ke-68 oleh Liga Perhimpunan Palang Merah dan Bulan Sabit Merah yang disebut Federasi Internasional Perhimpunan Palang Merah dan Bulan Sabit Merah (IFRC) pada Oktober 1950.
                        </p>
                    </div>

                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-2 h-10 bg-red-600 rounded-full"></span>
                            Landasan Hukum dan Tugas Utama
                        </h2>
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            PMI terus memberikan bantuan hingga akhirnya Pemerintah Republik Indonesia Serikat mengeluarkan Keppres No. 25 tanggal 16 Januari 1950 dan dikuatkan dengan Keppres No. 246 tanggal 29 November 1963. Pemerintah Indonesia mengakui keberadaan PMI. Adapun tugas utama PMI berdasarkan Keppres tersebut adalah untuk memberikan bantuan pertama pada korban bencana alam dan korban perang sesuai dengan isi Konvensi Jenewa 1949.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg mb-8">
                            Pada tahun 2018 PMI adalah organisasi kemanusiaan yang berstatus badan hukum, diundangkan dengan <strong>Undang-Undang nomor 1 tahun 2018 tentang Kepalangmerahan</strong> guna menjalankan kegiatan Kepalangmerahan sesuai dengan Konvensi Jenewa Tahun 1949, dengan tujuan untuk mencegah dan meringankan penderitaan dan melindungi korban tawanan perang dan bencana, tanpa membedakan agama, bangsa, suku bangsa, warna kulit, jenis kelamin, golongan, dan Pandangan Politik.
                        </p>
                        
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 uppercase tracking-wider">Tugas yang dilakukan PMI:</h3>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Bantuan korban konflik bersenjata dan kerusuhan
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Pelayanan darah sesuai peraturan
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Pembinaan relawan
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Pendidikan dan pelatihan Kepalangmerahan
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Penyebarluasan informasi Kepalangmerahan
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Penanganan musibah dan/atau bencana
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Pemberian pelayanan kesehatan dan sosial
                                </li>
                                <li class="flex items-start gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Tugas kemanusiaan lainnya dari pemerintah
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-12 p-8 bg-gray-900 rounded-3xl text-white">
                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <div class="text-4xl font-black text-red-500">2019</div>
                            <div class="text-lg leading-relaxed italic">
                                Berdasarkan data per-Februari 2019, PMI telah berdiri di 34 Provinsi, 474 kabupaten/Kota, 3.406 Kecamatan dan mempunyai hampir 1,5 juta sukarelawan yang siap melakukan pelayanan.
                            </div>
                        </div>
                    </div>
                </article>

                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-center">
                    <Link href="/" class="inline-flex items-center gap-2 px-8 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Beranda
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>