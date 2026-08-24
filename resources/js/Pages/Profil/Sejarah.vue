<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';
import DynamicPageContent from '@/Components/DynamicPageContent.vue';

const props = defineProps({
    pageData: Object,
});
</script>

<template>
    <Head title="Sejarah Lengkap PMI" />
    <MainLayout>
        <HeroSection 
            :title="pageData?.title || 'Sejarah Lengkap PMI'" 
            subtitle="Tentang Kami" 
            :description="pageData?.content?.hero_description || 'Jejak langkah dan dedikasi Palang Merah Indonesia dari masa ke masa.'"
        />

        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-16">
            <div class="max-w-4xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[500px] object-cover" alt="Featured Image">
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <DynamicPageContent :pageData="pageData" />
        </div>
    </MainLayout>
</template>
