<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';
import DynamicPageContent from '@/Components/DynamicPageContent.vue';

const page = usePage();
</script>

<template>
    <Head title="Event & Kegiatan" />
    <MainLayout>
        <HeroSection 
            title="Event & Kegiatan" 
            subtitle="Markas" 
            description="Informasi berbagai agenda, pelatihan, dan kegiatan kemanusiaan PMI di Kabupaten Wonosobo."
        />

        <div class="container mx-auto px-4 py-16 -mt-8 relative z-20">
            <DynamicPageContent :pageData="pageData" />
        </div>
    </MainLayout>
</template>