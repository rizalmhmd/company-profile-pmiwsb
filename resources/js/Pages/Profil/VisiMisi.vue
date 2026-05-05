<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeroSection from '@/Components/HeroSection.vue';

const page = usePage();

const missions = [
    {
        title: "MEMELIHARA",
        description: "Reputasi organisasi PMI di tingkat Nasional dan Internasional"
    },
    {
        title: "MENJADI",
        description: "Organisasi kemanusiaan terdepan yang memberikan layanan berkualitas kepada masyarakat sesuai dengan prinsip-prinsip dasar Gerakan Palang Merah dan Bulan Sabit Merah"
    },
    {
        title: "MENINGKATKAN",
        description: "Integritas dan kemandirian organisasi melalui kerjasama strategis yang berkesinambungan dengan pemerintah, swasta, mitra gerakan, masyarakat, dan pemangku kepentingan lainnya di semua tingkatan"
    }
];

const goals = [
    {
        icon: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
        text: "MEMELIHARA reputasi dan meningkatkan akuntabilitas PMI sebagai organisasi kemanusiaan di tingkat Nasional maupun Internasional"
    },
    {
        icon: "M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z",
        text: "MENINGKATKAN ketersediaan darah yang aman, mudah dijangkau, berkualitas dan berkesinambungan di seluruh Indonesia"
    },
    {
        icon: "M12 4.354a4 4 0 110 8.048M7 10.5h10M3 19c0-2 2-4 9-4s9 2 9 4",
        text: "MENINGKATKAN rekrutmen dan pembinaan Relawan sebagai tulang-punggung layanan kemanusiaan PMI, baik secara kuantitas dan kualitas"
    },
    {
        icon: "M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z",
        text: "MENINGKATKAN mutu dan jangkauan pelayanan penanggulanan bencana, krisis kesehatan dan krisis kemanusiaan lainnya"
    },
    {
        icon: "M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4",
        text: "MEWUJUDKAN PMI yang berfungsi baik dengan tatakelola organisasi dan Markas yang sinergis"
    },
    {
        icon: "M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10",
        text: "MENINGKATKAN kapasitas PMI dalam mengelola infrastruktur material dasar untuk mendukung operasional"
    },
    {
        icon: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z",
        text: "MENINGKATKAN kemandirian organisasi PMI secara berkesinambungan melalui kerjasama strategis"
    }
];
</script>

<template>
    <Head title="Visi & Misi" />
    <MainLayout>
        <!-- Hero Section -->
        <HeroSection 
            title="Visi, Misi & Strategi" 
            subtitle="Tentang Kami" 
            description="Arah dan landasan utama Palang Merah Indonesia Kabupaten Wonosobo dalam menjalankan misi kemanusiaan."
        />

        <!-- Visi Section -->
        <section class="py-20 -mt-10 relative z-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-16 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-12 text-red-50 opacity-10">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9125 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9125 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9125 3 16.017 3H21.017C22.1216 3 23.017 3.89543 23.017 5V15C23.017 18.3137 20.3308 21 17.017 21H14.017ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H3.017C1.91243 8 1.017 7.10457 1.017 6V5C1.017 3.89543 1.91243 3 3.017 3H8.017C9.12157 3 10.017 3.89543 10.017 5V15C10.017 18.3137 7.33076 21 4.017 21H1.017Z" /></svg>
                    </div>
                    
                    <div class="relative z-10 text-center">
                        <h2 class="text-red-600 font-black uppercase tracking-[0.2em] mb-4 text-sm">Visi Kami</h2>
                        <p class="text-xl md:text-3xl font-bold text-gray-800 leading-tight italic">
                            "Terwujudnya PMI yang <span class="text-red-600">profesional</span> dan <span class="text-red-600">berintegritas</span> serta bergerak bersama masyarakat"
                        </p>
                    </div>
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

        <!-- Tujuan Strategis Section -->
        <section class="py-24 bg-white relative overflow-hidden">
            <!-- Decorative element -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-gray-100 to-transparent"></div>
            
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/3">
                        <h2 class="text-3xl md:text-4xl font-black text-gray-800 mb-6 leading-tight">Tujuan <span class="text-red-600">Strategis</span></h2>
                        <p class="text-gray-500 text-base leading-relaxed mb-8">
                            Tujuh pilar utama yang menjadi fokus pengembangan PMI untuk mencapai visi organisasi yang dicintai dan dipercaya.
                        </p>
                        <div class="flex items-center gap-4 p-6 bg-red-50 rounded-2xl border border-red-100">
                            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-red-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-red-900 uppercase tracking-widest">Komitmen Kemanusiaan</p>
                        </div>
                    </div>
                    
                    <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div v-for="(goal, idx) in goals" :key="idx" class="flex gap-4 p-6 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100 group">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 group-hover:bg-red-100 group-hover:text-red-600 transition shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="goal.icon"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-700 leading-relaxed font-semibold text-sm">{{ goal.text }}</p>
                            </div>
                        </div>
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

<style scoped>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 7s infinite;
}
</style>