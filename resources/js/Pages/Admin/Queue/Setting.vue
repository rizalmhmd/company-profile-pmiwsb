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
        <div class="max-w-3xl space-y-6">
            <div class="flex items-center justify-between mb-6">
                <p class="text-gray-500 text-sm">Kelola tampilan URL video edukasi dan teks berjalan pada TV Antrian.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            URL Video (YouTube atau File MP4)
                        </label>
                        <input type="url" v-model="form.video_url" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition" 
                            placeholder="https://www.youtube.com/watch?v=..." />
                        <p class="mt-2 text-xs text-gray-500">Video Edukasi ini akan otomatis diputar di layar TV antrian. Sangat disarankan menggunakan link YouTube.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Teks Berjalan (Running Text)
                        </label>
                        <textarea v-model="form.running_text" rows="3" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition" 
                            placeholder="Selamat datang di..."></textarea>
                    </div>

                    <div class="flex items-center justify-end pt-2">
                        <button type="submit" :disabled="form.processing" 
                            class="bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition shadow-sm">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="text-sm text-gray-600 bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3 items-start">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-medium">TV Antrian dapat dilihat secara publik di URL:</p>
                    <a href="/antrian/display" target="_blank" class="text-blue-600 font-bold hover:underline break-all">/antrian/display</a>
                    <p class="mt-1 text-xs text-gray-500 italic">*Pastikan TV terhubung ke internet dan volume dihidupkan untuk mendengar suara panggilan otomatis.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

