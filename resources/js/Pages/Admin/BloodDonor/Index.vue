<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({ donors: [Array, Object] });
const items = Array.isArray(props.donors) ? props.donors : (props.donors?.data ?? []);

const formatDate = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';
</script>

<template>
    <AdminLayout title="Data Donor Darah">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Kelola jadwal kegiatan donor darah.</p>
            <Link href="/manage/blood-donors/create"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal
            </Link>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ item.name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ item.location }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ formatDate(item.date) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ item.time_start?.substring(0,5) }} - {{ item.time_end?.substring(0,5) }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="`/manage/blood-donors/${item.id}/edit`"
                                        class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">Edit</Link>
                                    <Link :href="`/manage/blood-donors/${item.id}`"
                                        method="delete" as="button" preserve-scroll
                                        class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"
                                        onclick="return confirm('Yakin hapus data ini?')">Hapus</Link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="items.length === 0">
                            <td colspan="5" class="px-4 py-12 text-center text-gray-400 text-sm">Belum ada data donor.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
