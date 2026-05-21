<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const chart = computed(() => {
    const fromCms = props.pageData?.content?.org_chart;
    if (fromCms?.pengurus && fromCms?.sekretariat && Array.isArray(fromCms?.units)) {
        return fromCms;
    }
    return {
        pengurus: 'Pengurus',
        sekretariat: 'Sekretariat',
        units: ['Markas', 'Unit Donor Darah', 'Klinik Pratama'],
    };
});
</script>

<template>
    <Head title="Struktur Organisasi" />
    <MainLayout>
        <HeroSection
            :title="pageData?.title || 'Struktur Organisasi'"
            subtitle="Profil PMI"
            :description="pageData?.content?.hero_description || 'Struktur organisasi PMI Kabupaten Wonosobo.'"
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="max-w-6xl mx-auto">
                <div class="relative overflow-hidden rounded-[3rem] border border-gray-100 bg-white/80 shadow-2xl backdrop-blur p-6 sm:p-10">
                    <!-- subtle premium background -->
                    <div class="pointer-events-none absolute inset-0">
                        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-red-600/10 blur-3xl" />
                        <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-gray-900/10 blur-3xl" />
                        <div class="absolute inset-0 opacity-[0.06] [background-image:radial-gradient(#111827_1px,transparent_1px)] [background-size:18px_18px]" />
                    </div>

                    <!-- Desktop (no lines; clear hierarchy) -->
                    <div class="relative hidden lg:block">
                        <div class="mx-auto max-w-6xl">
                            <div class="grid grid-cols-12 gap-8 items-start">
                                <!-- Pengurus -->
                                <div class="col-span-12 flex justify-center">
                                    <div class="group relative">
                                        <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-red-600/25 to-gray-900/20 blur opacity-60 group-hover:opacity-90 transition" />
                                        <div class="relative w-[300px] min-h-[96px] flex flex-col justify-center px-12 py-6 rounded-2xl border border-gray-200 bg-white shadow-lg text-center">
                                            <div class="text-[11px] uppercase tracking-[0.22em] font-black text-gray-400">Level 1</div>
                                            <div class="mt-1 text-xl font-black tracking-tight text-gray-900">{{ chart.pengurus }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chevron down -->
                                <div class="col-span-12 flex justify-center -mt-2 text-gray-400">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Row 2: Sekretariat aligned right -->
                                <div class="col-span-12 flex justify-center">
                                    <div class="group relative">
                                        <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-gray-900/20 to-red-600/20 blur opacity-60 group-hover:opacity-90 transition" />
                                        <div class="relative w-[340px] min-h-[96px] flex flex-col justify-center px-12 py-6 rounded-2xl border border-gray-200 bg-white shadow-lg text-center">
                                            <div class="text-[11px] uppercase tracking-[0.22em] font-black text-gray-400">Pendukung</div>
                                            <div class="mt-1 text-xl font-black tracking-tight text-gray-900">{{ chart.sekretariat }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chevron down -->
                                <div class="col-span-12 flex justify-center -mt-2 text-gray-400">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Units -->
                                <div class="col-span-12">
                                    <div class="grid grid-cols-3 gap-8">
                                        <div v-for="(u, idx) in chart.units" :key="idx" class="group relative">
                                            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-red-600/12 to-gray-900/12 blur opacity-60 group-hover:opacity-95 transition" />
                                            <div class="relative min-h-[104px] flex flex-col justify-center px-10 py-6 rounded-2xl border border-gray-200 bg-white shadow-lg text-center">
                                                <div class="text-[11px] uppercase tracking-[0.22em] font-black text-gray-400">Unit</div>
                                                <div class="mt-1 text-xl font-black tracking-tight text-gray-900">{{ u }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile / Tablet (clean cards) -->
                    <div class="lg:hidden space-y-6">
                        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                            <div class="text-[10px] font-black uppercase tracking-widest text-gray-500">Level 1</div>
                            <div class="mt-2 text-xl font-black text-gray-900">{{ chart.pengurus }}</div>
                        </div>

                        <div class="flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                            <div class="text-[10px] font-black uppercase tracking-widest text-gray-500">Pendukung</div>
                            <div class="mt-2 text-xl font-black text-gray-900">{{ chart.sekretariat }}</div>
                        </div>

                        <div class="flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div v-for="(u, idx) in chart.units" :key="idx" class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-500">Unit</div>
                                <div class="mt-2 text-lg font-black text-gray-900">{{ u }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
