<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';

const props = defineProps({
    pageData: Object,
});

const structure = {
    name: "Kepala Klinik",
    children: [
        {
            name: "Kepala Bagian Administrasi dan Tata kelola",
            children: [
                {
                    name: "Ka. Subbag. Keuangan",
                    items: ["Pj. Kasir", "Pj. Anggaran", "Pj. Jasa Pelayanan dan Jasa Medis"]
                },
                {
                    name: "Ka. Subbag. Umum dan Kepegawaian",
                    items: ["Pj. Umum", "Pj. Kepegawaian"]
                },
                {
                    name: "Ka. Subbag. Sarana Prasarana dan Logistik",
                    items: ["Pj. Sarana dan Prasarana", "Pj. Logistik"]
                }
            ]
        },
        {
            name: "Kepala Bidang Pelayanan Klinis",
            children: [
                { name: "Ka. Subbid Pelayanan Pendaftaran" },
                { name: "Ka. Subbid Pelayanan Umum" },
                { 
                    name: "Ka. Subbid Pelayanan KIA-KB",
                    items: ["Pj. Pelayanan KIA", "Pj. Pelayanan KB"]
                },
                { name: "Ka. Subbid Pelayanan Gigi" },
                { 
                    name: "Ka. Subbid Pelayanan Kefarmasian",
                    items: ["Pj. Ruang Pelayanan Obat", "Pj. Gudang Obat dan Bahan habis Pakai"]
                },
                { 
                    name: "Ka. Subbid Pelayanan Kamar Bersalin dan Ruang Nifas",
                    items: ["Pj. Pelayanan Kamar Bersalin", "Pj. Pelayanan Ruang Nifas"]
                },
                { 
                    name: "Ka. Subbid Pelayanan Penunjang",
                    items: ["Pj. Pelayanan Rekam Medis", "Pj. Pelayanan Laboratorium", "Pj. Pelayanan Radiologi", "Pj. Pelayanan Operasional Ambulans"]
                }
            ]
        },
        {
            name: "Kelompok Fungsional",
            items: [
                "Dokter Umum", "Dokter Gigi", "Perawat", "Perawat Gigi", 
                "Bidan", "Apoteker", "Asisten Apoteker", "Sanitarian", "Sopir"
            ]
        }
    ]
};
</script>

<template>
    <Head title="Struktur Organisasi" />
    <MainLayout>
        <HeroSection 
            :title="pageData?.title || 'Struktur Organisasi Markas'" 
            subtitle="Markas PMI" 
            :description="pageData?.content?.hero_description || 'Manajemen operasional dan tim pendukung pelayanan kemanusiaan PMI Kabupaten Wonosobo.'"
        />

        <!-- Featured Image Section -->
        <div v-if="pageData?.image_url" class="container mx-auto px-4 -mt-20 relative z-30 mb-8">
            <div class="max-w-5xl mx-auto rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                <img :src="pageData.image_url" class="w-full h-[300px] sm:h-[450px] object-cover" alt="Featured Image">
            </div>
        </div>

        <div class="bg-slate-100 py-32 overflow-x-auto min-h-screen">
            <div class="min-w-[2500px] flex justify-center px-20">
                <div class="tree">
                    <ul>
                        <li>
                            <div class="node-root">
                                <div class="org-box root">{{ structure.name }}</div>
                            </div>
                            
                            <!-- Main Junction Branching -->
                            <ul>
                                <!-- LEFT BRANCH: Administrasi -->
                                <li class="branch-col">
                                    <div class="org-box branch">{{ structure.children[0].name }}</div>
                                    <ul>
                                        <li v-for="sub in structure.children[0].children" :key="sub.name">
                                            <div class="org-box sub">{{ sub.name }}</div>
                                            <div class="pj-container mt-4">
                                                <div v-for="item in sub.items" :key="item" class="pj-node">
                                                    {{ item }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

                                <!-- MIDDLE BRANCH: Pelayanan Klinis (Vertical Trunk) -->
                                <li class="branch-col trunk-branch">
                                    <div class="org-box branch">{{ structure.children[1].name }}</div>
                                    <ul class="wide-branch">
                                        <li v-for="sub in structure.children[1].children" :key="sub.name">
                                            <div class="org-box mini">{{ sub.name }}</div>
                                            <div v-if="sub.items" class="pj-container mt-4">
                                                <div v-for="item in sub.items" :key="item" class="pj-node mini">
                                                    {{ item }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

                                <!-- RIGHT BRANCH: Fungsional (Dashed) -->
                                <li class="branch-col dashed-branch">
                                    <div class="org-box branch dashed">{{ structure.children[2].name }}</div>
                                    <div class="fungsional-list mt-10">
                                        <div class="bg-white border-2 border-gray-300 p-6 rounded shadow-sm">
                                            <div v-for="item in structure.children[2].items" :key="item" class="text-xs font-bold text-gray-700 border-b border-gray-100 py-2 last:border-0">
                                                {{ item }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
/* Tree Layout Core */
.tree * { margin: 0; padding: 0; }
.tree ul {
    padding-top: 60px; 
    position: relative;
    display: flex;
    justify-content: center;
}
.tree li {
    float: left; 
    text-align: center;
    list-style-type: none;
    position: relative;
    padding: 60px 15px 0 15px;
}

/* Horizontal Lines */
.tree li::before, .tree li::after {
    content: '';
    position: absolute; 
    top: 0; 
    right: 50%;
    border-top: 2px solid #1f2937;
    width: 50%; 
    height: 60px;
}
.tree li::after {
    right: auto; 
    left: 50%;
    border-left: 2px solid #1f2937;
}

/* Connector adjustments for single/edge items */
.tree li:only-child::after, .tree li:only-child::before {
    display: none;
}
.tree li:only-child { padding-top: 0; }
.tree li:first-child::before, .tree li:last-child::after {
    border: 0 none;
}
.tree li:last-child::before {
    border-right: 2px solid #1f2937;
    border-radius: 0 5px 0 0;
}
.tree li:first-child::after {
    border-radius: 5px 0 0 0;
}

/* Vertical lines from parent to child group */
.tree ul ul::before {
    content: '';
    position: absolute; 
    top: 0; 
    left: 50%;
    border-left: 2px solid #1f2937;
    width: 0; 
    height: 60px;
}

/* Trunk Branch Special (Straight down) */
.trunk-branch::before, .trunk-branch::after {
    border-top: 2px solid #1f2937;
}

/* Dashed Branch Connector (Garis Putus-putus) */
.dashed-branch::before {
    border-top: 2px dashed #4b5563 !important;
}
.dashed-branch::after {
    border-left: 2px dashed #4b5563 !important;
    border-top: 2px dashed #4b5563 !important;
}

/* Ensure the sibling connecting to the dashed branch also uses a dashed line for its half of the connector */
.trunk-branch::after {
    border-top: 2px dashed #4b5563 !important;
}

/* Node Styling */
.org-box {
    display: inline-block;
    background: white;
    border: 2px solid #1f2937;
    padding: 1rem;
    border-radius: 4px;
    font-weight: 800;
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    position: relative;
    z-index: 5;
}
.org-box.root { min-width: 300px; font-size: 1.5rem; padding: 1.5rem; }
.org-box.branch { min-width: 260px; font-size: 1.1rem; }
.org-box.sub { min-width: 180px; font-size: 0.9rem; min-height: 80px; display: flex; align-items: center; justify-content: center; }
.org-box.mini { min-width: 120px; font-size: 0.7rem; min-height: 70px; display: flex; align-items: center; justify-content: center; line-height: 1.2; }
.org-box.dashed { border-style: dashed; border-color: #4b5563; color: #4b5563; }

/* PJ Lists (Vertical under node) */
.pj-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding-left: 20px;
    border-left: 2px solid #1f2937;
    margin-left: 50%;
    transform: translateX(-1px);
}
.pj-node {
    background: white;
    border: 1.5px solid #4b5563;
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    font-weight: 700;
    border-radius: 4px;
    position: relative;
    width: 160px;
    text-align: left;
}
.pj-node::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 50%;
    width: 20px;
    height: 2px;
    background: #1f2937;
}
.pj-node.mini { width: 130px; font-size: 0.65rem; padding: 0.4rem 0.6rem; }
.pj-node.mini::before { left: -18px; width: 16px; }

/* Custom Scrollbar */
.overflow-x-auto::-webkit-scrollbar { height: 16px; }
.overflow-x-auto::-webkit-scrollbar-track { background: #f1f5f9; }
.overflow-x-auto::-webkit-scrollbar-thumb { background: #64748b; border-radius: 8px; border: 4px solid #f1f5f9; }
</style>