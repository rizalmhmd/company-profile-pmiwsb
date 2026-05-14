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
    services: Array,
    latestPosts: Array,
});
</script>

<template>
    <MainLayout title="Beranda">
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

            <!-- Services Section -->
            <section id="pelayanan" class="py-20 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-black text-gray-900 mb-4">Layanan <span class="text-red-600">Utama</span> Kami</h2>
                        <p class="text-gray-500 max-w-2xl mx-auto">Memberikan pelayanan terbaik dengan sepenuh hati untuk kemanusiaan di Kabupaten Wonosobo.</p>
                        <div class="w-20 h-1.5 bg-red-600 mx-auto mt-6 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div v-for="service in services" :key="service.id" class="group relative bg-gray-900 rounded-[2.5rem] shadow-xl overflow-hidden hover:shadow-2xl hover:shadow-red-900/20 transition-all duration-700 h-[400px]">
                            <!-- Image Background -->
                            <div class="absolute inset-0 z-0">
                                <img :src="service.image_url || 'https://images.unsplash.com/photo-1584515933487-779824d29309?q=80&w=2070&auto=format&fit=crop'" 
                                     class="w-full h-full object-cover scale-105 group-hover:scale-125 transition duration-1000 opacity-60 group-hover:opacity-40" 
                                     alt="Service">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
                            </div>

                            <!-- Content -->
                            <div class="absolute inset-0 z-10 p-10 flex flex-col justify-end">
                                <!-- Glassmorphism Icon -->
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white mb-6 shadow-xl border border-white/30 transform group-hover:scale-110 group-hover:bg-red-600 group-hover:border-red-500 transition-all duration-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="service.icon || 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'"></path>
                                    </svg>
                                </div>
                                
                                <h3 class="text-2xl font-black text-white mb-3 transform group-hover:-translate-y-2 transition duration-500 uppercase tracking-tight leading-tight drop-shadow-md">
                                    {{ service.title }}
                                </h3>
                                
                                <div class="overflow-hidden">
                                    <p class="text-gray-300 text-sm font-medium leading-relaxed mb-8 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 line-clamp-3">
                                        {{ service.description }}
                                    </p>
                                </div>
                                
                                <Link :href="`/markas/${service.slug}`" class="inline-flex items-center gap-3 text-white text-xs font-black uppercase tracking-[0.2em] group/btn">
                                    <span class="relative">
                                        Selengkapnya
                                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-red-600 scale-x-0 group-hover/btn:scale-x-100 transition-transform origin-left"></span>
                                    </span>
                                    <svg class="w-5 h-5 transform group-hover/btn:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- News Section -->
            <section class="py-12 sm:py-20 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="flex flex-row justify-between items-end mb-8 sm:mb-12">
                        <div>
                            <h2 class="text-2xl sm:text-4xl font-bold mb-2 sm:mb-4">Berita <span class="text-red-600">Terkini</span></h2>
                            <div class="w-12 sm:w-20 h-1 bg-red-600"></div>
                        </div>
                        <Link href="/markas/berita" class="text-red-600 text-sm sm:text-base font-bold flex items-center gap-1 sm:gap-2 hover:underline">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </Link>
                    </div>
 
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
                        <article v-for="post in latestPosts" :key="post.id" class="bg-white rounded-3xl overflow-hidden shadow-md border border-gray-100 transition hover:shadow-2xl flex flex-row sm:flex-col group">
                            <Link :href="`/markas/berita/${post.slug}`" class="w-1/3 sm:w-full h-auto sm:h-56 overflow-hidden relative block">
                                <img :src="post.image_url || 'https://images.unsplash.com/photo-1542884748-2b87b36c6b90?q=80&w=2070&auto=format&fit=crop'" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-red-600 text-white text-[10px] font-black uppercase rounded-lg shadow-lg">{{ post.category?.name || 'UMUM' }}</span>
                                </div>
                            </Link>
                            <div class="w-2/3 sm:w-full p-4 sm:p-8 flex flex-col justify-between bg-white relative z-10">
                                <div>
                                    <Link :href="`/markas/berita/${post.slug}`">
                                        <h3 class="text-sm sm:text-xl font-bold mt-1 sm:mt-2 mb-1 sm:mb-4 hover:text-red-600 transition line-clamp-2 leading-tight">{{ post.title }}</h3>
                                    </Link>
                                    <p class="hidden sm:block text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed" v-html="post.content"></p>
                                </div>
                                <div class="flex items-center justify-between text-[10px] sm:text-xs text-gray-400 border-t border-gray-50 pt-2 sm:pt-6 font-bold uppercase tracking-widest">
                                    <span>{{ new Date(post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
                                    <span class="hidden sm:inline">PMI WONOSOBO</span>
                                </div>
                            </div>
                        </article>

                        <div v-if="latestPosts.length === 0" class="col-span-full py-20 text-center">
                            <p class="text-gray-400 font-bold uppercase tracking-widest">Belum ada berita yang diterbitkan.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </MainLayout>
</template>
