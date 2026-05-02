<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const footer = computed(() => page.props.footer);
</script>

<template>
    <Head title="Struktur Markas" />
    <MainLayout :footer="footer">
        <div class="bg-gradient-to-b from-red-600 to-red-800 text-white py-20 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            
            <div class="container mx-auto px-4 text-center relative z-10">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">Struktur Markas</h1>
                <p class="text-red-100 max-w-2xl mx-auto text-lg">Halaman ini sedang dalam tahap pengembangan (SPA Vue.js).</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 -mt-8 relative z-20">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto backdrop-blur-sm bg-white/90">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-50 text-red-600 rounded-2xl mb-6 shadow-sm border border-red-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Konten Segera Hadir</h2>
                <p class="text-gray-500 text-lg">
                    Konten untuk halaman <span class="font-bold text-red-600">Struktur Markas</span> sedang dipersiapkan oleh administrator. 
                </p>
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 text-gray-700 rounded-xl font-medium hover:bg-gray-100 hover:text-red-600 transition-colors border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>