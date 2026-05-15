<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    page: Object,
});

const form = useForm({
    title: props.page.title,
    content: props.page.content || {},
    image: null,
    remove_image: false,
    _method: 'PUT',
});

// Ensure basic structure exists based on slug
if (!form.content.hero_description) form.content.hero_description = '';
if (props.page.slug === '7-prinsip' && !form.content.principles) form.content.principles = [];
if (props.page.slug === 'produk' && !form.content.products) form.content.products = [];
if (props.page.slug === 'registrasi' && !form.content.schedules) form.content.schedules = [];
if (!form.content.sections && !['7-prinsip', 'produk', 'registrasi', 'mars-hymne'].includes(props.page.slug)) {
    form.content.sections = [];
}

const imagePreview = ref(props.page.image_url);

const onImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        form.remove_image = false;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    form.remove_image = true;
    imagePreview.value = null;
};

const submit = () => {
    form.post(`/manage/pages/${props.page.id}`);
};
</script>

<template>
    <AdminLayout :title="'Edit ' + page.title">
        <div class="max-w-6xl mx-auto">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Header Card -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Judul Halaman</label>
                                <input v-model="form.title" type="text" 
                                    class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-500 transition font-bold text-gray-700" 
                                    placeholder="Masukkan judul halaman...">
                                <p v-if="form.errors.title" class="mt-2 text-xs text-red-600 font-bold">{{ form.errors.title }}</p>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Slug (URL)</label>
                                <div class="px-5 py-4 bg-gray-100 border border-gray-200 rounded-2xl text-gray-500 font-mono text-sm select-none">
                                    /{{ page.slug }}
                                </div>
                                <p class="mt-2 text-[10px] text-gray-400 font-medium italic">Slug tidak dapat diubah untuk menjaga integritas link.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 flex justify-between items-center">
                                <span>Gambar Banner (Opsional)</span>
                                <button v-if="imagePreview" type="button" @click="removeImage" class="text-red-600 hover:text-red-700 font-bold transition">Hapus</button>
                            </label>
                            <div class="relative group">
                                <div class="w-full h-48 bg-gray-100 rounded-[2rem] overflow-hidden border-2 border-dashed border-gray-200 flex items-center justify-center transition group-hover:border-red-300">
                                    <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover">
                                    <div v-else class="text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Pilih Gambar</span>
                                    </div>
                                    <input type="file" @change="onImageChange" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                            <p v-if="form.errors.image" class="mt-2 text-xs text-red-600 font-bold">{{ form.errors.image }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content Card -->
                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-8">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Konfigurasi Konten Dinamis</label>
                        <div class="px-4 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase">Mode Editor: {{ page.slug }}</div>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Hero Description (Always available) -->
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Deskripsi Hero/Banner</label>
                            <textarea v-model="form.content.hero_description" rows="3" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-500 transition text-sm font-medium"></textarea>
                        </div>

                        <hr class="border-gray-100">

                        <!-- SPECIALIZED EDITORS -->

                        <!-- 7 Prinsip Editor -->
                        <div v-if="page.slug === '7-prinsip'" class="space-y-6">
                            <div v-for="(p, index) in form.content.principles" :key="index" class="p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100 relative group">
                                <button type="button" @click="form.content.principles.splice(index, 1)" class="absolute top-4 right-4 p-2 bg-white text-gray-400 hover:text-red-600 rounded-full shadow-sm opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Judul (ID)</label>
                                        <input v-model="p.title" type="text" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Judul (EN)</label>
                                        <input v-model="p.subtitle" type="text" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Deskripsi Prinsip</label>
                                    <textarea v-model="p.description" rows="3" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm"></textarea>
                                </div>
                            </div>
                            <button type="button" @click="form.content.principles.push({title:'', subtitle:'', description:'', icon:'heart', color:'red'})" class="w-full py-4 border-2 border-dashed border-gray-200 rounded-[2rem] text-gray-400 font-bold text-xs hover:border-red-300 hover:text-red-600 transition uppercase tracking-widest flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah Prinsip
                            </button>
                        </div>

                        <!-- Produk Darah Editor -->
                        <div v-else-if="page.slug === 'produk'" class="space-y-6">
                            <div v-for="(p, index) in form.content.products" :key="index" class="p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100 relative group">
                                <button type="button" @click="form.content.products.splice(index, 1)" class="absolute top-4 right-4 p-2 bg-white text-gray-400 hover:text-red-600 rounded-full shadow-sm opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Nama Singkat</label>
                                        <input v-model="p.name" type="text" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Judul Lengkap</label>
                                        <input v-model="p.title" type="text" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Kegunaan</label>
                                    <input v-model="p.usage" type="text" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                </div>
                            </div>
                            <button type="button" @click="form.content.products.push({name:'', title:'', usage:'', description:'', color:'bg-red-600'})" class="w-full py-4 border-2 border-dashed border-gray-200 rounded-[2rem] text-gray-400 font-bold text-xs hover:border-red-300 hover:text-red-600 transition uppercase tracking-widest flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah Produk
                            </button>
                        </div>

                        <!-- Mars & Hymne Editor -->
                        <div v-else-if="page.slug === 'mars-hymne'" class="space-y-8">
                            <div class="p-8 bg-red-50 rounded-[2.5rem] border border-red-100">
                                <label class="block text-xs font-black text-red-600 uppercase mb-4">Konfigurasi Mars PMI</label>
                                <div class="space-y-4">
                                    <input v-model="form.content.mars_title" type="text" placeholder="Judul Mars" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm font-bold">
                                    <textarea v-model="form.content.mars_content" rows="6" placeholder="Lirik Mars" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm italic"></textarea>
                                </div>
                            </div>
                            <div class="p-8 bg-blue-50 rounded-[2.5rem] border border-blue-100">
                                <label class="block text-xs font-black text-blue-600 uppercase mb-4">Konfigurasi Hymne PMI</label>
                                <div class="space-y-4">
                                    <input v-model="form.content.hymne_title" type="text" placeholder="Judul Hymne" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition text-sm font-bold">
                                    <textarea v-model="form.content.hymne_content" rows="6" placeholder="Lirik Hymne" class="w-full px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition text-sm italic"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal Dokter Editor -->
                        <div v-else-if="page.slug === 'registrasi'" class="space-y-6">
                            <div v-for="(s, index) in form.content.schedules" :key="index" class="p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100 relative group">
                                <button type="button" @click="form.content.schedules.splice(index, 1)" class="absolute top-4 right-4 p-2 bg-white text-gray-400 hover:text-red-600 rounded-full shadow-sm opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Nama Dokter</label>
                                        <input v-model="s.doctor" type="text" class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Spesialis</label>
                                        <input v-model="s.specialty" type="text" class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Hari</label>
                                        <input v-model="s.days" type="text" class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Waktu</label>
                                        <input v-model="s.time" type="text" class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm">
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click="form.content.schedules.push({doctor:'', specialty:'', days:'', time:''})" class="w-full py-4 border-2 border-dashed border-gray-200 rounded-[2rem] text-gray-400 font-bold text-xs hover:border-red-300 hover:text-red-600 transition uppercase tracking-widest flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah Jadwal Dokter
                            </button>
                        </div>

                        <!-- Generic Section Builder (For Sejarah, Visi Misi, PP, Ambulance, etc.) -->
                        <div v-else class="space-y-8">
                            <div v-for="(section, sIdx) in form.content.sections" :key="sIdx" class="p-8 bg-gray-50 rounded-[3rem] border border-gray-100 relative group">
                                <button type="button" @click="form.content.sections.splice(sIdx, 1)" class="absolute top-6 right-6 p-2 bg-white text-gray-300 hover:text-red-600 rounded-full shadow-sm opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                                
                                <div class="mb-6">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Judul Bagian/Seksi</label>
                                    <input v-model="section.title" type="text" class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-red-500 transition font-bold text-gray-700">
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase">Poin-poin Konten</label>
                                    <div v-for="(item, iIdx) in section.items" :key="iIdx" class="flex gap-2">
                                        <textarea v-model="section.items[iIdx]" rows="2" class="flex-1 px-5 py-3 bg-white border-none rounded-xl focus:ring-2 focus:ring-red-500 transition text-sm"></textarea>
                                        <button type="button" @click="section.items.splice(iIdx, 1)" class="p-2 text-gray-300 hover:text-red-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                        </button>
                                    </div>
                                    <button type="button" @click="section.items.push('')" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:text-red-700 flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                                        Tambah Poin
                                    </button>
                                </div>
                            </div>
                            
                            <button type="button" @click="form.content.sections.push({title: 'Baris Baru', items: ['']})" class="w-full py-6 border-2 border-dashed border-gray-200 rounded-[3rem] text-gray-400 font-black text-xs hover:border-red-300 hover:text-red-600 transition uppercase tracking-widest flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah Bagian Baru (Seksi)
                            </button>
                        </div>
                    </div>
                    
                    <p v-if="form.errors.content" class="mt-4 text-xs text-red-600 font-bold text-center">{{ form.errors.content }}</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4">
                    <Link href="/manage/pages" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Batal & Kembali</Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-10 py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-red-700 transition shadow-xl shadow-red-200 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
