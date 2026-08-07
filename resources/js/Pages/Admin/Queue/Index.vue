<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    counters: Array,
    queues: Object,
});

const form = useForm({
    counter_id: '',
    queue_number: '',
    patient_name: '',
});

const submit = () => {
    form.post('/manage/queues', {
        preserveScroll: true,
        onSuccess: () => form.reset('queue_number', 'patient_name'),
    });
};

const callQueue = (id) => {
    router.post(`/manage/queues/${id}/call`, {}, {
        preserveScroll: true,
    });
};

const finishQueue = (id) => {
    router.post(`/manage/queues/${id}/finish`, {}, {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout title="Manajemen Antrian">
        
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Kelola pemanggilan nomor antrian untuk loket atau poli.</p>
        </div>

        <!-- Form Tambah Antrian -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Antrian Baru</h2>
            <form @submit.prevent="submit" class="flex flex-col md:flex-row items-end gap-4">
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Loket / Poli</label>
                    <select v-model="form.counter_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition bg-white" required>
                        <option value="">Pilih Loket</option>
                        <option v-for="counter in counters" :key="counter.id" :value="counter.id">
                            {{ counter.name }}
                        </option>
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Antrian</label>
                    <input type="text" v-model="form.queue_number" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition" required placeholder="Contoh: A-01">
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Pasien (Opsional)</label>
                    <input type="text" v-model="form.patient_name" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition" placeholder="Nama Pasien">
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit" :disabled="form.processing" class="w-full md:w-auto bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm whitespace-nowrap flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Antrian -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Antrian</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Loket</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="queue in queues.data" :key="queue.id" class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-lg font-bold text-gray-900">{{ queue.queue_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                {{ queue.counter?.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ queue.patient_name || '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-bold uppercase rounded-full"
                                      :class="{
                                        'bg-yellow-100 text-yellow-700': queue.status === 'waiting',
                                        'bg-blue-100 text-blue-700': queue.status === 'calling',
                                        'bg-green-100 text-green-700': queue.status === 'finished'
                                      }">
                                    {{ queue.status === 'waiting' ? 'Menunggu' : queue.status === 'calling' ? 'Dipanggil' : 'Selesai' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <button v-if="queue.status !== 'finished'" @click="callQueue(queue.id)" class="px-3 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                        Panggil
                                    </button>
                                    <button v-if="queue.status === 'calling'" @click="finishQueue(queue.id)" class="px-3 py-1.5 text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition">
                                        Selesai
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="queues.data.length === 0">
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 text-sm">
                                Belum ada data antrian hari ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="flex justify-end items-center text-sm">
            <a href="/antrian/display" target="_blank" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">
                Lihat Layar TV Antrian
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

    </AdminLayout>
</template>

