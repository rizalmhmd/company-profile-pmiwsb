<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    userCount: Number,
    perawatCount: Number,
    bloodStockTotal: Number,
    postCount: Number,
});
</script>

<template>
    <AdminLayout title="Dashboard Admin" role="admin">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl p-8 mb-8 shadow-lg">
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ $page.props.auth.user.name }}!</h2>
            <p class="text-red-100">Dashboard manajemen PMI Wonosobo</p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-900">{{ userCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-red-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Perawat</p>
                        <p class="text-3xl font-bold text-gray-900">{{ perawatCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11z M3.5 13c-1.1 0-2 .9-2 2v6h3v-6c0-1.1-.9-2-2-2zm17 0c-1.1 0-2 .9-2 2v6h3v-6c0-1.1-.9-2-2-2zm-8.5.5c-1.1 0-2 .9-2 2v6h4v-6c0-1.1-.9-2-2-2z"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Stok Darah</p>
                        <p class="text-3xl font-bold text-gray-900">{{ bloodStockTotal }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M19.5 3H4.5C3.12 3 2 4.12 2 5.5v13C2 19.88 3.12 21 4.5 21h15c1.38 0 2.5-1.12 2.5-2.5v-13C22 4.12 20.88 3 19.5 3zm-5 9h-3v3h-2v-3h-3v-2h3V7h2v3h3v2z"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Berita Posted</p>
                        <p class="text-3xl font-bold text-gray-900">{{ postCount }}</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-600/20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Group: Unit DD -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="w-2 h-6 bg-red-600 rounded-full"></span>
                        Unit Donor Darah
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <Link href="/manage/blood-stocks" class="p-4 border-2 border-gray-100 rounded-xl hover:border-red-600 hover:bg-red-50/30 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-red-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <p class="text-sm font-bold text-gray-700">Stok Darah</p>
                            <p class="text-[10px] text-gray-500">Update stok harian</p>
                        </Link>
                        <Link href="/manage/blood-donors" class="p-4 border-2 border-gray-100 rounded-xl hover:border-red-600 hover:bg-red-50/30 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-red-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-sm font-bold text-gray-700">Data Donor</p>
                            <p class="text-[10px] text-gray-500">Jadwal & Riwayat</p>
                        </Link>
                    </div>
                </div>

                <!-- Group: Berita & Layanan -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                        Markas, Klinik & Berita
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <Link href="/manage/posts" class="p-4 border-2 border-gray-100 rounded-xl hover:border-blue-600 hover:bg-blue-50/30 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6m-6 4h2"/></svg>
                            <p class="text-sm font-bold text-gray-700">Kelola Berita</p>
                        </Link>
                        <Link href="/manage/services" class="p-4 border-2 border-gray-100 rounded-xl hover:border-blue-600 hover:bg-blue-50/30 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            <p class="text-sm font-bold text-gray-700">Layanan</p>
                        </Link>
                        <Link href="/manage/categories" class="p-4 border-2 border-gray-100 rounded-xl hover:border-blue-600 hover:bg-blue-50/30 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <p class="text-sm font-bold text-gray-700">Kategori</p>
                        </Link>
                    </div>
                </div>

                <!-- Group: Sistem -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="w-2 h-6 bg-gray-600 rounded-full"></span>
                        Situs & Keamanan
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <Link href="/manage/hero-sliders" class="p-4 border-2 border-gray-100 rounded-xl hover:border-gray-600 hover:bg-gray-50 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm font-bold text-gray-700">Hero Slider</p>
                        </Link>
                        <Link href="/manage/footer-setting" class="p-4 border-2 border-gray-100 rounded-xl hover:border-gray-600 hover:bg-gray-50 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                            <p class="text-sm font-bold text-gray-700">Kontak & Footer</p>
                        </Link>
                        <Link href="/manage/users" class="p-4 border-2 border-gray-100 rounded-xl hover:border-gray-600 hover:bg-gray-50 transition group block">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7 10.5h10M3 19c0-2 2-4 9-4s9 2 9 4"/></svg>
                            <p class="text-sm font-bold text-gray-700">Manajemen User</p>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold mb-6 border-b pb-4">Informasi Penting</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
                        <p class="text-sm font-semibold text-blue-900">Panduan</p>
                        <p class="text-xs text-blue-700 mt-1">Lihat dokumentasi lengkap untuk mengelola sistem</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-600">
                        <p class="text-sm font-semibold text-green-900">Status Sistem</p>
                        <p class="text-xs text-green-700 mt-1">✓ Semua layanan berjalan normal</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-600">
                        <p class="text-sm font-semibold text-yellow-900">Catatan</p>
                        <p class="text-xs text-yellow-700 mt-1">Update stok darah setiap hari</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
