<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({ service: Object });
const isEdit = computed(() => !!props.service);
const previewUrl = ref(props.service?.image_url || null);

const form = useForm({
    title:       props.service?.title       ?? '',
    description: props.service?.description ?? '',
    icon:        props.service?.icon        ?? '',
    image: null,
});

const handleImage = (e) => {
    const f = e.target.files[0];
    if (f) { form.image = f; previewUrl.value = URL.createObjectURL(f); }
};

const submit = () => {
    const url = isEdit.value ? `/manage/services/${props.service.id}` : '/manage/services';
    form.post(url, { forceFormData: true });
};
</script>

<template>
    <AdminLayout :title="isEdit ? 'Edit Layanan' : 'Tambah Layanan'">
        <div class="max-w-xl mx-auto">
            <div class="mb-6">
                <a href="/manage/services"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke daftar layanan
                </a>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Layanan <span class="text-red-500">*</span></label>
                        <input v-model="form.title" type="text"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea v-model="form.description" rows="4"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-none"/>
                        <p v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Icon (opsional)</label>
                        <input v-model="form.icon" type="text" placeholder="Misal: heart, drop, plus"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar</label>
                        <div v-if="previewUrl" class="mb-3 rounded-xl overflow-hidden h-40 bg-gray-100">
                            <img :src="previewUrl" class="w-full h-full object-cover"/>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer w-fit">
                            <div class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                {{ previewUrl ? 'Ganti Gambar' : 'Pilih Gambar' }}
                            </div>
                            <input type="file" accept="image/*" class="hidden" @change="handleImage"/>
                        </label>
                    </div>
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Layanan') }}
                        </button>
                        <a href="/manage/services"
                            class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
