<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    bloodStocks: Array,
    mobileUnits: Array,
    footer: Object,
});
</script>

<template>
    <MainLayout title="Beranda" :can-login="canLogin" :footer="footer">
        <main>
            <!-- Hero Slider -->
            <HeroSection />

            <!-- Information UDD Section -->
            <section class="py-12 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold inline-block border-y-2 border-gray-200 py-2 px-8 uppercase tracking-widest">Informasi UDD PMI Kabupaten Wonosobo</h2>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                        <!-- Stok Darah Card -->
                        <div class="bg-white rounded-3xl shadow-xl border-t-8 border-green-500 relative mt-4 sm:mt-0">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg border-4 border-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                            <div class="p-8 pt-12">
                                <h3 class="text-3xl font-bold text-center mb-8 text-gray-800">Stok Darah</h3>
                                
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse border border-gray-200 text-center">
                                        <thead>
                                            <tr class="bg-gray-50">
                                                <th rowspan="2" class="border border-gray-200 p-2 font-bold text-sm">Produk</th>
                                                <th colspan="4" class="border border-gray-200 p-2 font-bold text-sm">Golongan Darah</th>
                                            </tr>
                                            <tr class="bg-gray-50">
                                                <th class="border border-gray-200 p-2 font-bold text-sm">A</th>
                                                <th class="border border-gray-200 p-2 font-bold text-sm">B</th>
                                                <th class="border border-gray-200 p-2 font-bold text-sm">O</th>
                                                <th class="border border-gray-200 p-2 font-bold text-sm">AB</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="stock in bloodStocks" :key="stock.id" class="hover:bg-gray-50 transition">
                                                <td class="border border-gray-200 p-3 font-bold text-gray-600">{{ stock.product }}</td>
                                                <td class="border border-gray-200 p-3 font-semibold text-lg" :class="{'text-red-500': stock.stock_a < 5}">{{ stock.stock_a }}</td>
                                                <td class="border border-gray-200 p-3 font-semibold text-lg" :class="{'text-red-500': stock.stock_b < 5}">{{ stock.stock_b }}</td>
                                                <td class="border border-gray-200 p-3 font-semibold text-lg" :class="{'text-red-500': stock.stock_o < 5}">{{ stock.stock_o }}</td>
                                                <td class="border border-gray-200 p-3 font-semibold text-lg" :class="{'text-red-500': stock.stock_ab < 5}">{{ stock.stock_ab }}</td>
                                            </tr>
                                            <tr v-if="bloodStocks.length === 0">
                                                <td colspan="5" class="p-8 text-gray-400 italic">Data stok darah belum tersedia</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 text-[10px] text-gray-400 space-y-1">
                                    <p>*Stok darah bisa berubah setiap saat.</p>
                                    <p>INFO Lebih Lanjut Hubungi Humas : 085742750060</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Unit Card -->
                        <div class="bg-white rounded-3xl shadow-xl border-t-8 border-blue-600 relative mt-4 sm:mt-0">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg border-4 border-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                            </div>
                            <div class="p-8 pt-12">
                                <h3 class="text-3xl font-bold text-center mb-8 text-gray-800">Mobile Unit</h3>
                                
                                <div class="space-y-6">
                                    <div v-for="unit in mobileUnits" :key="unit.id" class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                        <div class="text-center min-w-[80px]">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">{{ new Date(unit.date).toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }) }}</p>
                                            <p class="text-2xl font-black text-blue-600">{{ new Date(unit.date).getDate() }}</p>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-800 leading-tight mb-1">{{ unit.location }}</p>
                                            <p class="text-sm font-bold text-red-600">{{ unit.time_start.substring(0,5) }} - {{ unit.time_end.substring(0,5) }} WIB</p>
                                        </div>
                                    </div>
                                    <div v-if="mobileUnits.length === 0" class="p-8 text-center text-gray-400 italic">
                                        Belum ada jadwal mobile unit terdekat.
                                    </div>
                                </div>

                                <div class="mt-10 text-center">
                                    <Link href="/donor/jadwal" class="inline-block bg-blue-700 hover:bg-blue-800 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg">Jadwal Lainnya</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- News Section -->
            <section class="py-12 sm:py-20 bg-white">
                <div class="container mx-auto px-4">
                    <div class="flex flex-row justify-between items-end mb-8 sm:mb-12">
                        <div>
                            <h2 class="text-2xl sm:text-4xl font-bold mb-2 sm:mb-4">Berita <span class="text-red-600">Terkini</span></h2>
                            <div class="w-12 sm:w-20 h-1 bg-red-600"></div>
                        </div>
                        <Link href="#" class="text-red-600 text-sm sm:text-base font-bold flex items-center gap-1 sm:gap-2 hover:underline">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </Link>
                    </div>
 
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
                        <article v-for="i in 3" :key="i" class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-100 transition hover:shadow-xl flex flex-row sm:flex-col group">
                            <div class="w-1/3 sm:w-full h-auto sm:h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1542884748-2b87b36c6b90?q=80&w=2070&auto=format&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="w-2/3 sm:w-full p-4 sm:p-6 flex flex-col justify-between">
                                <div>
                                    <span class="text-[10px] sm:text-xs font-bold text-red-600 uppercase">Kategori</span>
                                    <h3 class="text-sm sm:text-xl font-bold mt-1 sm:mt-2 mb-1 sm:mb-3 hover:text-red-600 cursor-pointer transition line-clamp-2">Judul Berita PMI Wonosobo {{ i }}</h3>
                                    <p class="hidden sm:block text-gray-500 text-sm mb-4 line-clamp-3">Deskripsi berita terbaru mengenai kegiatan PMI Wonosobo di lapangan untuk membantu masyarakat.</p>
                                </div>
                                <div class="flex items-center justify-between text-[10px] sm:text-xs text-gray-400 border-t pt-2 sm:pt-4">
                                    <span>30 April 2026</span>
                                    <span class="hidden sm:inline">Admin</span>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </MainLayout>
</template>
