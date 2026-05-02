<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({ services: Array });
</script>

<template>
    <AdminLayout title="Layanan">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Kelola layanan yang tersedia di website.</p>
            <Link href="/manage/services/create"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Layanan
            </Link>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">Gambar</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Deskripsi</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="svc in services" :key="svc.id" class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <img v-if="svc.image_url" :src="svc.image_url" class="w-12 h-12 rounded-xl object-cover"/>
                                <div v-else class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ svc.title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 max-w-xs hidden md:table-cell">
                                <p class="line-clamp-2">{{ svc.description }}</p>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="`/manage/services/${svc.id}/edit`"
                                        class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">Edit</Link>
                                    <Link :href="`/manage/services/${svc.id}`"
                                        method="delete" as="button" preserve-scroll
                                        class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"
                                        onclick="return confirm('Yakin hapus layanan ini?')">Hapus</Link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="services.length === 0">
                            <td colspan="4" class="px-4 py-12 text-center text-gray-400 text-sm">Belum ada layanan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
