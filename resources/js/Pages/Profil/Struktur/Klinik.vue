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
    <Head title="Struktur Klinik" />
    <MainLayout>
        <HeroSection 
            title="Struktur Klinik" 
            subtitle="Struktur Organisasi" 
            :description="pageData?.content?.hero_description || 'Manajemen dan tenaga medis Klinik PMI Kabupaten Wonosobo.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div v-if="sections.length > 0" class="space-y-12 max-w-5xl mx-auto">
                <div v-for="(section, sIdx) in sections" :key="sIdx" class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-gray-100 relative overflow-hidden">
                    <h2 class="text-3xl font-black text-gray-900 mb-8 border-b-4 border-red-600 inline-block pb-2">{{ section.title }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div v-for="(item, iIdx) in section.items" :key="iIdx" class="flex items-center gap-4 p-6 bg-gray-50 rounded-2xl hover:bg-red-50 transition border border-transparent hover:border-red-100 group">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-red-600 shadow-sm shrink-0 group-hover:scale-110 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <p class="text-gray-700 font-bold leading-relaxed">{{ item }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Konten Segera Hadir</h2>
                <p class="text-gray-500">Struktur klinik sedang diperbarui oleh administrator.</p>
            </div>
        </div>
    </MainLayout>
</template>