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
    <Head title="Layanan Ambulance" />
    <MainLayout>
        <HeroSection 
            title="Layanan Ambulance" 
            subtitle="Markas" 
            :description="pageData?.content?.hero_description || 'Kesiapsiagaan layanan transportasi medis darurat 24 jam untuk masyarakat Wonosobo.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div v-if="sections.length > 0" class="space-y-12 max-w-5xl mx-auto">
                <div v-for="(section, sIdx) in sections" :key="sIdx" class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-12 text-blue-50 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M18 11h-2V9h-3v2H9V9H6v2H4c-1.1 0-2 .9-2 2v5c0 1.1.9 2 2 2h1c0 1.1.9 2 2 2s2-.9 2-2h6c0 1.1.9 2 2 2s2-.9 2-2h1c1.1 0 2-.9 2-2v-5c0-1.1-.9-2-2-2zM7 19c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm10 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-4">
                            <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
                            {{ section.title }}
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="(item, iIdx) in section.items" :key="iIdx" class="flex gap-4 p-6 bg-gray-50 rounded-2xl hover:bg-blue-50 transition border border-transparent hover:border-blue-100 group">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-blue-600 shadow-sm shrink-0 group-hover:scale-110 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-gray-700 font-medium leading-relaxed">{{ item }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto backdrop-blur-sm bg-white/90">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-600 rounded-2xl mb-6 shadow-sm border border-blue-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Konten Segera Hadir</h2>
                <p class="text-gray-500 text-lg">
                    Konten untuk layanan <span class="font-bold text-blue-600">Ambulance</span> sedang dipersiapkan. 
                </p>
            </div>
        </div>
    </MainLayout>
</template>