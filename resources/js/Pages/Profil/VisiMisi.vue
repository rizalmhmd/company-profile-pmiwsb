<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const visi = computed(() => {
    return props.pageData?.content?.sections?.find(s => s.title.includes('VISI'))?.items[0] 
        || "Terwujudnya PMI yang profesional dan berintegritas serta bergerak bersama masyarakat";
});

const missions = computed(() => {
    const section = props.pageData?.content?.sections?.find(s => s.title.includes('MISI'));
    if (section) {
        return section.items.map(item => ({
            title: item.split(' ')[0],
            description: item
        }));
    }
    return [
        {
            title: "MEMELIHARA",
            description: "Reputasi organisasi PMI di tingkat Nasional dan Internasional"
        },
        {
            title: "MENJADI",
            description: "Organisasi kemanusiaan terdepan yang memberikan layanan berkualitas"
        }
    ];
});

const strategicSections = computed(() => {
    return props.pageData?.content?.sections?.filter(s => {
        const title = s.title.toUpperCase();
        return !title.includes('VISI') && !title.includes('MISI');
    }) || [];
});
</script>

<template>
    <Head title="Visi & Misi" />
    <MainLayout>
        <!-- Hero Section -->
        <HeroSection 
            title="Visi, Misi & Strategi" 
            subtitle="Tentang Kami" 
            :description="pageData?.content?.hero_description || 'Arah dan landasan utama Palang Merah Indonesia Kabupaten Wonosobo dalam menjalankan misi kemanusiaan.'"
        />

        <!-- Visi Section -->
        <section class="py-20 -mt-10 relative z-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-16 border border-gray-100 relative overflow-hidden text-center">
                    <h2 class="text-red-600 font-black uppercase tracking-[0.2em] mb-4 text-sm">Visi Kami</h2>
                    <p class="text-xl md:text-3xl font-bold text-gray-800 leading-tight italic">
                        "{{ visi }}"
                    </p>
                </div>
            </div>
        </section>

        <!-- Misi Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-4xl font-black text-gray-800 mb-4">Misi Organisasi</h2>
                    <div class="w-16 h-1.5 bg-red-600 mx-auto rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="(misi, idx) in missions" :key="idx" class="bg-white p-8 rounded-3xl shadow-lg border-b-8 border-red-600 transition hover:-translate-y-2 group">
                        <div class="text-4xl font-black text-gray-100 group-hover:text-red-50 transition mb-4">{{ idx + 1 }}</div>
                        <h3 class="text-lg font-black text-red-600 mb-4 tracking-wider">{{ misi.title }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-medium">{{ misi.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Strategic Sections -->
        <section v-for="(section, sIdx) in strategicSections" :key="sIdx" class="py-24 bg-white border-b border-gray-100 last:border-0">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">{{ section.title }}</h2>
                    <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div v-for="(item, iIdx) in section.items" :key="iIdx" class="flex gap-4 p-8 bg-gray-50 rounded-[2rem] hover:bg-red-50 transition group">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-red-600 shadow-sm shrink-0 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-gray-700 font-semibold leading-relaxed">{{ item }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-gray-900 text-white">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-2xl font-bold mb-8">Ingin berkontribusi bersama kami?</h3>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/donor/registrasi" class="bg-red-600 hover:bg-red-700 px-8 py-4 rounded-xl font-bold transition shadow-xl">Daftar Relawan</a>
                    <a href="https://wa.me/6285742750060" target="_blank" class="bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md px-8 py-4 rounded-xl font-bold transition">Hubungi Kami</a>
                </div>
            </div>
        </section>
    </MainLayout>
</template>