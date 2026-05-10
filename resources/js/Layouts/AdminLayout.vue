<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({ title: String });
const page = usePage();
const user = computed(() => page.props.auth.user);
const flash = computed(() => page.props.flash);

const isSidebarOpen = ref(true);
const toggleSidebar = () => isSidebarOpen.value = !isSidebarOpen.value;

const logout = () => router.post('/logout');

const navItems = [
    { label: 'Dashboard', href: '/dashboard/admin', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    
    { header: 'Unit DD' },
    { label: 'Stok Darah', href: '/manage/blood-stocks', icon: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z' },
    { label: 'Data Donor', href: '/manage/blood-donors', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' },

    { header: 'Layanan' },
    { label: 'Semua Layanan', href: '/manage/services', icon: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z' },

    { header: 'Berita' },
    { label: 'Kelola Berita', href: '/manage/posts', icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6m-6 4h2' },
    { label: 'Kategori Berita', href: '/manage/categories', icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z' },

    { header: 'Pengaturan' },
    { label: 'Konten Halaman', href: '/manage/pages', icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' },
    { label: 'Background/Slider', href: '/manage/hero-sliders', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { label: 'Footer & Kontak', href: '/manage/footer-setting', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z' },
    { label: 'Manajemen User', href: '/manage/users', icon: 'M12 4.354a4 4 0 110 8.048M7 10.5h10M3 19c0-2 2-4 9-4s9 2 9 4' },
];

const isActive = (href) => page.url.startsWith(href) && href !== '/dashboard/admin'
    || page.url === href;
</script>

<template>
    <Head :title="title + ' — Admin PMI'" />
    <div class="flex h-screen bg-gray-100 font-sans overflow-hidden">

        <!-- Sidebar -->
        <aside
            :class="isSidebarOpen ? 'w-64' : 'w-20'"
            class="bg-gray-900 text-white flex flex-col transition-all duration-300 ease-in-out flex-shrink-0">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-4 py-5 border-b border-gray-700">
                <div class="w-9 h-9 bg-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z"/>
                    </svg>
                </div>
                <div v-show="isSidebarOpen" class="overflow-hidden">
                    <p class="font-bold text-sm leading-tight text-white whitespace-nowrap">PMI Wonosobo</p>
                    <p class="text-xs text-gray-400 whitespace-nowrap">Admin Panel</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden custom-scrollbar">
                <template v-for="(item, idx) in navItems" :key="idx">
                    <!-- Header -->
                    <div v-if="item.header" v-show="isSidebarOpen" 
                         class="px-6 py-2 mt-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                        {{ item.header }}
                    </div>
                    <div v-else-if="item.header" class="h-px bg-gray-800 mx-4 my-2 opacity-50"></div>

                    <!-- Link -->
                    <a v-else :href="item.href"
                        :class="[
                            isActive(item.href)
                                ? 'bg-red-600 text-white shadow-lg shadow-red-600/20'
                                : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                            'flex items-center gap-3 px-4 py-3 mx-2 rounded-xl transition-all duration-200 group'
                        ]">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon"/>
                        </svg>
                        <span v-show="isSidebarOpen" class="text-sm font-medium whitespace-nowrap truncate">{{ item.label }}</span>
                    </a>
                </template>
            </nav>

            <!-- User Info -->
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-red-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ user?.name?.charAt(0).toUpperCase() }}
                    </div>
                    <div v-show="isSidebarOpen" class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ user?.name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ user?.email }}</p>
                    </div>
                    <button @click="logout" v-show="isSidebarOpen"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-400 hover:bg-gray-800 transition flex-shrink-0"
                        title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="toggleSidebar"
                        class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-bold text-gray-800">{{ title }}</h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/" target="_blank"
                        class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition px-3 py-2 rounded-xl hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Lihat Website
                    </a>
                </div>
            </header>

            <!-- Flash Messages -->
            <div v-if="flash?.success" class="mx-6 mt-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3 flex-shrink-0">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">{{ flash.success }}</p>
            </div>
            <div v-if="flash?.error" class="mx-6 mt-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center gap-3 flex-shrink-0">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">{{ flash.error }}</p>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
