<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';

import { computed } from 'vue';

const props = defineProps({
    pageData: Object,
});

const principles = computed(() => {
    if (props.pageData?.content?.principles) {
        return props.pageData.content.principles.map(p => ({
            ...p,
            english: p.subtitle, // Adapt field name from JSON
            icon: getIconPath(p.icon),
            color: getColorClass(p.color)
        }));
    }
    
    return [
        {
            title: "Kemanusiaan",
            english: "Humanity",
            icon: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
            color: "bg-red-50 text-red-600 border-red-100",
            description: "Lahir dari keinginan untuk memberikan pertolongan tanpa membeda-bedakan korban luka di medan pertempuran, mencegah dan mengatasi penderitaan manusia di mana pun mereka berada."
        },
        {
            title: "Kesamaan",
            english: "Impartiality",
            icon: "M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z",
            color: "bg-blue-50 text-blue-600 border-blue-100",
            description: "Gerakan ini tidak membedakan atas dasar kebangsaan, ras, agama, status sosial atau pandangan politik."
        },
        {
            title: "Kenetralan",
            english: "Neutrality",
            icon: "M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z",
            color: "bg-gray-50 text-gray-600 border-gray-100",
            description: "Agar senantiasa mendapat kepercayaan dari semua pihak, Gerakan ini tidak boleh melibatkan diri dalam pertikaian politik, ras, agama, atau ideologi."
        },
        {
            title: "Kemandirian",
            english: "Independence",
            icon: "M13 10V3L4 14h7v7l9-11h-7z",
            color: "bg-yellow-50 text-yellow-600 border-yellow-100",
            description: "Gerakan ini bersifat mandiri. Meskipun Perhimpunan Nasional merupakan penolong bagi pemerintah dalam bidang kemanusiaan."
        },
        {
            title: "Kesukarelaan",
            english: "Voluntary Service",
            icon: "M14 10h2a2 2 0 012 2v1a2 2 0 01-2 2H8a2 2 0 01-2-2v-1a2 2 0 012-2h2m4 0V7a2 2 0 10-4 0v3m4 0h-4",
            color: "bg-green-50 text-green-600 border-green-100",
            description: "Gerakan ini adalah gerakan pemberi bantuan sukarela, yang tidak didasari oleh keinginan untuk mencari keuntungan apa pun."
        },
        {
            title: "Kesatuan",
            english: "Unity",
            icon: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
            color: "bg-purple-50 text-purple-600 border-purple-100",
            description: "Di dalam satu negara hanya boleh ada satu Perhimpunan Palang Merah atau Bulan Sabit Merah."
        },
        {
            title: "Kesemestaan",
            english: "Universality",
            icon: "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2 2 2 0 012 2v.654M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
            color: "bg-indigo-50 text-indigo-600 border-indigo-100",
            description: "Di dalam gerakan ini semua perhimpunan nasional mempunyai status yang sederajat dan berbagi tanggung jawab."
        }
    ];
});

const getIconPath = (name) => {
    const icons = {
        heart: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
        scale: "M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z",
        shield: "M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z",
        lightning: "M13 10V3L4 14h7v7l9-11h-7z",
        hand: "M14 10h2a2 2 0 012 2v1a2 2 0 01-2 2H8a2 2 0 01-2-2v-1a2 2 0 012-2h2m4 0V7a2 2 0 10-4 0v3m4 0h-4",
        users: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
        globe: "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2 2 2 0 012 2v.654M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
    };
    return icons[name] || name;
};

const getColorClass = (name) => {
    const colors = {
        red: "bg-red-50 text-red-600 border-red-100",
        orange: "bg-orange-50 text-orange-600 border-orange-100",
        blue: "bg-blue-50 text-blue-600 border-blue-100",
        yellow: "bg-yellow-50 text-yellow-600 border-yellow-100",
        green: "bg-green-50 text-green-600 border-green-100",
        purple: "bg-purple-50 text-purple-600 border-purple-100",
        indigo: "bg-indigo-50 text-indigo-600 border-indigo-100",
        gray: "bg-gray-50 text-gray-600 border-gray-100"
    };
    return colors[name] || "bg-gray-50 text-gray-600 border-gray-100";
};
</script>

<template>
    <Head title="7 Prinsip Dasar" />
    <MainLayout>
        <!-- Hero Section -->
        <HeroSection 
            title="7 Prinsip Dasar" 
            subtitle="Profil Kami" 
            :description="pageData?.content?.hero_description || 'Landasan utama Gerakan Palang Merah dan Bulan Sabit Merah Internasional dalam menjalankan misi kemanusiaan di seluruh dunia.'"
        />

        <!-- Content -->
        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(principle, index) in principles" :key="index" 
                     class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col items-start"
                     :class="{'lg:col-span-2 lg:flex-row lg:items-center lg:gap-8': index === 0}">
                    
                    <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center mb-6 lg:mb-0 border transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3"
                         :class="principle.color">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="principle.icon" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-4xl font-black text-gray-100 group-hover:text-red-50 transition-colors">{{ index + 1 }}</span>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 leading-none">{{ principle.title }}</h3>
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mt-1">{{ principle.english }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                            {{ principle.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Conclusion Section -->
            <div class="mt-20 bg-gray-900 rounded-[3rem] p-8 md:p-16 text-center overflow-hidden relative">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-64 h-64 bg-red-600 rounded-full blur-[100px] opacity-20"></div>
                <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-64 h-64 bg-blue-600 rounded-full blur-[100px] opacity-20"></div>
                
                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Komitmen Kemanusiaan</h2>
                    <p class="text-gray-400 text-lg leading-relaxed mb-8">
                        Ketujuh prinsip ini diadopsi oleh Konferensi Internasional Palang Merah ke-20 di Wina pada tahun 1965. Prinsip-prinsip ini mengikat seluruh Gerakan dan menjadi identitas serta panduan moral bagi setiap relawan dan staf PMI.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="/profil/sejarah" class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold transition shadow-lg shadow-red-900/20">Sejarah PMI</a>
                        <a href="/" class="px-8 py-4 bg-gray-800 hover:bg-gray-700 text-white rounded-2xl font-bold transition border border-gray-700">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.container {
    max-width: 1200px;
}
</style>