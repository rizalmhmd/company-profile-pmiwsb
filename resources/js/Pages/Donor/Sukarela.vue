<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';
import DynamicPageContent from '@/Components/DynamicPageContent.vue';

const page = usePage();
</script>

<template>
    <Head title="Donor Darah Sukarela" />
    <MainLayout>
        <HeroSection 
            title="Donor Darah Sukarela" 
            subtitle="Donor Darah" 
            description="Jadilah pahlawan kemanusiaan dengan menjadi pendonor darah sukarela secara rutin."
        />

        <div class="container mx-auto px-4 py-16 -mt-8 relative z-20">
            <DynamicPageContent :pageData="pageData" />
        </div>
    </MainLayout>
</template>