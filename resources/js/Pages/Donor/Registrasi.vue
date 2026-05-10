<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const schedules = computed(() => {
    return props.pageData?.content?.schedules || [];
});
</script>

<template>
    <Head title="Jadwal Dokter & Layanan" />
    <MainLayout>
        <HeroSection 
            title="Jadwal Dokter & Layanan" 
            subtitle="Klinik PMI" 
            :description="pageData?.content?.hero_description || 'Informasi waktu praktik dokter dan jadwal layanan kesehatan di Klinik PMI Wonosobo.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div v-if="schedules.length > 0" class="max-w-5xl mx-auto">
                <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900 text-white">
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-widest">Nama Dokter</th>
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-widest">Spesialisasi</th>
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-widest">Hari</th>
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-widest text-right">Waktu Praktik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="(s, idx) in schedules" :key="idx" class="hover:bg-red-50/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-gray-900 group-hover:text-red-600 transition">{{ s.doctor }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-[10px] font-black uppercase">{{ s.specialty }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-gray-600 font-medium">{{ s.days }}</td>
                                    <td class="px-8 py-6 text-right font-black text-gray-900">{{ s.time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 text-center max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Jadwal Belum Tersedia</h2>
                <p class="text-gray-500 text-lg"> Administrator sedang mengupdate jadwal dokter terbaru. </p>
            </div>
        </div>
    </MainLayout>
</template>