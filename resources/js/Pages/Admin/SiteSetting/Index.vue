<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    setting: Object,
});

const form = useForm({
    site_name: props.setting.site_name || 'PMI Kabupaten Wonosobo',
    logo: null,
    favicon: null,
    _method: 'POST',
});

const logoPreview = ref(props.setting.logo_url);
const faviconPreview = ref(props.setting.favicon_url);

const onLogoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        logoPreview.value = URL.createObjectURL(file);
    }
};

const onFaviconChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.favicon = file;
        faviconPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post('/manage/site-setting', {
        preserveScroll: true,
        onSuccess: () => {
            // Success notification could go here
        },
    });
};
</script>

<template>
    <AdminLayout title="Pengaturan Situs">
        <div class="max-w-4xl">
            <div class="mb-8">
                <h2 class="text-2xl font-black text-gray-900">Branding Situs</h2>
                <p class="text-gray-500">Konfigurasi logo, favicon, dan identitas dasar website PMI.</p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Branding Card -->
                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Logo Upload -->
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Logo PMI (Header)</label>
                            <div class="relative group">
                                <div class="w-full h-48 bg-gray-50 rounded-[2.5rem] overflow-hidden border-2 border-dashed border-gray-200 flex items-center justify-center transition group-hover:border-red-300 relative">
                                    <img v-if="logoPreview" :src="logoPreview" class="max-w-[80%] max-h-[80%] object-contain">
                                    <div v-else class="text-center text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Pilih Logo</span>
                                    </div>
                                    <input type="file" @change="onLogoChange" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                                <div class="mt-2 text-[10px] text-gray-400 font-medium italic text-center">Rekomendasi: PNG Transparan, Max 2MB.</div>
                            </div>
                        </div>

                        <!-- Favicon Upload -->
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Favicon (Ikon Tab)</label>
                            <div class="relative group">
                                <div class="w-full h-48 bg-gray-50 rounded-[2.5rem] overflow-hidden border-2 border-dashed border-gray-200 flex items-center justify-center transition group-hover:border-red-300 relative">
                                    <div v-if="faviconPreview" class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
                                        <img :src="faviconPreview" class="w-16 h-16 object-contain">
                                    </div>
                                    <div v-else class="text-center text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Pilih Favicon</span>
                                    </div>
                                    <input type="file" @change="onFaviconChange" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                                <div class="mt-2 text-[10px] text-gray-400 font-medium italic text-center">Rekomendasi: ICO atau PNG 32x32, Max 1MB.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-12 border-t border-gray-50">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Nama Situs / Organisasi</label>
                        <input v-model="form.site_name" type="text" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-500 transition font-bold text-gray-700" placeholder="Contoh: PMI Kabupaten Wonosobo">
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-12 py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-red-700 transition shadow-xl shadow-red-200 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
