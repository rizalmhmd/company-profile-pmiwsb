<template>
    <Head title="Display Antrian" />
    <div class="min-h-screen bg-slate-100 flex flex-col font-sans overflow-hidden relative">
        
        <!-- Background Blobs -->
        <div class="absolute top-[-10%] right-[10%] w-[40%] h-[50%] bg-rose-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob z-0 pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[40%] h-[50%] bg-red-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob z-0 pointer-events-none" style="animation-delay: 2s;"></div>

        <main class="flex-1 flex flex-col lg:flex-row h-[calc(100vh-5rem)]">
            
            <!-- LEFT SIDEBAR (The PMI Red Theme) -->
            <div class="w-full lg:w-[35%] xl:w-[30%] bg-rose-600 text-white flex flex-col relative overflow-hidden shadow-[20px_0_50px_rgba(0,0,0,0.15)] z-20 border-r border-rose-700">
                
                <!-- Watermark -->
                <div class="absolute -right-24 -bottom-24 opacity-[0.06] rotate-12 pointer-events-none">
                    <svg width="400" height="400" viewBox="0 0 100 100" fill="currentColor">
                        <path d="M35,0 h30 v35 h35 v30 h-35 v35 h-30 v-35 h-35 v-30 h35 z"/>
                    </svg>
                </div>

                <!-- Header / Logo Area -->
                <div class="p-6 lg:p-8 flex items-center gap-5 bg-black/10 backdrop-blur-sm border-b border-white/10">
                    <div class="bg-white p-3 rounded-2xl shadow-lg">
                        <img :src="siteSetting?.logo_url || '/logo.png'" alt="Logo" class="h-12 w-auto object-contain" @error="$event.target.style.display='none'" />
                    </div>
                    <div>
                        <h1 class="font-black text-2xl leading-tight">{{ siteSetting?.site_name || 'Palang Merah Indonesia' }}</h1>
                        <p class="text-rose-200 text-xs font-bold tracking-widest uppercase mt-1">Layar Antrian</p>
                    </div>
                </div>

                <!-- Active Calling Section -->
                <div class="flex-1 flex flex-col justify-center p-8 relative z-10">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center gap-3 bg-white/20 px-5 py-2 rounded-full backdrop-blur-md border border-white/30 shadow-inner">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                            </span>
                            <span class="text-sm font-black tracking-widest uppercase">Memanggil Antrian</span>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-[2rem] p-6 text-center shadow-2xl relative overflow-hidden transform transition-all duration-500" :class="{'scale-105 ring-8 ring-white/50': isPulsing}">
                        <!-- Decorative bg inside card -->
                        <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-white opacity-80 pointer-events-none"></div>
                        
                        <div class="relative z-10 flex flex-col justify-center h-full min-h-[200px]">
                            <div class="text-4xl xl:text-6xl font-black tracking-tight text-slate-800 leading-tight drop-shadow-sm mb-6 mt-4 uppercase px-4 break-words">
                                {{ activeCalling?.patient_name || 'NAMA PASIEN' }}
                            </div>
                            
                            <div class="bg-rose-600 text-white rounded-2xl py-4 px-4 flex items-center justify-center">
                                <span class="font-black text-xl xl:text-2xl uppercase tracking-wider text-center">
                                    {{ activeCalling?.counter?.name || 'NAMA LOKET' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clock Section -->
                <div class="p-6 bg-black/10 backdrop-blur-sm border-t border-white/10 mt-auto text-center flex flex-col items-center">
                    <div class="text-rose-200 font-bold text-sm tracking-widest uppercase mb-1">{{ currentDate }}</div>
                    <div class="text-5xl font-black tracking-tighter tabular-nums drop-shadow-md">{{ currentTime }}</div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR / MAIN CONTENT -->
            <div class="flex-1 p-6 lg:p-8 flex flex-col xl:flex-row gap-6 relative z-10 overflow-hidden">
                
                <!-- Video / Media Section -->
                <div class="flex-1 h-full rounded-[2rem] overflow-hidden shadow-2xl shadow-slate-300 ring-1 ring-slate-200 bg-slate-900 relative flex flex-col">
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
                    <!-- Fallback if no video -->
                    <div v-else class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 text-white p-12 text-center">
                        <div class="bg-white/5 p-10 rounded-full mb-8 backdrop-blur-md border border-white/10 shadow-2xl">
                            <svg width="120" height="120" viewBox="0 0 100 100" fill="currentColor" class="text-rose-500 opacity-90 drop-shadow-lg">
                                <path d="M35,0 h30 v35 h35 v30 h-35 v35 h-30 v-35 h-35 v-30 h35 z"/>
                            </svg>
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-black mb-4 tracking-tight drop-shadow-md text-white/90">Palang Merah Indonesia</h2>
                        <div class="w-16 h-1 bg-rose-500 rounded-full mb-6"></div>
                        <p class="text-xl text-slate-400 font-medium">Sistem Antrian & Pelayanan Terpadu</p>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="w-full xl:w-96 flex flex-col gap-3">
                    
                    <!-- Antrian Selanjutnya -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center justify-between">
                        <span class="font-black text-slate-800 tracking-wide text-sm">Antrian Selanjutnya</span>
                        <div class="w-6 h-6 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div v-for="(queue, i) in nextQueues" :key="'next-'+queue.id" class="bg-white rounded-xl shadow-[0_5px_15px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col overflow-hidden">
                            <div class="bg-slate-50 px-4 py-2 border-b border-slate-100 flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest line-clamp-1">{{ queue?.counter?.name || 'Nama Poli' }}</span>
                            </div>
                            <div class="px-4 py-2.5 flex items-center justify-between bg-white relative overflow-hidden">
                                <span class="text-slate-400 text-xs font-bold uppercase relative z-10 w-1/3">Nama</span>
                                <span class="text-rose-600 font-black text-lg md:text-xl relative z-10 text-right w-2/3 truncate" :title="queue?.patient_name">{{ queue?.patient_name || '---' }}</span>
                            </div>
                        </div>
                        <div v-if="nextQueues.length === 0" class="bg-white/40 backdrop-blur-sm rounded-xl border border-slate-100 flex flex-col overflow-hidden opacity-60">
                            <div class="px-4 py-4 text-center text-slate-400 text-xs font-bold uppercase">Belum ada</div>
                        </div>
                    </div>

                    <!-- Antrian Sebelumnya -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center justify-between mt-2">
                        <span class="font-black text-slate-800 tracking-wide text-sm">Antrian Sebelumnya</span>
                        <div class="w-6 h-6 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div v-for="(queue, i) in previousQueues" :key="'prev-'+queue.id" class="bg-white rounded-xl shadow-[0_5px_15px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col overflow-hidden">
                            <div class="bg-slate-50 px-4 py-2 border-b border-slate-100 flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest line-clamp-1">{{ queue?.counter?.name || 'Nama Poli' }}</span>
                            </div>
                            <div class="px-4 py-2.5 flex items-center justify-between bg-white relative overflow-hidden">
                                <span class="text-slate-400 text-xs font-bold uppercase relative z-10 w-1/3">Nama</span>
                                <span class="text-rose-600 font-black text-lg md:text-xl relative z-10 text-right w-2/3 truncate" :title="queue?.patient_name">{{ queue?.patient_name || '---' }}</span>
                            </div>
                        </div>
                        <div v-if="previousQueues.length === 0" class="bg-white/40 backdrop-blur-sm rounded-xl border border-slate-100 flex flex-col overflow-hidden opacity-60">
                            <div class="px-4 py-4 text-center text-slate-400 text-xs font-bold uppercase">Belum ada</div>
                        </div>
                    </div>
                </div>

            </div>
            
        </main>

        <!-- Footer Marquee -->
        <footer class="bg-rose-600 text-white py-3 overflow-hidden shadow-inner shrink-0 h-[5rem] flex items-center z-20 relative border-t border-rose-700">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="whitespace-nowrap animate-marquee flex items-center gap-16 relative z-10">
                <template v-for="n in 5" :key="n">
                    <span class="text-2xl lg:text-3xl font-black tracking-widest uppercase drop-shadow-sm">{{ runningText }}</span>
                    <span class="text-2xl lg:text-3xl font-black text-rose-300 tracking-widest">•</span>
                </template>
            </div>
            
            <!-- Fullscreen Toggle Button -->
            <button @click="toggleFullscreen" class="absolute right-4 top-1/2 -translate-y-1/2 p-3 text-white/50 hover:text-white hover:bg-white/20 rounded-xl transition-all z-20 backdrop-blur-md" title="Layar Penuh (Full Screen)">
                <svg v-if="!isFullscreen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" /></svg>
                <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 14h4v4m0-4l-5 5m15-5h-4v4m0-4l5 5M4 10h4V6m0 4L3 5m15 5h-4V6m0 4l5-5" /></svg>
            </button>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import * as googleTTS from 'google-tts-api';

const props = defineProps({
    settings: Object,
    siteSetting: Object,
});

const currentTime = ref('');
const currentDate = ref('');
const activeCalling = ref(null);
const nextQueues = ref([]);
const previousQueues = ref([]);
const displaySettings = ref(props.settings || {});
const isFullscreen = ref(false);
const isPulsing = ref(false);

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
        
        // Cek jika ada antrian baru yang dipanggil atau antrian yang sama dipanggil ulang (updated_at berubah)
        if (newCalling && (!activeCalling.value || activeCalling.value.id !== newCalling.id || activeCalling.value.status !== newCalling.status || activeCalling.value.updated_at !== newCalling.updated_at)) {
            activeCalling.value = newCalling;
            speakQueue(newCalling);
            
            // Trigger animation
            isPulsing.value = true;
            setTimeout(() => {
                isPulsing.value = false;
            }, 4000);
            
        } else if (!newCalling) {
            activeCalling.value = null;
        }

        nextQueues.value = response.data.next || [];
        previousQueues.value = response.data.previous || [];
        
        if (response.data.settings) {
            displaySettings.value = response.data.settings;
        }
    } catch (error) {
        console.error("Gagal mengambil data antrian", error);
    }
};

// Text-to-Speech Logic
const speakQueue = (queue) => {
    if (queue.status !== 'calling') return;

    const text = `Panggilan kepada pasien bernama, ${queue.patient_name || 'Pasien'}, Silakan menuju ke, ${queue.counter?.name}`;
    
    try {
        const url = googleTTS.getAudioUrl(text, {
            lang: 'id',
            slow: false,
            host: 'https://translate.google.com',
        });
        
        const audio = new Audio(url);
        audio.play().catch(e => console.error("Gagal memutar audio TTS:", e));
    } catch (err) {
        console.error("Gagal membuat URL TTS:", err);
    }
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
});
</script>

<style>
/* Custom Scrollbar Styles */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #cbd5e1; /* slate-300 */
    border-radius: 20px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #94a3b8; /* slate-400 */
}

/* Firefox support */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

@keyframes marquee {
  0% { transform: translateX(0%); }
  100% { transform: translateX(-33.33%); }
}
.animate-marquee {
  animation: marquee 20s linear infinite;
}
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 10s infinite alternate ease-in-out;
}
</style>
