<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    bloodDonorCount: Number,
    bloodStockTotal: Number,
    categoryCount: Number,
    serviceCount: Number,
});
</script>

<template>
    <AdminLayout title="Dashboard Perawat" role="perawat">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl p-8 mb-8 shadow-lg">
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ $page.props.auth.user.name }}!</h2>
            <p class="text-blue-100">Portal pengelolaan data kesehatan dan donor darah</p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Donor</p>
                        <p class="text-3xl font-bold text-gray-900">{{ bloodDonorCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11z M3.5 13c-1.1 0-2 .9-2 2v6h3v-6c0-1.1-.9-2-2-2zm17 0c-1.1 0-2 .9-2 2v6h3v-6c0-1.1-.9-2-2-2zm-8.5.5c-1.1 0-2 .9-2 2v6h4v-6c0-1.1-.9-2-2-2z"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Stok Darah</p>
                        <p class="text-3xl font-bold text-gray-900">{{ bloodStockTotal }}</p>
                    </div>
                    <svg class="w-12 h-12 text-red-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M19.5 3H4.5C3.12 3 2 4.12 2 5.5v13C2 19.88 3.12 21 4.5 21h15c1.38 0 2.5-1.12 2.5-2.5v-13C22 4.12 20.88 3 19.5 3zm-5 9h-3v3h-2v-3h-3v-2h3V7h2v3h3v2z"/></svg>
                </div>
            </div>

        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Tasks & Functions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-6 border-b pb-4">Fungsi Utama</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <Link href="/manage/blood-donors" class="p-4 border-2 border-gray-100 rounded-xl hover:border-blue-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7 10.5h10M3 19c0-2 2-4 9-4s9 2 9 4"/></svg>
                            <p class="text-sm font-semibold">Data Donor</p>
                        </Link>
                        <Link href="/manage/blood-stocks" class="p-4 border-2 border-gray-100 rounded-xl hover:border-red-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                            <p class="text-sm font-semibold">Stok Darah</p>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold mb-6 border-b pb-4">Informasi</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
                        <p class="text-sm font-semibold text-blue-900">Tanggung Jawab</p>
                        <p class="text-xs text-blue-700 mt-1">Kelola data kesehatan donor dan stok darah</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-600">
                        <p class="text-sm font-semibold text-green-900">Status Sistem</p>
                        <p class="text-xs text-green-700 mt-1">✓ Semua layanan berjalan normal</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-600">
                        <p class="text-sm font-semibold text-yellow-900">Tips</p>
                        <p class="text-xs text-yellow-700 mt-1">Periksa stok darah secara berkala</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
