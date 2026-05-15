<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ menu: Object, parents: Array });
const isEdit = computed(() => !!props.menu);

const form = useForm({
    name: props.menu?.name || '',
    url: props.menu?.url || '',
    parent_id: props.menu?.parent_id || '',
    order: props.menu?.order || 0,
    is_active: props.menu?.is_active ?? true,
});

const submit = () => {
    if (isEdit.value) {
        form.put(`/manage/menus/${props.menu.id}`);
    } else {
        form.post('/manage/menus');
    }
};
</script>

<template>
    <AdminLayout :title="isEdit ? 'Edit Menu' : 'Tambah Menu'">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <Link href="/manage/menus" class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Menu
                </Link>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Menu <span class="text-red-500">*</span></label>
                        <input v-model="form.name" type="text" placeholder="Contoh: PROFIL"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL / Link</label>
                        <input v-model="form.url" type="text" placeholder="Contoh: /profil/visi-misi atau # jika dropdown"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p class="text-[10px] text-gray-400 mt-1 italic">Kosongkan atau isi # jika ini adalah induk menu dropdown.</p>
                        <p v-if="form.errors.url" class="text-red-500 text-xs mt-1">{{ form.errors.url }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Induk Menu (Parent)</label>
                            <select v-model="form.parent_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition bg-white">
                                <option value="">-- Menu Utama --</option>
                                <option v-for="parent in parents" :key="parent.id" :value="parent.id">{{ parent.name }}</option>
                            </select>
                            <p v-if="form.errors.parent_id" class="text-red-500 text-xs mt-1">{{ form.errors.parent_id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan (Order)</label>
                            <input v-model="form.order" type="number"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                            <p v-if="form.errors.order" class="text-red-500 text-xs mt-1">{{ form.errors.order }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" @click="form.is_active = !form.is_active"
                            :class="form.is_active ? 'bg-green-500' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                            <span :class="form.is_active ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform"/>
                        </button>
                        <label class="text-sm font-semibold text-gray-700">{{ form.is_active ? 'Menu Aktif' : 'Menu Nonaktif' }}</label>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Menu') }}
                        </button>
                        <Link href="/manage/menus" class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
