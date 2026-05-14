<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';
const props = defineProps({
    pageData: Object,
});
</script>

<template>
    <Head title="Mars & Hymne PMI" />
    <MainLayout>
        <!-- Hero Section -->
        <HeroSection 
            :title="pageData?.title || 'Mars & Hymne'" 
            subtitle="Profil Kami" 
            :description="pageData?.content?.hero_description || 'Lagu kebanggaan dan semangat kemanusiaan yang menjadi jiwa bagi setiap insan Palang Merah Indonesia.'"
        />
        
        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-16">
            <div class="max-w-5xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[500px] object-cover" alt="Featured Image">
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Mars PMI -->
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col">
                    <div class="bg-red-50 p-8 border-b border-red-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-black text-red-600">{{ pageData?.content?.mars_title || 'MARS PMI' }}</h2>
                            <p class="text-red-400 text-sm font-bold uppercase tracking-widest mt-1">Lagu Semangat</p>
                        </div>
                        <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        </div>
                    </div>
                    <div class="p-8 md:p-12 flex-1 flex flex-col justify-center">
                        <div class="space-y-6 text-center italic text-gray-700 leading-relaxed text-lg whitespace-pre-line">
                            {{ pageData?.content?.mars_content || "Palang Merah Indonesia\nSumber kasih umat manusia\nWarisan luhur, nusa dan bangsa\nWujud nyata pengabdiannya" }}
                        </div>
                    </div>
                </div>

                <!-- Hymne PMI -->
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col">
                    <div class="bg-blue-50 p-8 border-b border-blue-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-black text-blue-600">{{ pageData?.content?.hymne_title || 'HYMNE PMI' }}</h2>
                            <p class="text-blue-400 text-sm font-bold uppercase tracking-widest mt-1">Lagu Pengabdian</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        </div>
                    </div>
                    <div class="p-8 md:p-12 flex-1 flex flex-col justify-center">
                        <div class="space-y-6 text-center italic text-gray-700 leading-relaxed text-lg whitespace-pre-line">
                            {{ pageData?.content?.hymne_content || "Palang Merah Indonesia\nKebanggaan nusa dan bangsa\nSetia dalam tugasnya\nMelayani umat manusia" }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- YouTube/Player Placeholder -->
            <div class="mt-16 bg-gray-50 rounded-3xl p-8 border border-gray-100 text-center max-w-2xl mx-auto">
                <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mx-auto mb-4 text-red-600">
                    <svg class="w-8 h-8 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-800 mb-2">Dengarkan Audio</h4>
                <p class="text-gray-500 text-sm mb-6">Fitur pemutar audio sedang dikembangkan untuk memudahkan Anda menghafal dan menyanyikan lagu kebanggaan PMI.</p>
                <div class="h-2 bg-gray-200 rounded-full w-full overflow-hidden">
                    <div class="h-full bg-red-600 w-1/3"></div>
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