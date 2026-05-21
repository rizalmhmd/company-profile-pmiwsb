<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';
import DoctorWeeklySchedule from '@/Components/DoctorWeeklySchedule.vue';

const props = defineProps({
    pageData: Object,
});

const scheduleModeFromCms = computed(() => props.pageData?.content?.schedule_mode || null);
const legacySchedules = computed(() => props.pageData?.content?.schedules || []);
const weeklyGroupsFromCms = computed(() => props.pageData?.content?.weekly_schedule?.groups || []);

const defaultWeeklyGroups = [
    {
        title: 'Pelayanan Umum',
        rows: [
            {
                doctor: 'dr. Kumoro Widiati',
                times: {
                    senin: ['Jam 07.00 s/d 13.30'],
                    selasa: ['Jam 07.00 s/d 13.30'],
                    rabu: ['Jam 07.00 s/d 13.30'],
                    kamis: ['Jam 07.00 s/d 13.30'],
                },
            },
            {
                doctor: 'dr. Moch. Syaban',
                times: {
                    kamis: ['Jam 13.30 s/d 20.00'],
                    jumat: ['Jam 13.30 s/d 20.00'],
                },
            },
            {
                doctor: 'dr. Annisa Septiningrum',
                times: {
                    senin: ['Jam 13.30 s/d 20.00'],
                    selasa: ['Jam 13.30 s/d 20.00'],
                    rabu: ['Jam 13.30 s/d 20.00'],
                },
            },
            {
                doctor: 'dr. Steven Arief Wibowo',
                times: {
                    jumat: ['Jam 07.00 s/d 13.30'],
                    sabtu: ['Jam 07.00 s/d 13.30', 'Jam 13.30 s/d 20.00'],
                },
            },
        ],
    },
    {
        title: 'Pelayanan Gigi',
        rows: [
            {
                doctor: 'drg. Annisaa Dayu Sinatrya',
                times: {
                    selasa: ['Jam 13.30 s/d 20.00'],
                    rabu: ['Jam 13.30 s/d 20.00'],
                    kamis: ['Jam 13.30 s/d 20.00'],
                },
            },
        ],
    },
];

const mode = computed(() => {
    if (scheduleModeFromCms.value === 'legacy') {
        return 'legacy';
    }
    if (scheduleModeFromCms.value === 'weekly') return 'weekly';

    // Default: tampilkan jadwal mingguan (grid) agar konsisten dengan poster jadwal.
    return 'weekly';
});

const weeklyGroups = computed(() => {
    return weeklyGroupsFromCms.value.length ? weeklyGroupsFromCms.value : defaultWeeklyGroups;
});

const showAdminHint = computed(() => {
    return !scheduleModeFromCms.value && !weeklyGroupsFromCms.value.length && !legacySchedules.value.length;
});

const canShowLegacy = computed(() => {
    return scheduleModeFromCms.value === 'legacy' && legacySchedules.value.length > 0;
});
</script>

<template>
    <Head title="Jadwal Dokter Praktik" />
    <MainLayout>
        <HeroSection
            :title="pageData?.title || 'Jadwal Dokter Praktik'"
            subtitle="Klinik PMI"
            :description="pageData?.content?.hero_description || 'Informasi waktu praktik dokter di Klinik Pratama PMI Kabupaten Wonosobo.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div v-if="mode === 'weekly'" class="max-w-6xl mx-auto">
                <div class="bg-white/90 backdrop-blur rounded-[3rem] shadow-2xl border border-gray-100 p-6 sm:p-10">
                    <DoctorWeeklySchedule :groups="weeklyGroups" />
                </div>
                <div v-if="showAdminHint" class="mt-6 text-center text-sm text-gray-500">
                    Admin dapat mengubah jadwal di menu <span class="font-semibold text-gray-700">Manage → Pages → Jadwal Dokter</span>.
                </div>
            </div>

            <div v-else-if="canShowLegacy" class="max-w-5xl mx-auto">
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
                                <tr v-for="(s, idx) in legacySchedules" :key="idx" class="hover:bg-red-50/50 transition-colors group">
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
                <p class="text-gray-500 text-lg">Administrator sedang mengupdate jadwal dokter terbaru.</p>
            </div>
        </div>
    </MainLayout>
</template>
