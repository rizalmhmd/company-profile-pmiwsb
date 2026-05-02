<?php
// Script to generate remaining admin Vue pages

$pages = [
    'Admin/BloodStock/Index' => [
        'title' => 'Stok Darah',
        'listRoute' => '/manage/blood-stocks',
        'createRoute' => '/manage/blood-stocks/create',
        'editRoute' => '/manage/blood-stocks/{id}/edit',
        'deleteRoute' => '/manage/blood-stocks/{id}',
        'itemVar' => 'stocks',
        'cols' => ['product' => 'Produk', 'stock_a' => 'A', 'stock_b' => 'B', 'stock_o' => 'O', 'stock_ab' => 'AB'],
    ],
    'Admin/BloodDonor/Index' => [
        'title' => 'Data Donor Darah',
        'listRoute' => '/manage/blood-donors',
        'createRoute' => '/manage/blood-donors/create',
        'editRoute' => '/manage/blood-donors/{id}/edit',
        'deleteRoute' => '/manage/blood-donors/{id}',
        'itemVar' => 'donors',
        'cols' => ['name' => 'Nama', 'location' => 'Lokasi', 'date' => 'Tanggal', 'time_start' => 'Mulai', 'time_end' => 'Selesai'],
    ],
    'Admin/Service/Index' => [
        'title' => 'Layanan',
        'listRoute' => '/manage/services',
        'createRoute' => '/manage/services/create',
        'editRoute' => '/manage/services/{id}/edit',
        'deleteRoute' => '/manage/services/{id}',
        'itemVar' => 'services',
        'cols' => ['title' => 'Judul', 'slug' => 'Slug'],
    ],
    'Admin/Post/Index' => [
        'title' => 'Berita',
        'listRoute' => '/manage/posts',
        'createRoute' => '/manage/posts/create',
        'editRoute' => '/manage/posts/{id}/edit',
        'deleteRoute' => '/manage/posts/{id}',
        'itemVar' => 'posts',
        'cols' => ['title' => 'Judul', 'category.name' => 'Kategori', 'is_published' => 'Publikasi'],
    ],
];

foreach ($pages as $path => $config) {
    $dir = __DIR__ . '/resources/js/Pages/' . dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $file = __DIR__ . '/resources/js/Pages/' . $path . '.vue';
    if (file_exists($file)) { echo "Skipped (exists): $path\n"; continue; }

    $itemVar = $config['itemVar'];
    $title = $config['title'];
    $createRoute = $config['createRoute'];
    $editRoute = $config['editRoute'];
    $deleteRoute = $config['deleteRoute'];
    $listRoute = $config['listRoute'];

    $headers = '';
    $cells = '';
    foreach ($config['cols'] as $col => $label) {
        $headers .= "                            <th class=\"px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider\">$label</th>\n";
        $key = str_replace('.', '?.', $col);
        $cells .= "                            <td class=\"px-4 py-3 text-sm text-gray-700\">{{ item.$key }}</td>\n";
    }

    $content = <<<VUE
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({ $itemVar: [Array, Object] });
const items = Array.isArray(props.$itemVar) ? props.$itemVar : (props.{$itemVar}?.data ?? []);
<\/script>

<template>
    <AdminLayout title="$title">
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">Kelola data $title.</p>
            <Link href="$createRoute"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </Link>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
$headers                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50 transition">
$cells                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="\`/manage/${path.split('/')[1].replace(/([A-Z])/g, '-\$1').toLowerCase().replace(/^-/,'')}/\${item.id}/edit\`"
                                        class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">Edit</Link>
                                    <Link :href="\`/manage/${path.split('/')[1].replace(/([A-Z])/g, '-\$1').toLowerCase().replace(/^-/,'')}/\${item.id}\`"
                                        method="delete" as="button" preserve-scroll
                                        class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"
                                        onclick="return confirm('Yakin hapus data ini?')">Hapus</Link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="items.length === 0">
                            <td colspan="99" class="px-4 py-12 text-center text-gray-400 text-sm">Belum ada data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
VUE;
    file_put_contents($file, $content);
    echo "Created: $path\n";
}

// Simple Form pages
$forms = [
    'Admin/BloodStock/Form' => [
        'title' => 'Stok Darah', 'prop' => 'stock', 'route' => 'blood-stocks',
        'fields' => [
            ['product', 'text', 'Nama Produk', 'required'],
            ['stock_a', 'number', 'Stok A', 'required'],
            ['stock_b', 'number', 'Stok B', 'required'],
            ['stock_o', 'number', 'Stok O', 'required'],
            ['stock_ab', 'number', 'Stok AB', 'required'],
        ],
    ],
    'Admin/BloodDonor/Form' => [
        'title' => 'Donor Darah', 'prop' => 'donor', 'route' => 'blood-donors',
        'fields' => [
            ['name', 'text', 'Nama Donor', 'required'],
            ['location', 'text', 'Lokasi', 'required'],
            ['date', 'date', 'Tanggal', 'required'],
            ['time_start', 'time', 'Jam Mulai', 'required'],
            ['time_end', 'time', 'Jam Selesai', 'required'],
        ],
    ],
    'Admin/Service/Form' => [
        'title' => 'Layanan', 'prop' => 'service', 'route' => 'services',
        'fields' => [
            ['title', 'text', 'Judul Layanan', 'required'],
            ['description', 'textarea', 'Deskripsi', 'required'],
            ['icon', 'text', 'Icon (opsional)', ''],
        ],
    ],
];

foreach ($forms as $path => $config) {
    $dir = __DIR__ . '/resources/js/Pages/' . dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $file = __DIR__ . '/resources/js/Pages/' . $path . '.vue';
    if (file_exists($file)) { echo "Skipped (exists): $path\n"; continue; }

    $prop = $config['prop'];
    $route = $config['route'];
    $title = $config['title'];

    $formFields = '';
    $initFields = '';
    foreach ($config['fields'] as $f) {
        [$name, $type, $label, $req] = $f;
        $initFields .= "    $name: props.$prop?.$name ?? '',\n";
        if ($type === 'textarea') {
            $formFields .= "                    <div class=\"md:col-span-2\">\n";
            $formFields .= "                        <label class=\"block text-sm font-semibold text-gray-700 mb-1.5\">$label</label>\n";
            $formFields .= "                        <textarea v-model=\"form.$name\" rows=\"4\" class=\"w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-none\"/>\n";
            $formFields .= "                        <p v-if=\"form.errors.$name\" class=\"text-red-500 text-xs mt-1\">{{ form.errors.$name }}</p>\n";
            $formFields .= "                    </div>\n";
        } else {
            $formFields .= "                    <div>\n";
            $formFields .= "                        <label class=\"block text-sm font-semibold text-gray-700 mb-1.5\">$label</label>\n";
            $formFields .= "                        <input v-model=\"form.$name\" type=\"$type\" class=\"w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition\"/>\n";
            $formFields .= "                        <p v-if=\"form.errors.$name\" class=\"text-red-500 text-xs mt-1\">{{ form.errors.$name }}</p>\n";
            $formFields .= "                    </div>\n";
        }
    }

    $content = <<<VUE
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ $prop: Object });
const isEdit = computed(() => !!props.$prop);

const form = useForm({
$initFields});

const submit = () => {
    if (isEdit.value) {
        form.put(\`/manage/$route/\${props.$prop.id}\`);
    } else {
        form.post('/manage/$route');
    }
};
<\/script>

<template>
    <AdminLayout :title="isEdit ? 'Edit $title' : 'Tambah $title'">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <a href="/manage/$route" class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
$formFields                    </div>
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Data') }}
                        </button>
                        <a href="/manage/$route" class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
VUE;
    file_put_contents($file, $content);
    echo "Created: $path\n";
}

// Post Form (complex - with rich editor)
$postFormFile = __DIR__ . '/resources/js/Pages/Admin/Post/Form.vue';
if (!file_exists($postFormFile)) {
    $postContent = <<<'VUE'
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({ post: Object, categories: Array });
const isEdit = computed(() => !!props.post);
const previewUrl = ref(props.post?.image_url || null);

const form = useForm({
    title: props.post?.title || '',
    content: props.post?.content || '',
    category_id: props.post?.category_id || '',
    is_published: props.post?.is_published ?? false,
    image: null,
    _method: undefined,
});

const handleImage = (e) => {
    const f = e.target.files[0];
    if (f) { form.image = f; previewUrl.value = URL.createObjectURL(f); }
};

const submit = () => {
    const url = isEdit.value ? `/manage/posts/${props.post.id}` : '/manage/posts';
    form.post(url, { forceFormData: true });
};
</script>

<template>
    <AdminLayout :title="isEdit ? 'Edit Berita' : 'Tambah Berita'">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="/manage/posts" class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke daftar berita
                </a>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
                        <input v-model="form.title" type="text" placeholder="Judul berita..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                            <select v-model="form.category_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                            <p v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</p>
                        </div>
                        <div class="flex items-center gap-3 pt-6">
                            <button type="button" @click="form.is_published = !form.is_published"
                                :class="form.is_published ? 'bg-green-500' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                <span :class="form.is_published ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform"/>
                            </button>
                            <label class="text-sm font-semibold text-gray-700">{{ form.is_published ? 'Dipublikasikan' : 'Draft' }}</label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Berita <span class="text-red-500">*</span></label>
                        <textarea v-model="form.content" rows="10" placeholder="Tulis isi berita di sini..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-y font-mono"/>
                        <p v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Cover</label>
                        <div v-if="previewUrl" class="mb-3 rounded-xl overflow-hidden h-40 bg-gray-100">
                            <img :src="previewUrl" class="w-full h-full object-cover"/>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer w-fit">
                            <div class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                {{ previewUrl ? 'Ganti Gambar' : 'Pilih Gambar' }}
                            </div>
                            <input type="file" accept="image/*" class="hidden" @change="handleImage"/>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Tambah Berita') }}
                        </button>
                        <a href="/manage/posts" class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
VUE;
    file_put_contents($postFormFile, $postContent);
    echo "Created: Admin/Post/Form\n";
}

// Footer Setting
$footerDir = __DIR__ . '/resources/js/Pages/Admin/FooterSetting';
if (!is_dir($footerDir)) mkdir($footerDir, 0777, true);
$footerFile = $footerDir . '/Index.vue';
if (!file_exists($footerFile)) {
    $footerContent = <<<'VUE'
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ setting: Object });

const form = useForm({
    about_pmi: props.setting?.about_pmi || '',
    address: props.setting?.address || '',
    phone: props.setting?.phone || '',
    email: props.setting?.email || '',
    facebook: props.setting?.facebook || '',
    instagram: props.setting?.instagram || '',
    copyright: props.setting?.copyright || '',
});
</script>

<template>
    <AdminLayout title="Pengaturan Footer">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <p class="text-sm text-gray-500 mb-6">Kelola informasi yang tampil di bagian bawah website.</p>
                <form @submit.prevent="form.post('/manage/footer-setting')" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tentang PMI</label>
                        <textarea v-model="form.about_pmi" rows="3"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-none"/>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                            <input v-model="form.address" type="text"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telepon</label>
                            <input v-model="form.phone" type="text"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                            <input v-model="form.email" type="email"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Copyright</label>
                            <input v-model="form.copyright" type="text"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Facebook URL</label>
                            <input v-model="form.facebook" type="url"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Instagram URL</label>
                            <input v-model="form.instagram" type="url"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition"/>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-gray-100">
                        <button type="submit" :disabled="form.processing"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-semibold text-sm transition">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
VUE;
    file_put_contents($footerFile, $footerContent);
    echo "Created: Admin/FooterSetting/Index\n";
}

echo "\nDone! All Vue admin pages generated.\n";
