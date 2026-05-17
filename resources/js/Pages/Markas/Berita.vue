<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    posts: Object,
});
</script>

<template>
    <Head title="Berita Terkini" />
    <MainLayout>
        <HeroSection 
            title="Berita Terkini" 
            subtitle="Markas" 
            description="Informasi terbaru seputar kegiatan dan layanan kemanusiaan PMI Kabupaten Wonosobo."
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <article v-for="post in posts.data" :key="post.id" class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:shadow-red-100 group flex flex-col">
                    <Link :href="`/berita/${post.slug}`" class="relative block overflow-hidden aspect-[16/10]">
                        <img :src="post.image_url || 'https://images.unsplash.com/photo-1542884748-2b87b36c6b90?q=80&w=2070&auto=format&fit=crop'" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-1.5 bg-red-600 text-white text-[10px] font-black uppercase rounded-xl shadow-lg">{{ post.category?.name || 'UMUM' }}</span>
                        </div>
                    </Link>
                    
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ new Date(post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                        </div>
                        
                        <Link :href="`/berita/${post.slug}`">
                            <h2 class="text-xl font-black text-gray-900 mb-4 group-hover:text-red-600 transition line-clamp-2 leading-tight">{{ post.title }}</h2>
                        </Link>
                        
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 line-clamp-3" v-html="post.content"></p>
                        
                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                            <Link :href="`/berita/${post.slug}`" class="text-xs font-black uppercase tracking-widest text-red-600 flex items-center gap-2 group-hover:gap-4 transition-all">
                                Baca Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </Link>
                        </div>
                    </div>
                </article>

                <div v-if="posts.data.length === 0" class="col-span-full py-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4"/></svg>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest">Belum ada berita yang diterbitkan.</p>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="posts.links.length > 3" class="mt-16 flex justify-center gap-2">
                <template v-for="(link, k) in posts.links" :key="k">
                    <Link v-if="link.url" 
                        :href="link.url" 
                        v-html="link.label"
                        class="px-5 py-3 rounded-xl text-sm font-black transition-all"
                        :class="link.active ? 'bg-red-600 text-white shadow-lg shadow-red-100' : 'bg-white text-gray-600 hover:bg-red-50 hover:text-red-600'"
                    />
                    <span v-else 
                        v-html="link.label" 
                        class="px-5 py-3 text-sm font-black text-gray-300"
                    />
                </template>
            </div>
        </div>
    </MainLayout>
</template>