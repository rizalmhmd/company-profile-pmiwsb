<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ stock: Object });
const isEdit = computed(() => !!props.stock);

const form = useForm({
    product: props.stock?.product ?? '',
    stock_a:  props.stock?.stock_a  ?? 0,
    stock_b:  props.stock?.stock_b  ?? 0,
    stock_o:  props.stock?.stock_o  ?? 0,
    stock_ab: props.stock?.stock_ab ?? 0,
});

const submit = () => {
    if (isEdit.value) {
        form.put(`/manage/blood-stocks/${props.stock.id}`);
    } else {
        form.post('/manage/blood-stocks');
    }
};
</script>

<template>
    <AdminLayout :title="isEdit ? 'Edit Stok Darah' : 'Tambah Stok Darah'">
        <div class="max-w-xl mx-auto">
            <div class="mb-6">
                <a href="/manage/blood-stocks"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke daftar stok
                </a>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                        <input v-model="form.product" type="text" placeholder="Misal: Whole Blood (WB)"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p v-if="form.errors.product" class="text-red-500 text-xs mt-1">{{ form.errors.product }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok Golongan A</label>
                            <input v-model="form.stock_a" type="number" min="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok Golongan B</label>
                            <input v-model="form.stock_b" type="number" min="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok Golongan O</label>
                            <input v-model="form.stock_o" type="number" min="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok Golongan AB</label>
                            <input v-model="form.stock_ab" type="number" min="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Stok') }}
                        </button>
                        <a href="/manage/blood-stocks"
                            class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
