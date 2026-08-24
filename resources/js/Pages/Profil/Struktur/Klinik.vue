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
            <div class="max-w-7xl mx-auto">
                <div class="relative overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white/70 shadow-2xl backdrop-blur-xl p-6 sm:p-12 lg:p-16">
                    <!-- Subtle premium background glow -->
                    <div class="pointer-events-none absolute inset-0">
                        <div class="absolute -top-32 -right-32 h-[500px] w-[500px] rounded-full bg-red-600/5 blur-[100px]" />
                        <div class="absolute -bottom-32 -left-32 h-[500px] w-[500px] rounded-full bg-slate-500/10 blur-[100px]" />
                        <div class="absolute inset-0 opacity-[0.03] [background-image:radial-gradient(#000_1px,transparent_1px)] [background-size:16px_16px]" />
                    </div>

                    <div class="relative z-10 flex flex-col items-center">
                        <!-- Level 1: Kepala Klinik -->
                        <div class="relative flex flex-col items-center w-full">
                            <div class="group relative z-10 w-full max-w-[340px]">
                                <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-red-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                <div class="relative flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 border border-slate-100">
                                        Level 1
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 text-center">{{ clinicStructure.head }}</h3>
                                </div>
                            </div>
                            <!-- Vertical Line Down (Desktop) -->
                            <div class="w-px h-12 bg-gray-300 hidden lg:block"></div>
                        </div>

                        <!-- Row 2: 3 Columns (Desktop) -->
                        <div class="hidden lg:flex relative w-full mt-0">
                            <!-- Horizontal Line Connecting Branches -->
                            <div class="absolute top-0 left-[16.666%] right-[16.666%] h-px bg-gray-300"></div>
                            
                            <!-- Column 1: Admin -->
                            <div class="relative w-1/3 flex flex-col pt-8 px-4">
                                <!-- Vertical Line -->
                                <div class="absolute top-0 left-1/2 w-px h-8 bg-gray-300 -translate-x-1/2"></div>
                                
                                <div class="group relative h-full flex flex-col">
                                    <div class="absolute -inset-0.5 rounded-3xl bg-gradient-to-br from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                    <div class="relative h-full flex flex-col rounded-3xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm p-6 hover:shadow-xl transition-all duration-300">
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Administrasi</div>
                                        <div class="mt-2 text-lg font-bold text-gray-900 text-center pb-4 border-b border-gray-100">{{ clinicStructure.admin.title }}</div>

                                        <div class="mt-5 space-y-4 flex-grow">
                                            <div v-for="(sb, idx) in clinicStructure.admin.subbags" :key="idx" class="rounded-xl border border-gray-100 bg-slate-50 hover:bg-white hover:border-red-200 hover:shadow-md transition-all duration-300 p-4">
                                                <div class="font-bold text-gray-900 text-sm">{{ sb.title }}</div>
                                                <ul v-if="sb.persons_in_charge?.length" class="mt-3 space-y-2 text-sm text-gray-600">
                                                    <li v-for="(pj, pjIdx) in sb.persons_in_charge" :key="pjIdx" class="flex items-start gap-2">
                                                        <span class="mt-1.5 h-1.5 w-1.5 rounded-full bg-red-500 shrink-0"></span>
                                                        <span class="font-medium">{{ pj }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: Clinical -->
                            <div class="relative w-1/3 flex flex-col pt-8 px-4">
                                <!-- Vertical Line -->
                                <div class="absolute top-0 left-1/2 w-px h-8 bg-gray-300 -translate-x-1/2"></div>
                                
                                <div class="group relative h-full flex flex-col">
                                    <div class="absolute -inset-0.5 rounded-3xl bg-gradient-to-br from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                    <div class="relative h-full flex flex-col rounded-3xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm p-6 hover:shadow-xl transition-all duration-300">
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Pelayanan</div>
                                        <div class="mt-2 text-lg font-bold text-gray-900 text-center pb-4 border-b border-gray-100">{{ clinicStructure.clinical.title }}</div>

                                        <div class="mt-5 space-y-4 flex-grow">
                                            <div v-for="(sb, idx) in clinicStructure.clinical.subbids" :key="idx" class="rounded-xl border border-gray-100 bg-slate-50 hover:bg-white hover:border-red-200 hover:shadow-md transition-all duration-300 p-4">
                                                <div class="font-bold text-gray-900 text-sm">{{ sb.title }}</div>
                                                <ul v-if="sb.persons_in_charge?.length" class="mt-3 space-y-2 text-sm text-gray-600">
                                                    <li v-for="(pj, pjIdx) in sb.persons_in_charge" :key="pjIdx" class="flex items-start gap-2">
                                                        <span class="mt-1.5 h-1.5 w-1.5 rounded-full bg-red-500 shrink-0"></span>
                                                        <span class="font-medium">{{ pj }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Functional -->
                            <div class="relative w-1/3 flex flex-col pt-8 px-4">
                                <!-- Vertical Line -->
                                <div class="absolute top-0 left-1/2 w-px h-8 bg-gray-300 -translate-x-1/2"></div>
                                
                                <div class="group relative h-full flex flex-col">
                                    <div class="absolute -inset-0.5 rounded-3xl bg-gradient-to-br from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                    <div class="relative h-full flex flex-col rounded-3xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm p-6 hover:shadow-xl transition-all duration-300">
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Fungsional</div>
                                        <div class="mt-2 text-lg font-bold text-gray-900 text-center pb-4 border-b border-gray-100">{{ clinicStructure.functional.title }}</div>

                                        <div class="mt-5 grid grid-cols-2 gap-3 flex-grow content-start">
                                            <div v-for="(role, idx) in clinicStructure.functional.roles" :key="idx" class="rounded-xl border border-gray-100 bg-slate-50 hover:bg-red-50 hover:border-red-200 hover:text-red-700 hover:shadow-sm transition-all duration-300 px-3 py-3 text-sm font-semibold text-gray-700 text-center flex items-center justify-center">
                                                {{ role }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Stack Structure -->
                        <div class="lg:hidden flex flex-col items-center w-full relative -mt-4">
                            <!-- Column 1: Admin -->
                            <div class="relative w-full flex flex-col items-center">
                                <div class="w-px h-10 bg-gray-300"></div>
                                <div class="relative w-full flex flex-col rounded-3xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm p-6">
                                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Administrasi</div>
                                    <div class="mt-2 text-lg font-bold text-gray-900 text-center pb-4 border-b border-gray-100">{{ clinicStructure.admin.title }}</div>
                                    <div class="mt-5 space-y-4">
                                        <div v-for="(sb, idx) in clinicStructure.admin.subbags" :key="idx" class="rounded-xl border border-gray-100 bg-slate-50 p-4">
                                            <div class="font-bold text-gray-900 text-sm">{{ sb.title }}</div>
                                            <ul v-if="sb.persons_in_charge?.length" class="mt-3 space-y-2 text-sm text-gray-600">
                                                <li v-for="(pj, pjIdx) in sb.persons_in_charge" :key="pjIdx" class="flex items-start gap-2">
                                                    <span class="mt-1.5 h-1.5 w-1.5 rounded-full bg-red-500 shrink-0"></span>
                                                    <span class="font-medium">{{ pj }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: Clinical -->
                            <div class="relative w-full flex flex-col items-center">
                                <div class="w-px h-10 bg-gray-300"></div>
                                <div class="relative w-full flex flex-col rounded-3xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm p-6">
                                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Pelayanan</div>
                                    <div class="mt-2 text-lg font-bold text-gray-900 text-center pb-4 border-b border-gray-100">{{ clinicStructure.clinical.title }}</div>
                                    <div class="mt-5 space-y-4">
                                        <div v-for="(sb, idx) in clinicStructure.clinical.subbids" :key="idx" class="rounded-xl border border-gray-100 bg-slate-50 p-4">
                                            <div class="font-bold text-gray-900 text-sm">{{ sb.title }}</div>
                                            <ul v-if="sb.persons_in_charge?.length" class="mt-3 space-y-2 text-sm text-gray-600">
                                                <li v-for="(pj, pjIdx) in sb.persons_in_charge" :key="pjIdx" class="flex items-start gap-2">
                                                    <span class="mt-1.5 h-1.5 w-1.5 rounded-full bg-red-500 shrink-0"></span>
                                                    <span class="font-medium">{{ pj }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Functional -->
                            <div class="relative w-full flex flex-col items-center">
                                <div class="w-px h-10 bg-gray-300"></div>
                                <div class="relative w-full flex flex-col rounded-3xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm p-6">
                                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Fungsional</div>
                                    <div class="mt-2 text-lg font-bold text-gray-900 text-center pb-4 border-b border-gray-100">{{ clinicStructure.functional.title }}</div>
                                    <div class="mt-5 grid grid-cols-2 gap-3">
                                        <div v-for="(role, idx) in clinicStructure.functional.roles" :key="idx" class="rounded-xl border border-gray-100 bg-slate-50 px-3 py-3 text-sm font-semibold text-gray-700 text-center flex items-center justify-center">
                                            {{ role }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Optional: legacy sections fallback if still used -->
                        <div v-if="legacySections.length" class="mt-16 w-full pt-10 border-t border-gray-200/60">
                            <div class="text-sm font-black uppercase tracking-widest text-slate-400 text-center mb-8">Informasi Tambahan</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                <div v-for="(section, sIdx) in legacySections" :key="sIdx" class="rounded-3xl border border-gray-200/75 bg-white p-6 shadow-sm hover:shadow-md transition-all">
                                    <div class="text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">{{ section.title }}</div>
                                    <ul class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                                        <li v-for="(item, iIdx) in section.items" :key="iIdx" class="rounded-xl bg-slate-50 hover:bg-red-50 hover:text-red-700 border border-gray-100 px-4 py-3 font-semibold transition-colors">
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
