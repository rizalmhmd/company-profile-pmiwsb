<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    post: Object,
    relatedPosts: Array,
});
</script>

<template>
    <Head :title="post?.title" />
    <MainLayout>
        <HeroSection 
            :title="post?.title" 
            subtitle="Berita Terkini" 
            description="Informasi terbaru dan dokumentasi kegiatan Palang Merah Indonesia Kabupaten Wonosobo."
        />

        <div class="container mx-auto px-4 py-16 -mt-10 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-7xl mx-auto">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <article class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
                        <div v-if="post?.image_url" class="aspect-video w-full overflow-hidden">
                            <img :src="post.image_url" class="w-full h-full object-cover" :alt="post.title">
                        </div>
                        
                        <div class="p-8 md:p-16">
                            <div class="flex items-center gap-4 mb-8">
                                <span class="px-4 py-1.5 bg-red-600 text-white text-xs font-black uppercase rounded-xl shadow-lg shadow-red-100">
                                    {{ post?.category?.name || 'UMUM' }}
                                </span>
                                <span class="text-gray-400 font-bold text-sm">
                                    {{ new Date(post?.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                                </span>
                            </div>

                            <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-8 leading-tight">
                                {{ post?.title }}
                            </h1>

                            <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6" v-html="post?.content">
                            </div>

                            <div class="mt-16 pt-8 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest leading-none">Diterbitkan oleh</p>
                                        <p class="text-sm font-bold text-gray-900 mt-1">Admin PMI Wonosobo</p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    <button class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-600 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92-1.31-2.92-2.92-2.92z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="space-y-12">
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                            Berita Lainnya
                        </h3>
                        <div class="space-y-6">
                            <Link v-for="related in relatedPosts" :key="related.id" :href="`/markas/berita/${related.slug}`" class="flex gap-4 group">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0">
                                    <img :src="related.image_url || 'https://images.unsplash.com/photo-1542884748-2b87b36c6b90?q=80&w=2070&auto=format&fit=crop'" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight group-hover:text-red-600 transition">{{ related.title }}</h4>
                                    <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-widest">
                                        {{ new Date(related.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }) }}
                                    </p>
                                </div>
                            </Link>
                            <div v-if="relatedPosts?.length === 0" class="text-center py-4">
                                <p class="text-xs text-gray-400 italic">Belum ada berita lainnya.</p>
                            </div>
                        </div>
                        
                        <Link href="/markas/berita" class="block w-full mt-8 py-4 bg-gray-50 text-center rounded-2xl text-xs font-black text-gray-400 uppercase tracking-widest hover:bg-red-50 hover:text-red-600 transition">
                            Lihat Semua Berita
                        </Link>
                    </div>

                    <!-- CTA -->
                    <div class="bg-red-600 rounded-3xl p-8 text-white shadow-xl shadow-red-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 relative z-10">Pahlawan Kemanusiaan</h3>
                        <p class="text-red-100 text-sm mb-6 relative z-10 leading-relaxed">Satu kantong darah Anda dapat menyelamatkan hingga tiga nyawa. Mari berdonor!</p>
                        <Link href="/donor/jadwal" class="inline-block bg-white text-red-600 px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg relative z-10">
                            Cek Jadwal Donor
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
