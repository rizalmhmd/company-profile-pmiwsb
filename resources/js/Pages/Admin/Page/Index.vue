<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    pages: Array,
});

const groupedPages = computed(() => {
    return props.pages.reduce((acc, page) => {
        const category = page.category || 'Lainnya';
        if (!acc[category]) {
            acc[category] = [];
        }
        acc[category].push(page);
        return acc;
    }, {});
});
</script>

<template>
    <AdminLayout title="Kelola Halaman Statis">
        <div class="space-y-12">
            <div v-for="(pages, category) in groupedPages" :key="category" class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h2 class="text-2xl font-black text-gray-800 flex items-center gap-3">
                            <span class="w-2 h-8 bg-red-600 rounded-full"></span>
                            {{ category.toUpperCase() }}
                        </h2>
                        <p class="text-sm text-gray-400 mt-1 font-medium">Halaman yang termasuk dalam kategori {{ category }}</p>
                    </div>
                    <div class="px-4 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                        {{ pages.length }} HALAMAN
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-100">
                                <th class="px-8 py-5">Judul Halaman</th>
                                <th class="px-8 py-5">Slug / URL</th>
                                <th class="px-8 py-5">Update Terakhir</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="page in pages" :key="page.id" class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white text-red-600 rounded-2xl flex items-center justify-center shrink-0 shadow-sm border border-gray-100 group-hover:scale-110 transition duration-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                        </div>
                                        <span class="font-bold text-gray-700 text-base">{{ page.title }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-mono border border-gray-200">/{{ page.slug }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-500 font-medium">
                                    {{ new Date(page.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <Link :href="`/manage/pages/${page.id}/edit`" 
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 transition-all duration-300 shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        Edit Konten
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
