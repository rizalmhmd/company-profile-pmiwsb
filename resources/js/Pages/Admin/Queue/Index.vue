<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, reactive, watch } from 'vue';

const props = defineProps({
    counters: Array,
    queues: Object,
    dashboard_stats: Object,
    filters: Object,
});

const filterForm = reactive({
    search: props.filters?.search || '',
    counter_id: props.filters?.counter_id || '',
    status: props.filters?.status || '',
});

let filterTimeout = null;
watch(filterForm, (newValues) => {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(() => {
        router.get('/manage/queues', newValues, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 300);
});

const callNextGlobal = () => {
    router.post('/manage/queues/call-next-global', {}, {
        preserveScroll: true,
    });
};

const finishAndCallNextGlobal = () => {
    router.post('/manage/queues/finish-call-next-global', {}, {
        preserveScroll: true,
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

const clearAll = () => {
    if (confirm('Apakah Anda yakin ingin menghapus SEMUA riwayat antrian?')) {
        router.delete('/manage/queues/clear', {
            preserveScroll: true,
            onSuccess: () => { selectedQueues.value = []; }
        });
    }
};

const exportToSheets = () => {
    router.post('/manage/queues/export-sheets', {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Flash messages are usually handled globally, but we can also use alert or toast here if desired.
        }
    });
};

const deleteQueue = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus antrian ini?')) {
        router.delete(`/manage/queues/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                selectedQueues.value = selectedQueues.value.filter(qId => qId !== id);
            }
        });
    }
};

const selectedQueues = ref([]);

const selectAll = (e) => {
    if (e.target.checked) {
        selectedQueues.value = props.queues.data.map(q => q.id);
    } else {
        selectedQueues.value = [];
    }
};

const deleteSelected = () => {
    if (selectedQueues.value.length === 0) return;
    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedQueues.value.length} antrian terpilih?`)) {
        router.post('/manage/queues/bulk-delete', { ids: selectedQueues.value }, {
            preserveScroll: true,
            onSuccess: () => {
                selectedQueues.value = [];
            }
        });
    }
};

// Import Form
const importForm = useForm({
    file: null,
});

const handleImport = () => {
    if (!importForm.file) {
        alert('Pilih file excel terlebih dahulu');
        return;
    }
    importForm.post('/manage/queues/import', {
        preserveScroll: true,
        onSuccess: () => {
            importForm.reset('file');
            const fileInput = document.getElementById('excel-file');
            if (fileInput) fileInput.value = '';
            alert('Berhasil import data antrian!');
        },
    });
};

// Manual Add Form
const showManualModal = ref(false);
const manualForm = useForm({
    patient_name: '',
    counter_id: '',
});

const handleManualAdd = () => {
    manualForm.post('/manage/queues/manual-add', {
        preserveScroll: true,
        onSuccess: () => {
            manualForm.reset();
            showManualModal.value = false;
        },
    });
};

// Edit Form
const showEditModal = ref(false);
const editForm = useForm({
    id: null,
    patient_name: '',
    counter_id: '',
});

const openEditModal = (queue) => {
    editForm.id = queue.id;
    editForm.patient_name = queue.patient_name;
    editForm.counter_id = queue.counter_id;
    showEditModal.value = true;
};

const handleEditSubmit = () => {
    editForm.put(`/manage/queues/${editForm.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
        }
    });
};
</script>

<template>
    <AdminLayout title="Manajemen Antrian">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <p class="text-gray-500 text-sm">Kelola pemanggilan nomor antrian terpusat berdasarkan urutan kehadiran (file Excel).</p>
            
            <div class="flex items-center gap-3 flex-wrap">
                <button @click="exportToSheets" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Kirim ke Sheets
                </button>
                <a href="/manage/queues/export" class="bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Excel
                </a>
                <button @click="showManualModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Manual
                </button>
            </div>
        </div>

        <!-- Master Control Panel -->
        <div v-if="dashboard_stats" class="bg-gradient-to-br from-rose-600 to-rose-800 rounded-3xl shadow-xl overflow-hidden mb-8 text-white relative">
            <div class="absolute inset-0 bg-black opacity-10 pointer-events-none mix-blend-overlay"></div>
            <div class="absolute -right-20 -top-20 opacity-[0.05] rotate-12 pointer-events-none">
                <svg width="400" height="400" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M35,0 h30 v35 h35 v30 h-35 v35 h-30 v-35 h-35 v-30 h35 z"/>
                </svg>
            </div>

            <div class="p-6 md:p-10 relative z-10 flex flex-col lg:flex-row items-center gap-10">
                <!-- Sedang Dipanggil -->
                <div class="flex-1 w-full text-center lg:text-left">
                    <p class="text-rose-200 font-bold tracking-widest uppercase text-sm mb-2">Sedang Dipanggil</p>
                    <div v-if="dashboard_stats.global_calling" class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <h2 class="text-3xl md:text-5xl font-black text-white leading-tight mb-3 truncate" :title="dashboard_stats.global_calling.patient_name">{{ dashboard_stats.global_calling.patient_name || 'Tidak ada' }}</h2>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-block bg-white text-rose-700 px-4 py-1.5 rounded-full text-sm font-black uppercase tracking-wider">{{ dashboard_stats.global_calling.counter?.name || '-' }}</span>
                            <button @click="callQueue(dashboard_stats.global_calling.id)" class="inline-flex items-center gap-1.5 bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition border border-white/30" title="Panggil Ulang Pasien">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                Panggil
                            </button>
                            <button @click="finishAndCallNextGlobal" class="inline-flex items-center gap-1.5 bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition border border-white/30" title="Tandai Selesai (Hadir)">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Selesai
                            </button>
                        </div>
                    </div>
                    <div v-else class="bg-black/20 rounded-2xl p-6 border border-white/10 border-dashed text-center">
                        <p class="text-white/60 font-semibold">Belum ada pasien yang dipanggil.</p>
                    </div>
                </div>

                <!-- Antrian Selanjutnya & Tombol Panggil -->
                <div class="flex-1 w-full flex flex-col items-center lg:items-end gap-6">
                    <div class="text-center lg:text-right w-full lg:max-w-md">
                        <p class="text-rose-200 font-bold tracking-widest uppercase text-xs mb-2">Antrian Selanjutnya (Up Next)</p>
                        <div class="bg-black/20 rounded-xl px-5 py-3 border border-white/10 flex items-center justify-between mb-6">
                            <span class="font-bold text-white truncate max-w-[60%]" :title="dashboard_stats.global_next?.patient_name">{{ dashboard_stats.global_next?.patient_name || 'Kosong' }}</span>
                            <span class="text-xs font-bold text-rose-300 uppercase truncate max-w-[35%] text-right">{{ dashboard_stats.global_next?.counter?.name || '-' }}</span>
                        </div>
                        
                        <button 
                            @click="callNextGlobal"
                            :disabled="!dashboard_stats.global_next && !dashboard_stats.global_calling"
                            class="w-full bg-white text-rose-700 hover:bg-gray-50 disabled:bg-white/50 disabled:text-rose-700/50 disabled:cursor-not-allowed py-4 rounded-2xl font-black text-lg transition shadow-lg flex items-center justify-center gap-3">
                            <svg v-if="dashboard_stats.global_next" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                            {{ (!dashboard_stats.global_next && dashboard_stats.global_calling) ? 'LEWATI (SKIP)' : 'PANGGIL BERIKUTNYA' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Progress Bar Bar -->
            <div class="bg-black/30 px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4 relative z-10 text-sm border-t border-white/10">
                <div class="flex-1 w-full max-w-lg">
                    <div class="flex justify-between text-rose-100 font-semibold mb-1.5">
                        <span>Progress Hari Ini</span>
                        <span>{{ dashboard_stats.progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2 overflow-hidden">
                        <div class="bg-green-400 h-2 rounded-full transition-all duration-500 ease-out" :style="{ width: dashboard_stats.progress_percentage + '%' }"></div>
                    </div>
                </div>
                <div class="font-bold text-white whitespace-nowrap bg-white/10 px-4 py-2 rounded-xl">
                    Selesai {{ dashboard_stats.finished }} dari {{ dashboard_stats.total }} Pasien
                </div>
            </div>
        </div>

        <!-- Import File Excel -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-8">
            <h3 class="font-bold text-gray-800 mb-3">Import Data Antrian dari Excel</h3>
            <form @submit.prevent="handleImport" class="flex flex-col md:flex-row md:items-center gap-4">
                <input type="file" id="excel-file" accept=".xlsx,.xls,.csv" @input="importForm.file = $event.target.files[0]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer border border-gray-200 rounded-xl" />
                <button type="submit" :disabled="importForm.processing" class="bg-rose-600 hover:bg-rose-700 disabled:bg-rose-400 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap">
                    {{ importForm.processing ? 'Mengimpor...' : 'Import File' }}
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2">Format Excel harus memiliki baris pertama sebagai header dengan nama kolom: <b>nama</b> dan <b>poli</b> (Pastikan nama poli sama persis dengan yang ada di sistem, misal: "Poli Umum").</p>
        </div>

        <!-- Daftar Semua Antrian Hari Ini -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-gray-800">Riwayat Antrian Hari Ini</h2>
            
            <div class="flex gap-2">
                <button v-if="selectedQueues.length > 0" @click="deleteSelected" class="bg-rose-600 text-white hover:bg-rose-700 px-3 py-1.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus Terpilih ({{ selectedQueues.length }})
                </button>
                <button @click="clearAll" class="bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus Semua
                </button>
            </div>
        </div>

        <!-- Filter Data -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-4 flex flex-col md:flex-row gap-4 items-center">
            <div class="flex-1 w-full">
                <input type="text" v-model="filterForm.search" placeholder="Cari Nama Pasien atau Nomor Antrian..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-2.5" />
            </div>
            <div class="w-full md:w-48">
                <select v-model="filterForm.counter_id" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-2.5">
                    <option value="">Semua Loket</option>
                    <option v-for="counter in counters" :key="counter.id" :value="counter.id">{{ counter.name }}</option>
                </select>
            </div>
            <div class="w-full md:w-48">
                <select v-model="filterForm.status" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-2.5">
                    <option value="">Semua Status</option>
                    <option value="waiting">Menunggu</option>
                    <option value="calling">Dipanggil</option>
                    <option value="finished">Selesai (Hadir)</option>
                    <option value="skipped">Terlewat (Skip)</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left w-12">
                                <input type="checkbox" @change="selectAll" :checked="selectedQueues.length === queues.data.length && queues.data.length > 0" class="rounded border-gray-300 text-rose-600 shadow-sm focus:ring-rose-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Loket</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi Manual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="queue in queues.data" :key="queue.id" class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 text-left whitespace-nowrap w-12">
                                <input type="checkbox" v-model="selectedQueues" :value="queue.id" class="rounded border-gray-300 text-rose-600 shadow-sm focus:ring-rose-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ new Date(queue.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ queue.patient_name || '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                {{ queue.counter?.name }}
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
                                    <button @click="openEditModal(queue)" class="px-3 py-1.5 text-xs font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition" title="Edit Data">
                                        Edit
                                    </button>
                                    <button v-if="queue.status !== 'finished'" @click="callQueue(queue.id)" class="px-3 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition" title="Panggil Langsung">
                                        Panggil
                                    </button>
                                    <button v-if="queue.status === 'finished' && queue.is_skipped" @click="callQueue(queue.id)" class="px-3 py-1.5 text-xs font-semibold text-teal-600 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Panggil Kembali Pasien Ini">
                                        Panggil Ulang
                                    </button>
                                    <button v-if="queue.status === 'calling'" @click="finishQueue(queue.id)" class="px-3 py-1.5 text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition" title="Selesai">
                                        Selesai
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="queues.data.length === 0">
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-sm">
                                Belum ada antrian hari ini.
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

        <!-- Modal Tambah Manual -->
        <div v-if="showManualModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop with blur -->
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="showManualModal = false"></div>
            
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                        <!-- Decorative top gradient -->
                        <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-rose-500 to-rose-700"></div>
                        
                        <form @submit.prevent="handleManualAdd">
                            <div class="bg-white px-6 pb-6 pt-8 sm:px-8">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="bg-rose-100 text-rose-600 p-3 rounded-2xl">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-black text-gray-900 tracking-tight" id="modal-title">Tambah Pasien Manual</h3>
                                </div>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Pasien</label>
                                        <input type="text" v-model="manualForm.patient_name" required 
                                            class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 shadow-sm transition focus:bg-white focus:border-rose-500 focus:ring-rose-500 placeholder:text-gray-400" 
                                            placeholder="Masukkan nama lengkap pasien...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Poli Tujuan</label>
                                        <div class="relative">
                                            <select v-model="manualForm.counter_id" required 
                                                class="w-full appearance-none rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 shadow-sm transition focus:bg-white focus:border-rose-500 focus:ring-rose-500">
                                                <option value="" disabled>-- Pilih Poli / Loket Tujuan --</option>
                                                <option v-for="counter in counters" :key="counter.id" :value="counter.id">{{ counter.name }}</option>
                                            </select>
                                            <!-- Custom Chevron -->
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50/80 backdrop-blur-md px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-100 gap-3">
                                <button type="submit" :disabled="manualForm.processing" class="inline-flex w-full sm:w-auto justify-center rounded-2xl bg-rose-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-rose-600/30 hover:bg-rose-700 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:shadow-none items-center gap-2">
                                    <svg v-if="manualForm.processing" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>{{ manualForm.processing ? 'Menyimpan...' : 'Simpan Antrian' }}</span>
                                </button>
                                <button type="button" @click="showManualModal = false" class="mt-3 inline-flex w-full sm:w-auto sm:mt-0 justify-center rounded-2xl bg-white px-6 py-3 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-200 hover:bg-gray-50 transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Antrian -->
        <div v-if="showEditModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop with blur -->
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="showEditModal = false"></div>
            
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                        <!-- Decorative top gradient -->
                        <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-amber-500 to-orange-500"></div>
                        
                        <form @submit.prevent="handleEditSubmit">
                            <div class="bg-white px-6 pb-6 pt-8 sm:px-8">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="bg-amber-100 text-amber-600 p-3 rounded-2xl">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-black text-gray-900 tracking-tight" id="modal-title">Edit Data Pasien</h3>
                                </div>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Pasien</label>
                                        <input type="text" v-model="editForm.patient_name" required 
                                            class="w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 shadow-sm transition focus:bg-white focus:border-amber-500 focus:ring-amber-500 placeholder:text-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Poli Tujuan</label>
                                        <div class="relative">
                                            <select v-model="editForm.counter_id" required 
                                                class="w-full appearance-none rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 shadow-sm transition focus:bg-white focus:border-amber-500 focus:ring-amber-500">
                                                <option value="" disabled>-- Pilih Poli / Loket Tujuan --</option>
                                                <option v-for="counter in counters" :key="counter.id" :value="counter.id">{{ counter.name }}</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50/80 backdrop-blur-md px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-100 gap-3">
                                <button type="submit" :disabled="editForm.processing" class="inline-flex w-full sm:w-auto justify-center rounded-2xl bg-amber-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-amber-500/30 hover:bg-amber-600 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:shadow-none items-center gap-2">
                                    <svg v-if="editForm.processing" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>{{ editForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
                                </button>
                                <button type="button" @click="showEditModal = false" class="mt-3 inline-flex w-full sm:w-auto sm:mt-0 justify-center rounded-2xl bg-white px-6 py-3 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-200 hover:bg-gray-50 transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
