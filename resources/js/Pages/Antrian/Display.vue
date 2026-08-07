<template>
    <Head title="Display Antrian" />
    <div class="min-h-screen bg-slate-50 flex flex-col font-sans overflow-hidden">
        <!-- Header (Clean Medical Style) -->
        <header class="bg-white/90 backdrop-blur-xl px-8 py-5 flex justify-between items-center border-b border-slate-200 shadow-sm z-10">
            <div class="flex items-center space-x-4">
                <img :src="siteSetting?.logo_url || '/logo.png'" alt="Logo" class="h-12 object-contain" />
                <div class="text-slate-800 font-bold text-2xl tracking-wide hidden sm:block">
                    {{ siteSetting?.site_name || 'Palang Merah Indonesia' }}
                </div>
            </div>
            <div class="flex items-center space-x-8">
                <div class="text-right">
                    <div class="text-rose-600 text-sm font-bold tracking-widest uppercase mb-0.5">{{ currentDate }}</div>
                    <div class="text-slate-800 text-5xl font-black tracking-tighter">{{ currentTime }}</div>
                </div>
                <div class="h-12 w-px bg-slate-300"></div>
                <button @click="toggleFullscreen" class="p-3 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all duration-300" title="Layar Penuh (Full Screen)">
                    <svg v-if="!isFullscreen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <svg v-else class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h4v4m0-4l-5 5m15-5h-4v4m0-4l5 5M4 10h4V6m0 4L3 5m15 5h-4V6m0 4l5-5" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col lg:flex-row p-6 gap-6 h-[calc(100vh-160px)] relative z-10">
            
            <!-- Left Side (Queue Status) -->
            <div class="w-full lg:w-1/3 flex flex-col gap-6 h-full">
                
                <!-- Calling Card Premium Light -->
                <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_-12px_rgba(225,29,72,0.2)] flex flex-col h-2/5 border border-slate-100 overflow-hidden relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-white opacity-50"></div>
                    <div class="relative z-10 flex-1 flex flex-col">
                        <div class="text-rose-600 text-center font-black py-4 mt-2 text-xl tracking-[0.2em] uppercase">
                            Memanggil Antrian
                        </div>
                        <div class="flex-1 flex flex-col justify-center items-center p-4">
                            <div class="text-slate-800 text-8xl md:text-[7rem] font-black tracking-tighter leading-none mb-3 drop-shadow-sm">
                                {{ activeCalling?.queue_number || '---' }}
                            </div>
                            <div class="text-slate-500 text-2xl font-bold uppercase tracking-widest text-center line-clamp-1">
                                {{ activeCalling?.patient_name || 'Nama Pasien' }}
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-rose-600 to-red-500 py-5 text-center flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            <span class="text-white font-black text-2xl uppercase tracking-widest shadow-sm">
                                {{ activeCalling?.counter?.name || 'NAMA LOKET' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Recent List -->
                <div class="flex-1 flex flex-col gap-4 overflow-hidden">
                    <div v-for="(queue, i) in recentQueues" :key="queue.id || i" 
                         class="bg-white rounded-2xl shadow-sm border border-slate-100 flex items-stretch h-[20%] overflow-hidden hover:shadow-md transition-shadow">
                        <div class="flex-1 p-5 flex flex-col justify-center">
                            <div class="text-slate-800 font-bold text-xl uppercase leading-tight line-clamp-1">
                                {{ queue?.counter?.name || 'Nama Poli' }}
                            </div>
                            <div class="text-slate-500 text-sm font-semibold uppercase tracking-wider line-clamp-1 mt-1">
                                {{ queue?.patient_name || 'Nama Pasien' }}
                            </div>
                        </div>
                        <div class="bg-slate-50 w-1/3 flex items-center justify-center border-l border-slate-100">
                            <span class="text-rose-600 font-black text-4xl">{{ queue?.queue_number || '---' }}</span>
                        </div>
                    </div>
                    
                    <!-- Default List Layout (if less than 4 queues exist) -->
                    <div v-for="n in Math.max(0, defaultPolis.length - (recentQueues?.length || 0))" :key="'empty'+n" 
                         class="bg-white/60 rounded-2xl shadow-sm border border-slate-100 flex items-stretch h-[20%] overflow-hidden opacity-60 grayscale hover:grayscale-0 transition-all">
                        <div class="flex-1 p-5 flex flex-col justify-center">
                            <div class="text-slate-600 font-bold text-xl uppercase leading-tight">{{ defaultPolis[recentQueues?.length + n - 1] || 'Nama Poli' }}</div>
                            <div class="text-slate-400 text-sm font-semibold uppercase tracking-wider mt-1">Kosong</div>
                        </div>
                        <div class="bg-slate-50/50 w-1/3 flex items-center justify-center border-l border-slate-100">
                            <span class="text-slate-300 font-black text-4xl">---</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side (Media) -->
            <div class="w-full lg:w-2/3 h-full rounded-[2rem] overflow-hidden shadow-2xl shadow-slate-300 ring-1 ring-slate-200 bg-slate-900 relative">
                <iframe v-if="mediaUrl && isYoutube(mediaUrl)"
                    class="absolute inset-0 w-full h-full"
                    :src="getYoutubeEmbedUrl(mediaUrl)" 
                    frameborder="0" 
                    allow="autoplay; encrypted-media" 
                    allowfullscreen>
                </iframe>
                <video v-else-if="mediaUrl"
                    class="absolute inset-0 w-full h-full object-cover"
                    :src="mediaUrl"
                    autoplay loop muted playsinline>
                </video>
                <div v-else class="absolute inset-0 flex items-center justify-center bg-slate-800 text-slate-500">
                    <span class="text-2xl font-semibold">Video tidak tersedia</span>
                </div>
            </div>
            
        </main>

        <!-- Footer Marquee -->
        <footer class="bg-rose-600 text-white py-4 overflow-hidden shadow-inner shrink-0 h-20 flex items-center mt-auto z-10 relative">
            <div class="whitespace-nowrap animate-marquee flex items-center gap-16">
                <template v-for="n in 3" :key="n">
                    <span class="text-3xl font-bold tracking-widest uppercase">{{ runningText }}</span>
                    <span class="text-3xl font-bold text-rose-300 tracking-widest">•</span>
                </template>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    settings: Object,
    siteSetting: Object,
});

const currentTime = ref('');
const currentDate = ref('');
const activeCalling = ref(null);
const recentQueues = ref([]);
const displaySettings = ref(props.settings || {});
const isFullscreen = ref(false);

const defaultPolis = [
    'Pelayanan Umum',
    'Pelayanan KIA-KB',
    'Pelayanan Gigi',
    'Pelayanan Kefarmasian'
];

const toggleFullscreen = () => {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch((err) => {
            console.error("Gagal fullscreen:", err.message);
        });
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
};

let intervalId = null;
let clockInterval = null;

// Clock Logic
const updateClock = () => {
    const now = new Date();
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    currentDate.value = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    currentTime.value = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
};

// Data Fetching Logic (Polling)
const fetchData = async () => {
    try {
        const response = await axios.get('/antrian/data');
        
        const newCalling = response.data.calling;
        
        // Cek jika ada antrian baru yang dipanggil
        if (newCalling && (!activeCalling.value || activeCalling.value.id !== newCalling.id || activeCalling.value.status !== newCalling.status)) {
            activeCalling.value = newCalling;
            speakQueue(newCalling);
        } else if (!newCalling) {
            activeCalling.value = null;
        }

        recentQueues.value = response.data.recent;
        
        if (response.data.settings) {
            displaySettings.value = response.data.settings;
        }
    } catch (error) {
        console.error("Gagal mengambil data antrian", error);
    }
};

// Text-to-Speech Logic
const speakQueue = (queue) => {
    if (!window.speechSynthesis) return;

    if (queue.status !== 'calling') return;

    const numbersArray = String(queue.queue_number).split('');
    const spelledNumbers = numbersArray.map(n => n === '0' ? 'kosong' : n).join(', ');

    const text = `Nomor Antrian, ${spelledNumbers}, Silakan menuju ke, ${queue.counter?.name}`;
    
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'id-ID';
    utterance.rate = 0.9;
    utterance.pitch = 1;

    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(utterance);
};

const mediaUrl = computed(() => displaySettings.value?.video_url);
const runningText = computed(() => displaySettings.value?.running_text || 'Selamat Datang di PMI.');

const isYoutube = (url) => {
    if (!url) return false;
    return url.includes('youtube.com') || url.includes('youtu.be');
};

const getYoutubeEmbedUrl = (url) => {
    if (!url) return '';
    if (url.includes('embed')) {
        return url.includes('?') ? url + '&autoplay=1&mute=1&loop=1' : url + '?autoplay=1&mute=1&loop=1';
    }
    
    let videoId = '';
    if (url.includes('youtu.be/')) {
        videoId = url.split('youtu.be/')[1].split('?')[0];
    } else if (url.includes('v=')) {
        videoId = url.split('v=')[1].split('&')[0];
    }

    return videoId ? `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}` : url;
};

onMounted(() => {
    updateClock();
    clockInterval = setInterval(updateClock, 1000);
    fetchData();
    intervalId = setInterval(fetchData, 3000);
    
    document.addEventListener('fullscreenchange', () => {
        isFullscreen.value = !!document.fullscreenElement;
    });
});

onUnmounted(() => {
    if (intervalId) clearInterval(intervalId);
    if (clockInterval) clearInterval(clockInterval);
    if (window.speechSynthesis) window.speechSynthesis.cancel();
});
</script>

<style>
@keyframes marquee {
  0% { transform: translateX(0%); }
  100% { transform: translateX(-33.33%); }
}
.animate-marquee {
  animation: marquee 20s linear infinite;
}
</style>
