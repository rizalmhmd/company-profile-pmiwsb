<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    setting: Object,
});

const form = useForm({
    video_url: props.setting?.video_url || '',
    running_text: props.setting?.running_text || '',
});

const submit = () => {
    form.post('/manage/queue-settings', {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout title="Pengaturan Layar Antrian">
        <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-slate-600 text-base font-medium">Kelola tampilan URL video edukasi dan teks berjalan pada TV Antrian.</p>
            </div>

            <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-slate-100 p-6 sm:p-10 mb-8 transition-all hover:shadow-[0_10px_40px_rgba(0,0,0,0.08)]">
                <form @submit.prevent="submit" class="space-y-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">
                            URL Video (YouTube atau File MP4)
                        </label>
                        <input type="url" v-model="form.video_url" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-rose-500/20 focus:border-rose-400 focus:bg-white transition-all" 
                            placeholder="https://www.youtube.com/watch?v=..." />
                        <p class="mt-2.5 text-xs text-slate-500 font-medium">Video Edukasi ini akan otomatis diputar di layar TV antrian. Sangat disarankan menggunakan link YouTube.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">
                            Teks Berjalan (Running Text)
                        </label>
                        <textarea v-model="form.running_text" rows="4" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-rose-500/20 focus:border-rose-400 focus:bg-white transition-all resize-none" 
                            placeholder="Selamat datang di..."></textarea>
                    </div>

                    <div class="flex items-center justify-end pt-4">
                        <button type="submit" :disabled="form.processing" 
                            class="bg-rose-600 hover:bg-rose-700 focus:ring-4 focus:ring-rose-500/30 disabled:opacity-60 text-white px-8 py-3.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-rose-600/30">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-blue-50/80 border border-blue-100/80 rounded-[1.5rem] p-6 sm:p-8 flex flex-col sm:flex-row gap-5 items-start sm:items-center shadow-sm">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-base">TV Antrian dapat dilihat secara publik di URL:</p>
                    <a href="/antrian/display" target="_blank" class="text-blue-600 font-bold hover:text-blue-700 hover:underline break-all mt-1 inline-block text-lg">/antrian/display</a>
                    <p class="mt-2 text-sm text-slate-500 font-medium italic">*Pastikan TV terhubung ke internet dan volume dihidupkan untuk mendengar suara panggilan otomatis.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

