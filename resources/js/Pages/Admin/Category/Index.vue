<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ categories: Array });

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
    name: '',
});

const openCreateModal = () => {
    isEditing.value = false;
    editingId.ref = null;
    form.reset();
    form.clearErrors();
    isModalOpen.value = true;
};

const openEditModal = (category) => {
    isEditing.value = true;
    editingId.value = category.id;
    form.name = category.name;
    form.clearErrors();
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const submit = () => {
    if (isEditing.value) {
        form.put(`/manage/categories/${editingId.value}`, {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post('/manage/categories', {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteCategory = (id) => {
    if (confirm('Yakin ingin menghapus kategori ini?')) {
        router.delete(`/manage/categories/${id}`);
    }
};
</script>

<template>
    <AdminLayout title="Kategori Berita">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Kelola kategori untuk pengelompokan berita.</p>
            <button @click="openCreateModal"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="cat in categories" :key="cat.id" class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ cat.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ cat.slug }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openEditModal(cat)"
                                    class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">Edit</button>
                                <button @click="deleteCategory(cat.id)"
                                    class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="categories.length === 0">
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada kategori.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">{{ isEditing ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="submit" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori</label>
                        <input v-model="form.name" type="text" placeholder="Misal: Berita Utama" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" :disabled="form.processing"
                            class="flex-1 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                        </button>
                        <button type="button" @click="closeModal"
                            class="flex-1 px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
