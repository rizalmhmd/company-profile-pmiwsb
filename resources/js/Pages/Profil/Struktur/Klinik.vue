<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const legacySections = computed(() => props.pageData?.content?.sections || []);

const clinicStructure = computed(() => {
    const fromCms = props.pageData?.content?.clinic_structure;
    if (fromCms?.head && fromCms?.admin && fromCms?.clinical && fromCms?.functional) return fromCms;

    return {
        head: 'Kepala Klinik',
        admin: {
            title: 'Kepala Bagian Administrasi dan Tata Kelola',
            subbags: [
                {
                    title: 'Ka. Subbag. Keuangan',
                    persons_in_charge: ['Pj. Kasir', 'Pj. Anggaran', 'Pj. Jasa Pelayanan dan Jasa Medis'],
                },
                {
                    title: 'Ka. Subbag. Umum dan Kepegawaian',
                    persons_in_charge: ['Pj. Umum', 'Pj. Kepegawaian'],
                },
                {
                    title: 'Ka. Subbag. Sarana Prasarana dan Logistik',
                    persons_in_charge: ['Pj. Sarana dan Prasarana', 'Pj. Logistik'],
                },
            ],
        },
        functional: {
            title: 'Kelompok Fungsional',
            roles: [
                'Dokter Umum',
                'Dokter Gigi',
                'Perawat',
                'Perawat Gigi',
                'Bidan',
                'Apoteker',
                'Asisten Apoteker',
                'Sanitarian',
                'Sopir',
            ],
        },
        clinical: {
            title: 'Kepala Bidang Pelayanan Klinis',
            subbids: [
                { title: 'Ka. Subbid Pelayanan Pendaftaran', persons_in_charge: [] },
                { title: 'Ka. Subbid Pelayanan Umum', persons_in_charge: [] },
                { title: 'Ka. Subbid Pelayanan KIA-KB', persons_in_charge: ['Pj. Pelayanan KIA', 'Pj. Pelayanan KB'] },
                { title: 'Ka. Subbid Pelayanan Gigi', persons_in_charge: [] },
                { title: 'Ka. Subbid Pelayanan Kefarmasian', persons_in_charge: ['Pj. Ruang Pelayanan Obat', 'Pj. Gudang Obat dan Bahan Habis Pakai'] },
                { title: 'Ka. Subbid Pelayanan Kamar Bersalin dan Ruang Nifas', persons_in_charge: ['Pj. Pelayanan Kamar Bersalin', 'Pj. Pelayanan Ruang Nifas'] },
                {
                    title: 'Ka. Subbid Pelayanan Penunjang',
                    persons_in_charge: [
                        'Pj. Pelayanan Rekam Medis',
                        'Pj. Pelayanan Laboratorium',
                        'Pj. Pelayanan Radiologi',
                        'Pj. Pelayanan Operasional Ambulans',
                    ],
                },
            ],
        },
    };
});
</script>

<template>
    <Head title="Struktur Klinik" />
    <MainLayout>
        <HeroSection 
            :title="pageData?.title || 'Struktur Klinik PMI'" 
            subtitle="Klinik Pratama" 
            :description="pageData?.content?.hero_description || 'Manajemen dan tenaga medis profesional Klinik PMI Kabupaten Wonosobo.'"
        />

        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-8">
            <div class="max-w-5xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[450px] object-cover" alt="Featured Image">
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="max-w-6xl mx-auto">
                <div class="relative overflow-hidden rounded-[3rem] border border-gray-100 bg-white/80 shadow-2xl backdrop-blur p-6 sm:p-10">
                    <div class="pointer-events-none absolute inset-0">
                        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-red-600/10 blur-3xl" />
                        <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-gray-900/10 blur-3xl" />
                        <div class="absolute inset-0 opacity-[0.06] [background-image:radial-gradient(#111827_1px,transparent_1px)] [background-size:18px_18px]" />
                    </div>

                    <div class="relative">
                        <!-- Head -->
                        <div class="flex justify-center">
                            <div class="group relative">
                                <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-red-600/20 to-gray-900/15 blur opacity-60 group-hover:opacity-90 transition" />
                                <div class="relative w-[320px] min-h-[96px] flex flex-col justify-center px-12 py-6 rounded-2xl border border-gray-200 bg-white shadow-lg text-center">
                                    <div class="text-[11px] uppercase tracking-[0.22em] font-black text-gray-400">Level 1</div>
                                    <div class="mt-1 text-xl font-black tracking-tight text-gray-900">{{ clinicStructure.head }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                            <!-- Admin -->
                            <div class="rounded-3xl border border-gray-100 bg-white shadow-sm p-6">
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-500">Administrasi</div>
                                <div class="mt-2 text-lg font-black text-gray-900">{{ clinicStructure.admin.title }}</div>

                                <div class="mt-5 space-y-4">
                                    <div v-for="(sb, idx) in clinicStructure.admin.subbags" :key="idx" class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                        <div class="font-black text-gray-900 text-sm">{{ sb.title }}</div>
                                        <ul v-if="sb.persons_in_charge?.length" class="mt-2 space-y-1 text-sm text-gray-700">
                                            <li v-for="(pj, pjIdx) in sb.persons_in_charge" :key="pjIdx" class="flex gap-2">
                                                <span class="mt-1 h-1.5 w-1.5 rounded-full bg-red-600/70 shrink-0"></span>
                                                <span class="font-semibold">{{ pj }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Clinical head -->
                            <div class="rounded-3xl border border-gray-100 bg-white shadow-sm p-6">
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-500">Pelayanan</div>
                                <div class="mt-2 text-lg font-black text-gray-900">{{ clinicStructure.clinical.title }}</div>

                                <div class="mt-5 grid grid-cols-1 gap-4">
                                    <div v-for="(sb, idx) in clinicStructure.clinical.subbids" :key="idx" class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                        <div class="font-black text-gray-900 text-sm">{{ sb.title }}</div>
                                        <ul v-if="sb.persons_in_charge?.length" class="mt-2 space-y-1 text-sm text-gray-700">
                                            <li v-for="(pj, pjIdx) in sb.persons_in_charge" :key="pjIdx" class="flex gap-2">
                                                <span class="mt-1 h-1.5 w-1.5 rounded-full bg-red-600/70 shrink-0"></span>
                                                <span class="font-semibold">{{ pj }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Functional -->
                            <div class="rounded-3xl border border-gray-100 bg-white shadow-sm p-6">
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-500">Fungsional</div>
                                <div class="mt-2 text-lg font-black text-gray-900">{{ clinicStructure.functional.title }}</div>

                                <div class="mt-5 grid grid-cols-2 gap-3">
                                    <div v-for="(role, idx) in clinicStructure.functional.roles" :key="idx" class="rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm font-bold text-gray-800">
                                        {{ role }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Optional: legacy sections fallback if still used -->
                        <div v-if="legacySections.length" class="mt-12 pt-10 border-t border-gray-100">
                            <div class="text-sm font-black uppercase tracking-widest text-gray-400">Informasi Tambahan</div>
                            <div class="mt-6 space-y-8">
                                <div v-for="(section, sIdx) in legacySections" :key="sIdx" class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                                    <div class="text-lg font-black text-gray-900">{{ section.title }}</div>
                                    <ul class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
                                        <li v-for="(item, iIdx) in section.items" :key="iIdx" class="rounded-2xl bg-gray-50 border border-gray-100 px-4 py-3 font-semibold">
                                            {{ item }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
