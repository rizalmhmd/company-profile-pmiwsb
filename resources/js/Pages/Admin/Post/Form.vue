<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({ post: Object, categories: Array });
const isEdit = computed(() => !!props.post);
const previewUrl = ref(props.post?.image_url || null);

const form = useForm({
    title:        props.post?.title       ?? '',
    content:      props.post?.content     ?? '',
    category_id:  props.post?.category_id ?? '',
    is_published: props.post?.is_published ?? false,
    image: null,
});

const handleImage = (e) => {
    const f = e.target.files[0];
    if (f) { form.image = f; previewUrl.value = URL.createObjectURL(f); }
};

const submit = () => {
    const url = isEdit.value ? `/manage/posts/${props.post.id}` : '/manage/posts';
    form.post(url, { forceFormData: true });
};
</script>

<template>
    <AdminLayout :title="isEdit ? 'Edit Berita' : 'Tambah Berita'">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6">
                <a href="/manage/posts"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke daftar berita
                </a>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
                        <input v-model="form.title" type="text" placeholder="Judul berita..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                    </div>

                    <!-- Kategori & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                            <select v-model="form.category_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                            <p v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</p>
                        </div>
                        <div class="flex items-center gap-3 pt-6">
                            <button type="button" @click="form.is_published = !form.is_published"
                                :class="form.is_published ? 'bg-green-500' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 flex-shrink-0">
                                <span :class="form.is_published ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform duration-200"/>
                            </button>
                            <span class="text-sm font-semibold text-gray-700">
                                {{ form.is_published ? 'Dipublikasikan' : 'Simpan sebagai Draft' }}
                            </span>
                        </div>
                    </div>

                    <!-- Konten -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Berita <span class="text-red-500">*</span></label>
                        <textarea v-model="form.content" rows="12" placeholder="Tulis isi berita di sini..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-y"/>
                        <p v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</p>
                    </div>

                    <!-- Gambar Cover -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Cover</label>
                        <div v-if="previewUrl" class="mb-3 rounded-xl overflow-hidden h-48 bg-gray-100">
                            <img :src="previewUrl" class="w-full h-full object-cover"/>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer w-fit">
                            <div class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                {{ previewUrl ? 'Ganti Gambar' : 'Pilih Gambar' }}
                            </div>
                            <span class="text-xs text-gray-400">JPG, PNG, WebP maks. 4MB</span>
                            <input type="file" accept="image/*" class="hidden" @change="handleImage"/>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Berita') }}
                        </button>
                        <a href="/manage/posts"
                            class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
