<script setup>
import { ref, computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    title: String,
});

const page = usePage();
const canLogin = computed(() => page.props.canLogin);
const footer = computed(() => page.props.footer);

const isProfileOpen = ref(false);
const isUnitDDOpen = ref(false);
const isMarkisOpen = ref(false);
const isKlinikOpen = ref(false);
const isHubungiKamiOpen = ref(false);

// Mobile States
const isMobileMenuOpen = ref(false);
const mobileProfilOpen = ref(false);
const mobileUnitDDOpen = ref(false);
const mobileMarkisOpen = ref(false);
const mobileKlinikOpen = ref(false);
const mobileHubungiKamiOpen = ref(false);
</script>

<template>
    <Head :title="title" />

    <div class="min-h-screen bg-gray-50 text-gray-900">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center gap-2 sm:gap-4">
                    <Link href="/" class="flex items-center gap-2 sm:gap-4 group">
                        <div class="text-red-600">
                            <img v-if="$page.props.siteSetting?.logo_url" :src="$page.props.siteSetting.logo_url" class="h-10 w-10 sm:h-12 sm:w-12 object-contain transition-transform group-hover:scale-105" alt="Logo">
                            <svg v-else class="h-10 w-10 sm:h-12 sm:w-12 transition-all" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-xl font-bold text-red-600 leading-none uppercase">
                                {{ $page.props.siteSetting?.site_name?.split(' ')[0] || 'PALANG' }} 
                                <span class="hidden sm:inline">{{ $page.props.siteSetting?.site_name?.split(' ').slice(1, 3).join(' ') || 'MERAH INDONESIA' }}</span>
                                <span class="sm:hidden">{{ $page.props.siteSetting?.site_name?.split(' ').slice(1, 2).join(' ') || 'MERAH' }}</span>
                            </h1>
                            <p class="text-[8px] sm:text-xs text-gray-500 uppercase mt-1">
                                {{ $page.props.siteSetting?.site_name?.split(' ').slice(3).join(' ') || 'Kabupaten Wonosobo' }}
                            </p>
                        </div>
                    </Link>
                </div>
                <nav class="hidden lg:flex items-center gap-6 font-semibold text-gray-700 text-sm">
                    <Link href="/" class="hover:text-red-600 transition" :class="{'text-red-600 border-b-2 border-red-600 pb-1': $page.url === '/'}">BERANDA</Link>
                    
                    <!-- Dropdown Profil -->
                    <div class="relative group" @mouseenter="isProfileOpen = true" @mouseleave="isProfileOpen = false">
                        <button class="hover:text-red-600 transition flex items-center gap-1 py-2">
                            PROFIL
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div v-show="isProfileOpen" 
                             class="absolute left-0 mt-0 w-64 bg-white shadow-2xl rounded-xl border border-gray-100 py-4 z-[100] transform transition-all duration-300">
                            <Link href="/profil/visi-misi" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Visi Misi</Link>
                            <Link href="/profil/struktur/markas" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Struktur Organisasi</Link>
                            <Link href="/profil/7-prinsip" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">7 Prinsip</Link>
                            <Link href="/profil/sejarah" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Sejarah PMI</Link>
                        </div>
                    </div>

                    <!-- Dropdown Unit DD -->
                    <div class="relative group" @mouseenter="isUnitDDOpen = true" @mouseleave="isUnitDDOpen = false">
                        <button class="hover:text-red-600 transition flex items-center gap-1 py-2 uppercase">
                            UNIT DONOR DARAH
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div v-show="isUnitDDOpen" 
                             class="absolute left-0 mt-0 w-64 bg-white shadow-2xl rounded-xl border border-gray-100 py-4 z-[100] transform transition-all duration-300">
                            <Link href="/donor/info/stok" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Stok Darah</Link>
                            <Link href="/donor/jadwal" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Jadwal Donor/ Mobil Unit</Link>
                        </div>
                    </div>

                    <!-- Dropdown Markas -->
                    <div class="relative group" @mouseenter="isMarkisOpen = true" @mouseleave="isMarkisOpen = false">
                        <button class="hover:text-red-600 transition flex items-center gap-1 py-2 uppercase">
                            MARKAS
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div v-show="isMarkisOpen" 
                             class="absolute left-0 mt-0 w-64 bg-white shadow-2xl rounded-xl border border-gray-100 py-4 z-[100] transform transition-all duration-300">
                            <Link href="/markas/pertolongan-pertama" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">PPPK</Link>
                            <Link href="/markas/sibats" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Layanan Ambulance</Link>
                        </div>
                    </div>

                    <!-- Dropdown Klinik -->
                    <div class="relative group" @mouseenter="isKlinikOpen = true" @mouseleave="isKlinikOpen = false">
                        <button class="hover:text-red-600 transition flex items-center gap-1 py-2 uppercase">
                            KLINIK
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div v-show="isKlinikOpen" 
                             class="absolute left-0 mt-0 w-64 bg-white shadow-2xl rounded-xl border border-gray-100 py-4 z-[100] transform transition-all duration-300">
                            <Link href="/profil/struktur/klinik" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Waktu Pelayanan</Link>
                            <Link href="/donor/info/produk" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Jenis Pelayanan</Link>
                            <Link href="/donor/registrasi" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Jadwal Dokter Praktek</Link>
                        </div>
                    </div>

                    <Link href="/markas/berita" class="hover:text-red-600 transition">BERITA</Link>

                    <!-- Dropdown Hubungi Kami -->
                    <div class="relative group" @mouseenter="isHubungiKamiOpen = true" @mouseleave="isHubungiKamiOpen = false">
                        <button class="hover:text-red-600 transition flex items-center gap-1 py-2 uppercase">
                            HUBUNGI KAMI
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div v-show="isHubungiKamiOpen" 
                             class="absolute left-0 mt-0 w-64 bg-white shadow-2xl rounded-xl border border-gray-100 py-4 z-[100] transform transition-all duration-300">
                            <a href="https://wa.me/6285742750060" target="_blank" class="block px-6 py-3 text-sm hover:bg-red-50 hover:text-red-600 transition">Whatsapp</a>
                        </div>
                    </div>
                </nav>
                <div class="flex items-center gap-4">
                    <!-- Search (Desktop) -->
                    <div class="hidden sm:flex items-center gap-4">
                        <button class="p-2 text-gray-500 hover:text-red-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Hamburger Button (Mobile) -->
                    <button @click="isMobileMenuOpen = true" class="lg:hidden p-2 text-gray-600 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Mobile Sidebar -->
        <transition name="fade">
            <div v-if="isMobileMenuOpen" class="fixed inset-0 z-[100] lg:hidden">
                <!-- Backdrop -->
                <div @click="isMobileMenuOpen = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
                
                <!-- Sidebar Content -->
                <transition name="slide-mobile">
                    <div v-if="isMobileMenuOpen" 
                         class="absolute right-0 top-0 bottom-0 w-80 bg-white shadow-2xl flex flex-col z-[101]">
                        <div class="p-6 border-b flex justify-between items-center">
                            <div class="text-red-600">
                                <svg class="h-10 w-10" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z" />
                                </svg>
                            </div>
                            <button @click="isMobileMenuOpen = false" class="p-2 text-gray-500 hover:text-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <nav class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                            <Link href="/" class="block text-lg font-bold text-red-600" @click="isMobileMenuOpen = false">BERANDA</Link>
                            
                            <!-- Profil Accordion -->
                            <div class="space-y-2">
                                <button @click="mobileProfilOpen = !mobileProfilOpen" class="w-full flex justify-between items-center text-lg font-bold text-gray-700 hover:text-red-600 transition-colors">
                                    PROFIL
                                    <svg :class="{'rotate-180': mobileProfilOpen}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <transition name="accordion">
                                    <div v-show="mobileProfilOpen" class="pl-4 space-y-3 border-l-2 border-red-100 mt-2 overflow-hidden">
                                        <Link href="/profil/visi-misi" class="block text-gray-600 hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Visi Misi</Link>
                                        <Link href="/profil/struktur/markas" class="block text-gray-600 hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Struktur Organisasi</Link>
                                        <Link href="/profil/7-prinsip" class="block text-gray-600 hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">7 Prinsip</Link>
                                        <Link href="/profil/sejarah" class="block text-gray-600 hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Sejarah PMI</Link>
                                    </div>
                                </transition>
                            </div>

                            <!-- Unit DD Accordion -->
                            <div class="space-y-2">
                                <button @click="mobileUnitDDOpen = !mobileUnitDDOpen" class="w-full flex justify-between items-center text-lg font-bold text-gray-700 uppercase hover:text-red-600 transition-colors">
                                    UNIT DD
                                    <svg :class="{'rotate-180': mobileUnitDDOpen}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <transition name="accordion">
                                    <div v-show="mobileUnitDDOpen" class="pl-4 space-y-3 border-l-2 border-red-100 mt-2 text-gray-600 overflow-hidden">
                                        <Link href="/donor/info/stok" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Stok Darah</Link>
                                        <Link href="/donor/jadwal" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Jadwal Donor/ Mobil Unit</Link>
                                    </div>
                                </transition>
                            </div>

                            <!-- Markas Accordion -->
                            <div class="space-y-2">
                                <button @click="mobileMarkisOpen = !mobileMarkisOpen" class="w-full flex justify-between items-center text-lg font-bold text-gray-700 uppercase hover:text-red-600 transition-colors">
                                    MARKAS
                                    <svg :class="{'rotate-180': mobileMarkisOpen}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <transition name="accordion">
                                    <div v-show="mobileMarkisOpen" class="pl-4 space-y-3 border-l-2 border-red-100 mt-2 text-gray-600 overflow-hidden">
                                        <Link href="/markas/pertolongan-pertama" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">PPPK</Link>
                                        <Link href="/markas/sibats" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Ambulance</Link>
                                    </div>
                                </transition>
                            </div>

                            <!-- Klinik Accordion -->
                            <div class="space-y-2">
                                <button @click="mobileKlinikOpen = !mobileKlinikOpen" class="w-full flex justify-between items-center text-lg font-bold text-gray-700 uppercase hover:text-red-600 transition-colors">
                                    KLINIK
                                    <svg :class="{'rotate-180': mobileKlinikOpen}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <transition name="accordion">
                                    <div v-show="mobileKlinikOpen" class="pl-4 space-y-3 border-l-2 border-red-100 mt-2 text-gray-600 overflow-hidden">
                                        <Link href="/profil/struktur/klinik" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Waktu Pelayanan</Link>
                                        <Link href="/donor/info/produk" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Jenis Pelayanan</Link>
                                        <Link href="/donor/registrasi" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Jadwal Dokter Praktek</Link>
                                    </div>
                                </transition>
                            </div>

                            <Link href="/markas/berita" class="block text-lg font-bold text-gray-700 uppercase hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">BERITA</Link>

                            <!-- Hubungi Kami Accordion -->
                            <div class="space-y-2">
                                <button @click="mobileHubungiKamiOpen = !mobileHubungiKamiOpen" class="w-full flex justify-between items-center text-lg font-bold text-gray-700 uppercase hover:text-red-600 transition-colors">
                                    HUBUNGI KAMI
                                    <svg :class="{'rotate-180': mobileHubungiKamiOpen}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <transition name="accordion">
                                    <div v-show="mobileHubungiKamiOpen" class="pl-4 space-y-3 border-l-2 border-red-100 mt-2 text-gray-600 overflow-hidden">
                                        <a href="https://wa.me/6285742750060" target="_blank" class="block hover:text-red-600 transition-colors" @click="isMobileMenuOpen = false">Whatsapp</a>
                                    </div>
                                </transition>
                            </div>
                        </nav>

                        <div class="p-6 border-t space-y-4 bg-gray-50/50 text-center">
                            <span class="text-xs uppercase tracking-widest font-bold text-gray-500">PMI Wonosobo</span>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>

        <slot />

        <!-- Footer -->
        <footer class="bg-gray-900 text-white pt-16 pb-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                    <!-- About -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="text-white">
                                <img v-if="$page.props.siteSetting?.logo_url" :src="$page.props.siteSetting.logo_url" class="h-12 w-12 object-contain" alt="Logo">
                                <svg v-else class="h-12 w-12" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold leading-none text-red-500">{{ $page.props.siteSetting?.site_name?.split(' ').slice(0, 2).join(' ') || 'PMI' }}</h4>
                                <p class="text-xs tracking-widest text-gray-400 mt-1">{{ $page.props.siteSetting?.site_name?.split(' ').slice(2).join(' ') || 'WONOSOBO' }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            {{ footer?.about_pmi || 'Lembaga kemanusiaan yang berdedikasi untuk melayani masyarakat di Kabupaten Wonosobo.' }}
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-bold mb-6 border-b-2 border-red-600 inline-block">Tautan Cepat</h4>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><Link href="/profil/visi-misi" class="hover:text-red-500 transition">Visi & Misi</Link></li>
                            <li><Link href="/markas/berita" class="hover:text-red-500 transition">Berita Terkini</Link></li>
                            <li><Link href="/donor/jadwal" class="hover:text-red-500 transition">Jadwal Donor</Link></li>
                            <li><Link href="/profil/struktur/dewan" class="hover:text-red-500 transition">Struktur Organisasi</Link></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-lg font-bold mb-6 border-b-2 border-red-600 inline-block">Hubungi Kami</h4>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ footer?.address || 'Jl. Jenderal Sudirman No. 12, Wonosobo' }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 004.516 4.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ footer?.phone || '0286 123456' }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>{{ footer?.email || 'pmiwonosobo@gmail.com' }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Social & Admin Login -->
                    <div>
                        <h4 class="text-lg font-bold mb-6 border-b-2 border-red-600 inline-block">Media Sosial</h4>
                        <div class="flex gap-4 mb-8">
                            <a v-if="footer?.facebook" :href="footer.facebook" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition shadow-lg"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                            <a v-if="footer?.instagram" :href="footer.instagram" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition shadow-lg"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        </div>
                        
                        <!-- Login Button for Admin/Perawat -->
                        <Link v-if="canLogin" href="/login/admin" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg group">
                            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            MASUK ADMIN/PERAWAT
                        </Link>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                    <p>&copy; {{ footer?.copyright || '2026 PMI Kabupaten Wonosobo. All Rights Reserved.' }}</p>
                    <div class="flex gap-6">
                        <Link href="/profil/mars-hymne" class="hover:text-red-500 transition">Kebijakan Privasi</Link>
                        <Link href="/profil/sejarah" class="hover:text-red-500 transition">Syarat & Ketentuan</Link>
                    </div>
                </div>
            </div>
        </footer>

        <!-- WhatsApp Button -->
        <a href="https://wa.me/6285742750060" target="_blank" class="fixed bottom-6 right-6 z-[60] bg-green-500 text-white p-4 rounded-full shadow-2xl hover:bg-green-600 transition-all hover:scale-110 group">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.436 5.627 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-white text-gray-800 px-3 py-1 rounded-lg text-sm font-bold shadow-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Hubungi Kami</span>
        </a>
    </div>
</template>

<style scoped>
/* Sidebar Transitions */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.4s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

.slide-mobile-enter-active, .slide-mobile-leave-active {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-mobile-enter-from {
    transform: translateX(100%);
}
.slide-mobile-leave-to {
    transform: translateX(100%);
}

/* Accordion Transitions */
.accordion-enter-active, .accordion-leave-active {
    transition: all 0.3s ease-in-out;
    max-height: 200px;
}
.accordion-enter-from, .accordion-leave-to {
    max-height: 0;
    opacity: 0;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #ef4444;
    border-radius: 10px;
}

/* Base Transitions */
.v-enter-active, .v-leave-active {
  transition: opacity 0.5s ease;
}
.v-enter-from, .v-leave-to {
  opacity: 0;
}
</style>
