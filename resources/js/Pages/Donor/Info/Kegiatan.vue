<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';
import DynamicPageContent from '@/Components/DynamicPageContent.vue';

const props = defineProps({
    pageData: Object,
});
</script>

<template>
    <Head title="Kegiatan Donor Darah" />
    <MainLayout>
        <HeroSection 
            :title="pageData?.title || 'Kegiatan Donor'" 
            subtitle="Informasi Donor" 
            :description="pageData?.content?.hero_description || 'Dokumentasi dan informasi berbagai kegiatan kemanusiaan yang diselenggarakan oleh PMI Wonosobo.'"
        />

        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-8">
            <div class="max-w-5xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[450px] object-cover" alt="Featured Image">
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 -mt-8 relative z-20">
            <DynamicPageContent :pageData="pageData" />
        </div>
    </MainLayout>
</template>