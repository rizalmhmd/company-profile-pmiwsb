<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({ posts: [Array, Object] });
const items = Array.isArray(props.posts) ? props.posts : (props.posts?.data ?? []);

const formatDate = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';
</script>

<template>
    <AdminLayout title="Berita">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Kelola artikel dan berita yang tampil di website.</p>
            <Link href="/manage/posts/create"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Berita
            </Link>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">Cover</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Tanggal</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="post in items" :key="post.id" class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <img v-if="post.image_url" :src="post.image_url" class="w-12 h-12 rounded-xl object-cover"/>
                                <div v-else class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-800 line-clamp-1">{{ post.title }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 hidden md:table-cell">{{ post.category?.name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span :class="post.is_published
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-yellow-100 text-yellow-700'"
                                    class="px-2.5 py-1 rounded-full text-xs font-bold">
                                    {{ post.is_published ? 'Publik' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-400 hidden lg:table-cell">{{ formatDate(post.created_at) }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="`/manage/posts/${post.id}/edit`"
                                        class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">Edit</Link>
                                    <Link :href="`/manage/posts/${post.id}`"
                                        method="delete" as="button" preserve-scroll
                                        class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"
                                        onclick="return confirm('Yakin hapus berita ini?')">Hapus</Link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="items.length === 0">
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400 text-sm">Belum ada berita.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
