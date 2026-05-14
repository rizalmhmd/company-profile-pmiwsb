<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    service: Object,
});
</script>

<template>
    <Head :title="service?.title || 'Detail Layanan'" />
    <MainLayout>
        <HeroSection 
            :title="service?.title" 
            subtitle="Layanan Kami" 
            :description="service?.description"
        />

        <div class="container mx-auto px-4 py-16 -mt-16 relative z-20">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-[3.5rem] shadow-2xl border border-gray-100 overflow-hidden relative">
                    <!-- Top Visual Accent -->
                    <div class="h-4 bg-red-600"></div>
                    
                    <div class="p-8 md:p-20">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-12 mb-16">
                            <!-- Large Icon/Image -->
                            <div class="w-32 h-32 sm:w-48 sm:h-48 bg-gray-50 rounded-[2.5rem] flex items-center justify-center text-red-600 shadow-2xl shadow-red-100 border border-red-50 shrink-0 relative overflow-hidden group">
                                <img v-if="service?.image_url" :src="service.image_url" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="Service Image">
                                <svg v-else class="w-16 h-16 sm:w-24 sm:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" :d="service?.icon || 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'"></path>
                                </svg>
                            </div>

                            <div class="flex-1 text-center md:text-left">
                                <div class="inline-block px-4 py-1.5 bg-red-50 text-red-600 text-xs font-black uppercase tracking-[0.2em] rounded-full mb-6">
                                    Layanan Markas
                                </div>
                                <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-6 leading-tight">{{ service?.title }}</h1>
                                <p class="text-gray-400 font-bold uppercase tracking-[0.3em] text-sm">PMI Kabupaten Wonosobo</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                            <div class="lg:col-span-2">
                                <h3 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-3">
                                    <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                                    Deskripsi Layanan
                                </h3>
                                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
                                    {{ service?.description }}
                                </div>
                            </div>

                            <div class="space-y-8">
                                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                                    <h3 class="text-lg font-black text-gray-900 mb-6">Informasi Kontak</h3>
                                    <div class="space-y-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-red-600 border border-red-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-700">(0286) 321149</p>
                                        </div>
                                        <a href="https://wa.me/6285742750060" target="_blank" class="flex items-center gap-4 group">
                                            <div class="w-10 h-10 bg-green-500 rounded-xl shadow-lg shadow-green-100 flex items-center justify-center text-white transition group-hover:scale-110">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .018 5.393 0 12.026c0 2.119.554 4.188 1.604 6.048l-1.704 6.23 6.375-1.673A11.85 11.85 0 0012.05 24c6.635 0 12.032-5.396 12.035-12.028a11.91 11.91 0 00-3.522-8.502z"/></svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-700 group-hover:text-green-600 transition">Chat WhatsApp</p>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="bg-red-600 rounded-3xl p-8 text-white shadow-xl shadow-red-100">
                                    <h3 class="text-lg font-bold mb-4 leading-tight">Siap Melayani 24 Jam</h3>
                                    <p class="text-red-100 text-xs mb-6 leading-relaxed">PMI Kabupaten Wonosobo berkomitmen memberikan pelayanan terbaik untuk kemanusiaan.</p>
                                    <a href="/markas/sibats" class="inline-block bg-white text-red-600 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg">Layanan Ambulance</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
