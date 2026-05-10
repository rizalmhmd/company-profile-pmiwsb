<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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
    <Head title="Sejarah Lengkap PMI" />
    <MainLayout>
        <HeroSection 
            title="Sejarah Lengkap PMI" 
            subtitle="Tentang Kami" 
            :description="pageData?.content?.hero_description || 'Jejak langkah dan dedikasi Palang Merah Indonesia dari masa ke masa.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="max-w-4xl mx-auto space-y-12">
                <div v-if="sections.length > 0" class="space-y-12">
                    <div v-for="(section, sIdx) in sections" :key="sIdx" class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-12 text-red-50 opacity-10">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-4.97-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm-1-9h3l-4 4-4-4h3V7h2v3z"/></svg>
                        </div>
                        
                        <div class="relative z-10">
                            <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-4">
                                <span class="w-2 h-10 bg-red-600 rounded-full"></span>
                                {{ section.title }}
                            </h2>
                            
                            <div class="space-y-6">
                                <p v-for="(item, iIdx) in section.items" :key="iIdx" class="text-gray-700 leading-relaxed text-lg">
                                    {{ item }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fallback or Default if no dynamic content -->
                <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center backdrop-blur-sm bg-white/95">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Konten Segera Hadir</h2>
                    <p class="text-gray-500 text-lg">
                        Sejarah lengkap sedang dipersiapkan oleh administrator.
                    </p>
                </div>

                <div class="pt-8 flex justify-center">
                    <Link href="/" class="inline-flex items-center gap-2 px-8 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Beranda
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>