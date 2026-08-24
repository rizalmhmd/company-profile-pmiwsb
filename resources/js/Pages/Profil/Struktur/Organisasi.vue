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
                <div class="relative overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white/70 shadow-2xl backdrop-blur-xl p-8 sm:p-16">
                    <!-- Subtle premium background glow -->
                    <div class="pointer-events-none absolute inset-0">
                        <div class="absolute -top-32 -right-32 h-[500px] w-[500px] rounded-full bg-red-600/5 blur-[100px]" />
                        <div class="absolute -bottom-32 -left-32 h-[500px] w-[500px] rounded-full bg-slate-500/10 blur-[100px]" />
                        <div class="absolute inset-0 opacity-[0.03] [background-image:radial-gradient(#000_1px,transparent_1px)] [background-size:16px_16px]" />
                    </div>

                    <div class="relative z-10 flex flex-col items-center">
                        
                        <!-- Level 1: Pengurus -->
                        <div class="relative flex flex-col items-center w-full">
                            <div class="group relative z-10 w-full max-w-[340px]">
                                <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-red-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                <div class="relative flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 border border-slate-100">
                                        Level 1
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 text-center">{{ chart.pengurus }}</h3>
                                </div>
                            </div>
                            <!-- Vertical Line Down -->
                            <div class="w-px h-10 bg-gray-300"></div>
                        </div>

                        <!-- Level 2: Sekretariat -->
                        <div class="relative flex flex-col items-center w-full">
                            <div class="group relative z-10 w-full max-w-[340px]">
                                <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-red-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                <div class="relative flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 border border-slate-100">
                                        Pendukung
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 text-center">{{ chart.sekretariat }}</h3>
                                </div>
                            </div>
                            <!-- Vertical Line Down -->
                            <div class="w-px h-10 bg-gray-300"></div>
                        </div>

                        <!-- Level 3: Units (Desktop) -->
                        <div class="hidden md:flex relative w-full max-w-5xl mt-0">
                            <!-- Horizontal Line Connecting Branches -->
                            <!-- 16.666% matches the center of the first and last child in a 3-column layout -->
                            <div class="absolute top-0 left-[16.666%] right-[16.666%] h-px bg-gray-300"></div>
                            
                            <div v-for="(u, idx) in chart.units" :key="idx" class="relative w-1/3 flex flex-col items-center pt-8 px-4 lg:px-6">
                                <!-- Vertical Line to Branch -->
                                <div class="absolute top-0 w-px h-8 bg-gray-300"></div>
                                
                                <div class="group relative w-full h-full">
                                    <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-red-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                    <div class="relative h-full flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                                        <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 border border-slate-100">
                                            Unit
                                        </span>
                                        <h3 class="text-lg font-bold text-gray-900 text-center">{{ u }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Stack Structure -->
                        <div class="md:hidden flex flex-col items-center w-full relative -mt-4">
                            <div v-for="(u, idx) in chart.units" :key="idx" class="relative w-full flex flex-col items-center">
                                <!-- Connector line -->
                                <div v-if="idx > 0" class="w-px h-10 bg-gray-300"></div>
                                <!-- In mobile we need the first one to connect to the top line seamlessly -->
                                <div v-if="idx === 0" class="w-px h-4 bg-gray-300"></div>
                                
                                <div class="group relative w-full max-w-[340px]">
                                    <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-red-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>
                                    <div class="relative h-full flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-200/75 border-t-[6px] border-t-red-600 bg-white shadow-sm hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                                        <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 border border-slate-100">
                                            Unit
                                        </span>
                                        <h3 class="text-lg font-bold text-gray-900 text-center">{{ u }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
