<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    site: Object,
    footer: Object,
});

const form = useForm({
    // Branding
    site_name: props.site.site_name || 'PMI Kabupaten Wonosobo',
    logo: null,
    favicon: null,
    // Footer & Contact
    about_pmi: props.footer?.about_pmi ?? '',
    address:   props.footer?.address   ?? '',
    phone:     props.footer?.phone     ?? '',
    email:     props.footer?.email     ?? '',
    facebook:  props.footer?.facebook  ?? '',
    instagram: props.footer?.instagram ?? '',
    copyright: props.footer?.copyright ?? '',
    _method: 'POST',
});

const logoPreview = ref(props.site.logo_url);
const faviconPreview = ref(props.site.favicon_url);

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
    });
};
</script>

<template>
    <AdminLayout title="Pengaturan Situs">
        <div class="max-w-6xl mx-auto pb-20">
            <div class="mb-8">
                <p class="text-gray-500">Kelola identitas visual, informasi kontak, dan footer website PMI.</p>
            </div>

            <form @submit.prevent="submit" class="space-y-12">
                <!-- Branding Section -->
                <section class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.828 2.828a2 2 0 010 2.828l-1.657 1.657M7 7.343l-1.657-1.657a2 2 0 00-2.828 0L2.515 8.515a2 2 0 000 2.828l1.657 1.657"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Identitas & Branding</h2>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <!-- Logo Upload -->
                            <div class="space-y-3">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Logo Header</label>
                                <div class="relative group h-40 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 flex items-center justify-center transition hover:border-red-300 relative overflow-hidden">
                                    <img v-if="logoPreview" :src="logoPreview" class="max-w-[70%] max-h-[70%] object-contain relative z-10">
                                    <div v-else class="text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Upload Logo</span>
                                    </div>
                                    <input type="file" @change="onLogoChange" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                </div>
                            </div>

                            <!-- Favicon Upload -->
                            <div class="space-y-3">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Favicon (Browser)</label>
                                <div class="relative group h-40 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 flex items-center justify-center transition hover:border-red-300 relative overflow-hidden">
                                    <div v-if="faviconPreview" class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center p-2 relative z-10">
                                        <img :src="faviconPreview" class="w-full h-full object-contain">
                                    </div>
                                    <div v-else class="text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Upload Favicon</span>
                                    </div>
                                    <input type="file" @change="onFaviconChange" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Nama Situs / Organisasi</label>
                            <input v-model="form.site_name" type="text" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-bold text-gray-700" placeholder="PMI Kabupaten Wonosobo">
                        </div>
                    </div>
                </section>

                <!-- Contact & Footer Section -->
                <section class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Kontak & Footer</h2>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Tentang PMI (Footer)</label>
                            <textarea v-model="form.about_pmi" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-medium text-gray-700 resize-none" placeholder="Deskripsi singkat..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Alamat Kantor</label>
                                <input v-model="form.address" type="text" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-bold text-gray-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Nomor Telepon</label>
                                <input v-model="form.phone" type="text" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-bold text-gray-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Email</label>
                                <input v-model="form.email" type="email" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-bold text-gray-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Teks Copyright</label>
                                <input v-model="form.copyright" type="text" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-bold text-gray-700">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">URL Facebook</label>
                                <input v-model="form.facebook" type="url" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-medium text-gray-700" placeholder="https://...">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">URL Instagram</label>
                                <input v-model="form.instagram" type="url" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition font-medium text-gray-700" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Actions -->
                <div class="sticky bottom-8 bg-white/80 backdrop-blur-xl border border-gray-100 p-4 rounded-3xl shadow-2xl flex items-center justify-between">
                    <p class="text-xs text-gray-400 font-medium px-4">Pastikan data sudah benar sebelum menyimpan.</p>
                    <button type="submit" :disabled="form.processing"
                        class="px-10 py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-red-700 transition shadow-xl shadow-red-200 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Semua Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
