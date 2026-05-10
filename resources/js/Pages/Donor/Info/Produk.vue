<script setup>
import { computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const products = computed(() => {
    if (props.pageData?.content?.products) {
        return props.pageData.content.products;
    }
    return [
        {
            name: "Whole Blood (WB)",
            title: "Darah Lengkap",
            description: "Darah lengkap yang mengandung seluruh komponen darah. Digunakan untuk penggantian volume darah pada perdarahan akut.",
            usage: "Trauma, Bedah Mayor",
            color: "bg-red-600"
        },
        {
            name: "Packed Red Cells (PRC)",
            title: "Sel Darah Merah",
            description: "Komponen darah yang hanya mengandung sel darah merah setelah plasma dipisahkan. Digunakan untuk pasien anemia.",
            usage: "Anemia, Thalassemia, Operasi",
            color: "bg-red-700"
        }
    ];
});
</script>

<template>
    <Head title="Mengenal Produk Darah" />
    <MainLayout>
        <!-- Hero Section -->
        <HeroSection 
            title="Produk Darah" 
            subtitle="Unit Donor Darah" 
            :description="pageData?.content || 'Mengenal berbagai jenis produk darah hasil olahan Unit Donor Darah (UDD) PMI untuk kebutuhan medis pasien.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div v-for="(product, index) in products" :key="index" 
                     class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300 flex flex-col group">
                    <div class="h-32 p-8 flex items-center justify-between text-white" :class="product.color">
                        <div>
                            <h2 class="text-xl font-black leading-tight">{{ product.name }}</h2>
                            <p class="text-white/80 text-xs font-bold uppercase tracking-widest mt-1">{{ product.title }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            {{ product.description }}
                        </p>
                        <div class="mt-auto">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Indikasi Umum:</h4>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="tag in product.usage.split(', ')" :key="tag" 
                                      class="px-3 py-1 bg-gray-50 text-gray-600 rounded-lg text-xs font-bold border border-gray-100">
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice Section -->
            <div class="mt-20 max-w-4xl mx-auto bg-gray-900 rounded-[3rem] p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-600 rounded-full blur-[100px] opacity-20 -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="w-24 h-24 bg-red-600 rounded-3xl flex items-center justify-center shrink-0 shadow-2xl shadow-red-900/50">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Informasi Tambahan</h3>
                        <p class="text-gray-400 leading-relaxed text-sm md:text-base">
                            Ketersediaan produk darah di atas sangat bergantung pada partisipasi masyarakat dalam mendonorkan darahnya. Setiap kantong darah yang Anda donorkan dapat diolah menjadi berbagai komponen yang menyelamatkan lebih dari satu nyawa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.container {
    max-width: 1200px;
}
</style>