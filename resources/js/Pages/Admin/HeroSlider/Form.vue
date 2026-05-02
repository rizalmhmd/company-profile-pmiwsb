<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({ slider: Object });

const isEdit = computed(() => !!props.slider);
const previewUrl = ref(props.slider?.image_url || null);

const form = useForm({
    image: null,
    title: props.slider?.title || '',
    subtitle: props.slider?.subtitle || '',
    description: props.slider?.description || '',
    order: props.slider?.order ?? 0,
    is_active: props.slider?.is_active ?? true,
    _method: isEdit.value ? 'POST' : undefined,
});

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    const url = isEdit.value
        ? `/manage/hero-sliders/${props.slider.id}`
        : '/manage/hero-sliders';

    form.post(url, { forceFormData: true });
};
</script>

<template>
    <AdminLayout :title="isEdit ? 'Edit Background' : 'Tambah Background'">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="/manage/hero-sliders"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke daftar background
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-6">

                    <!-- Image Upload with Preview -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Gambar Background <span class="text-red-500">{{ isEdit ? '' : '*' }}</span>
                        </label>

                        <!-- Preview -->
                        <div class="relative rounded-xl overflow-hidden bg-gray-100 mb-3" style="height: 220px;">
                            <img v-if="previewUrl" :src="previewUrl" class="w-full h-full object-cover"/>
                            <div v-else class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm">Preview gambar</p>
                            </div>
                            <!-- Overlay Teks Simulasi -->
                            <div v-if="previewUrl" class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-end p-6">
                                <div class="text-white">
                                    <span v-if="form.subtitle" class="inline-block bg-red-600 text-xs px-2 py-0.5 rounded mb-1">{{ form.subtitle }}</span>
                                    <p class="font-bold text-xl">{{ form.title || 'Judul akan muncul di sini' }}</p>
                                    <p class="text-sm text-gray-200 mt-1 line-clamp-2">{{ form.description }}</p>
                                </div>
                            </div>
                        </div>

                        <label class="flex items-center gap-3 cursor-pointer w-fit">
                            <div class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                {{ previewUrl ? 'Ganti Gambar' : 'Pilih Gambar' }}
                            </div>
                            <span class="text-xs text-gray-400">JPG, PNG, WebP maks. 4MB</span>
                            <input type="file" accept="image/*" class="hidden" @change="handleImageChange"/>
                        </label>
                        <p v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</p>
                    </div>

                    <!-- Text Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Teks Kecil (Subtitle/Badge)</label>
                            <input v-model="form.subtitle" type="text" placeholder="Misal: PMI WONOSOBO"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                            <p v-if="form.errors.subtitle" class="text-red-500 text-xs mt-1">{{ form.errors.subtitle }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Utama</label>
                            <input v-model="form.title" type="text" placeholder="Misal: Bersama Untuk Kemanusiaan"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                            <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea v-model="form.description" rows="3" placeholder="Deskripsi singkat yang muncul di bawah judul..."
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-none"/>
                            <p v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                            <input v-model="form.order" type="number" min="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div class="flex items-center gap-3 pt-6">
                            <button type="button" @click="form.is_active = !form.is_active"
                                :class="form.is_active ? 'bg-green-500' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200">
                                <span :class="form.is_active ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform duration-200"/>
                            </button>
                            <label class="text-sm font-semibold text-gray-700 cursor-pointer" @click="form.is_active = !form.is_active">
                                {{ form.is_active ? 'Aktif (tampil di beranda)' : 'Nonaktif (disembunyikan)' }}
                            </label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Background') }}
                        </button>
                        <a href="/manage/hero-sliders"
                            class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
