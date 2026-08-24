<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
    schedules: Array,
});

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        weekday: 'long', 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric'
    }).format(date);
};
</script>

<template>
    <Head title="Jadwal Donor Darah" />
    <MainLayout>
        <HeroSection 
            :title="pageData?.title || 'Jadwal Mobile Unit'" 
            subtitle="Unit Donor Darah" 
            :description="pageData?.content?.hero_description || 'Temukan lokasi kegiatan donor darah terdekat di wilayah Kabupaten Wonosobo.'"
        />

        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-8">
            <div class="max-w-5xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[450px] object-cover" alt="Featured Image">
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 -mt-8 relative z-20">
            <!-- Schedule Grid -->
            <div v-if="schedules && schedules.length > 0" class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Jadwal Terdekat</h2>
                    <p class="text-gray-500">Temukan lokasi Mobile Unit kami untuk melakukan donor darah di sekitar Anda.</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="schedule in schedules" :key="schedule.id" 
                        class="bg-white rounded-2xl shadow-lg border-t-[6px] border-t-red-600 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm border border-red-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg leading-tight mb-4">{{ schedule.name }}</h3>
                                
                                <div class="space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ schedule.location }}</p>
                                    </div>
                                    
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">{{ formatDate(schedule.date) }}</p>
                                            <p class="text-sm font-bold text-red-600 mt-0.5">{{ schedule.time_start }} - {{ schedule.time_end }} WIB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto backdrop-blur-sm bg-white/90">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 text-gray-400 rounded-2xl mb-6 shadow-sm border border-gray-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Jadwal</h2>
                <p class="text-gray-500 text-lg">
                    Saat ini belum ada jadwal donor darah keliling (Mobile Unit) terdekat. 
                </p>
                <p class="text-sm text-gray-400 mt-2">Silakan kunjungi markas Unit Donor Darah PMI secara langsung untuk mendonorkan darah Anda.</p>
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 text-gray-700 rounded-xl font-medium hover:bg-gray-100 hover:text-red-600 transition-colors border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>