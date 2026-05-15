<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({ menus: Array });

const deleteMenu = (id) => {
    if (confirm('Yakin hapus menu ini? Semua submenu juga akan terhapus.')) {
        router.delete(`/manage/menus/${id}`);
    }
};
</script>

<template>
    <AdminLayout title="Manajemen Navbar">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Atur menu navigasi utama dan dropdown website.</p>
            <Link href="/manage/menus/create"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Menu
            </Link>
        </div>

        <div class="space-y-4">
            <div v-for="menu in menus" :key="menu.id" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center font-bold text-xs">
                            {{ menu.order }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ menu.name }}</h3>
                            <p class="text-xs text-gray-500">{{ menu.url || 'Dropdown Parent' }}</p>
                        </div>
                        <span v-if="!menu.is_active" class="px-2 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold rounded uppercase">Nonaktif</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Link :href="`/manage/menus/${menu.id}/edit`" 
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </Link>
                        <button @click="deleteMenu(menu.id)" 
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Children -->
                <div v-if="menu.children && menu.children.length > 0" class="divide-y divide-gray-100 border-t border-gray-100">
                    <div v-for="child in menu.children" :key="child.id" class="p-4 pl-16 flex items-center justify-between hover:bg-gray-50 transition group">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">{{ child.name }}</h4>
                                <p class="text-[10px] text-gray-400">{{ child.url }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <Link :href="`/manage/menus/${child.id}/edit`" 
                                class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </Link>
                            <button @click="deleteMenu(child.id)" 
                                class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="menus.length === 0" class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                <p class="text-gray-400 text-sm">Belum ada menu navigasi.</p>
            </div>
        </div>
    </AdminLayout>
</template>
