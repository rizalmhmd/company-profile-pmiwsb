<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const sections = computed(() => {
    return props.pageData?.content?.sections || [];
});
</script>

<template>
    <Head title="Pertolongan Pertama" />
    <MainLayout>
        <HeroSection 
            title="Pertolongan Pertama" 
            subtitle="Markas" 
            :description="pageData?.content?.hero_description || 'Layanan pertolongan pertama dan evakuasi medis darurat untuk keselamatan masyarakat.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div v-if="sections.length > 0" class="space-y-12 max-w-5xl mx-auto">
                <div v-for="(section, sIdx) in sections" :key="sIdx" class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-12 text-red-50 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z" /></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-4">
                            <span class="w-2 h-10 bg-red-600 rounded-full"></span>
                            {{ section.title }}
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="(item, iIdx) in section.items" :key="iIdx" class="flex gap-4 p-6 bg-gray-50 rounded-2xl hover:bg-red-50 transition border border-transparent hover:border-red-100 group">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-red-600 shadow-sm shrink-0 group-hover:scale-110 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-gray-700 font-medium leading-relaxed">{{ item }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto backdrop-blur-sm bg-white/90">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-50 text-red-600 rounded-2xl mb-6 shadow-sm border border-red-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Konten Segera Hadir</h2>
                <p class="text-gray-500 text-lg">
                    Konten untuk halaman ini sedang dipersiapkan oleh administrator. 
                </p>
            </div>
        </div>
    </MainLayout>
</template>