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
    <Head title="Struktur Markas" />
    <MainLayout>
        <HeroSection 
            title="Struktur Markas" 
            subtitle="Struktur Organisasi" 
            :description="pageData?.content?.hero_description || 'Manajemen dan operasional Markas PMI Kabupaten Wonosobo.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div v-if="sections.length > 0" class="space-y-12 max-w-5xl mx-auto">
                <div v-for="(section, sIdx) in sections" :key="sIdx" class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-gray-100 relative overflow-hidden text-center">
                    <h2 class="text-3xl font-black text-gray-900 mb-8">{{ section.title }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="(item, iIdx) in section.items" :key="iIdx" class="p-6 bg-gray-50 rounded-2xl border border-gray-100 font-bold text-gray-700">
                            {{ item }}
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Konten Segera Hadir</h2>
                <p class="text-gray-500">Struktur organisasi markas sedang diperbarui.</p>
            </div>
        </div>
    </MainLayout>
</template>