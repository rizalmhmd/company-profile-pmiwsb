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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Kategori Darah</p>
                        <p class="text-3xl font-bold text-gray-900">{{ categoryCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Layanan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ serviceCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.7-2.34-1.54 0-.54.46-1.07 1.87-1.07 1.31 0 2.09.52 2.09 1.48h1.35c0-1.59-1.02-2.87-3.46-2.87-2.13 0-3.59 1.04-3.59 2.35 0 1.15.67 1.95 2.65 2.43 1.8.41 2.34.65 2.34 1.6 0 .56-.47 1.12-1.97 1.12-1.54 0-2.37-.62-2.37-1.65h-1.35c0 1.65 1.07 2.87 3.72 2.87 2.4 0 3.68-.87 3.68-2.4 0-1.59-1.02-1.95-2.65-2.45z"/></svg>
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
                        <a href="/admin/blood-donors" class="p-4 border-2 border-gray-200 rounded-xl hover:border-blue-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7 10.5h10M3 19c0-2 2-4 9-4s9 2 9 4"/></svg>
                            <p class="text-sm font-semibold">Data Donor</p>
                        </a>
                        <a href="/admin/blood-stocks" class="p-4 border-2 border-gray-200 rounded-xl hover:border-red-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                            <p class="text-sm font-semibold">Stok Darah</p>
                        </a>
                        <a href="/admin/categories" class="p-4 border-2 border-gray-200 rounded-xl hover:border-green-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <p class="text-sm font-semibold">Kategori</p>
                        </a>
                        <a href="/admin/services" class="p-4 border-2 border-gray-200 rounded-xl hover:border-purple-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm font-semibold">Layanan</p>
                        </a>
                        <a href="/admin/posts" class="p-4 border-2 border-gray-200 rounded-xl hover:border-indigo-600 hover:shadow-lg transition text-center block">
                            <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm font-semibold">Berita</p>
                        </a>
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
