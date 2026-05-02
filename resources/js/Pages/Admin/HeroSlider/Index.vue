<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    sliders: Array,
});

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
</script>

<template>
    <AdminLayout title="Background / Slider Beranda">
        <!-- Header Actions -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm">Kelola gambar background yang tampil di halaman beranda.</p>
            </div>
            <Link href="/manage/hero-sliders/create"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Background
            </Link>
        </div>

        <!-- Grid Cards with Preview -->
        <div v-if="sliders.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="slider in sliders" :key="slider.id"
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">

                <!-- Image Preview -->
                <div class="relative h-48 bg-gray-200 overflow-hidden">
                    <img v-if="slider.image_url" :src="slider.image_url" :alt="slider.title || 'Slider'"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <span :class="slider.is_active ? 'bg-green-500' : 'bg-gray-400'"
                            class="text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                            {{ slider.is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <!-- Order Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="bg-black/50 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                            #{{ slider.order }}
                        </span>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 truncate">{{ slider.title || '(Tanpa Judul)' }}</h3>
                    <p class="text-xs text-gray-400 mt-1 truncate">{{ slider.subtitle || '-' }}</p>
                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">{{ slider.description || '-' }}</p>
                </div>

                <!-- Actions -->
                <div class="px-4 pb-4 flex gap-2">
                    <Link :href="`/manage/hero-sliders/${slider.id}/edit`"
                        class="flex-1 text-center py-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition">
                        Edit
                    </Link>
                    <Link :href="`/manage/hero-sliders/${slider.id}`" method="delete" as="button"
                        class="flex-1 text-center py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition"
                        onclick="return confirm('Hapus background ini?')">
                        Hapus
                    </Link>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500 font-medium mb-4">Belum ada background yang ditambahkan.</p>
            <Link href="/manage/hero-sliders/create"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                Tambah Sekarang
            </Link>
        </div>
    </AdminLayout>
</template>
