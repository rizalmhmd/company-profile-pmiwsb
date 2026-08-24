<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';
import DynamicPageContent from '@/Components/DynamicPageContent.vue';

const props = defineProps({
    pageData: Object,
    bloodStocks: {
        type: Array,
        default: () => []
    },
});
</script>

<template>
    <Head title="Stok Darah" />
    <MainLayout>
        <HeroSection 
            :title="pageData?.title || 'Stok Darah Real-time'" 
            subtitle="Informasi Donor" 
            :description="pageData?.content?.hero_description || 'Pantau ketersediaan stok darah di Unit Donor Darah PMI Kabupaten Wonosobo secara langsung.'"
        />

        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-8">
            <div class="max-w-5xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[450px] object-cover" alt="Featured Image">
            </div>
        </div>

        <!-- Stok Darah Data Section -->
        <div class="container mx-auto px-4 py-8 relative z-20">
            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border-t-8 border-green-500 relative">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg border-4 border-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div class="p-8 pt-12">
                    <h3 class="text-3xl font-bold text-center mb-8 text-gray-800">Tabel Stok Darah</h3>
                    
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
                    <div class="mt-4 text-[10px] text-gray-400 space-y-1 text-center">
                        <p>*Stok darah bisa berubah setiap saat.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 relative z-20">
            <DynamicPageContent :pageData="pageData" :showFallback="false" />
        </div>
    </MainLayout>
</template>