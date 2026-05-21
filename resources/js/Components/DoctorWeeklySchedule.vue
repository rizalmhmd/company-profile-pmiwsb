<script setup>
import { computed } from 'vue';

const props = defineProps({
    groups: {
        type: Array,
        default: () => [],
    },
    days: {
        type: Array,
        default: () => [
            { key: 'senin', label: 'Senin' },
            { key: 'selasa', label: 'Selasa' },
            { key: 'rabu', label: 'Rabu' },
            { key: 'kamis', label: 'Kamis' },
            { key: 'jumat', label: 'Jumat' },
            { key: 'sabtu', label: 'Sabtu' },
        ],
    },
});

const normalizedGroups = computed(() => {
    return (props.groups || []).map((g) => ({
        title: g?.title ?? '',
        rows: (g?.rows || []).map((r) => ({
            doctor: r?.doctor ?? '',
            times: r?.times ?? {},
        })),
    }));
});

function cellTimes(row, dayKey) {
    const raw = row?.times?.[dayKey];
    if (!raw) return [];
    if (Array.isArray(raw)) return raw.filter(Boolean);
    return [String(raw)].filter(Boolean);
}
</script>

<template>
    <div class="space-y-10">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-600">
                Jadwal dapat berubah sewaktu-waktu. Silakan konfirmasi ke Klinik Pratama PMI.
            </div>
            <div class="flex items-center gap-3 text-xs font-semibold text-gray-600">
                <span class="inline-flex items-center gap-2">
                    <span class="h-3 w-3 rounded bg-emerald-100 ring-1 ring-emerald-200"></span>
                    Praktik
                </span>
                <span class="inline-flex items-center gap-2">
                    <span class="h-3 w-3 rounded bg-rose-100 ring-1 ring-rose-200"></span>
                    Tidak praktik
                </span>
            </div>
        </div>

        <section v-for="(group, gIdx) in normalizedGroups" :key="gIdx" class="space-y-4">
            <div class="inline-flex items-center gap-3">
                <h2 class="text-lg sm:text-xl font-black tracking-tight text-gray-900">{{ group.title }}</h2>
                <div class="h-px w-10 bg-red-600/60"></div>
            </div>

            <!-- Desktop / Tablet -->
            <div class="hidden lg:block">
                <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900 text-white">
                                    <th class="px-6 py-5 text-xs font-black uppercase tracking-widest min-w-[260px]">Dokter</th>
                                    <th v-for="d in days" :key="d.key" class="px-6 py-5 text-xs font-black uppercase tracking-widest min-w-[160px]">
                                        {{ d.label }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="(row, rIdx) in group.rows" :key="rIdx" class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-gray-900">{{ row.doctor }}</div>
                                    </td>

                                    <td
                                        v-for="d in days"
                                        :key="d.key"
                                        class="px-6 py-5 align-top"
                                        :class="cellTimes(row, d.key).length ? 'bg-emerald-50/70' : 'bg-rose-50/70'"
                                    >
                                        <div v-if="cellTimes(row, d.key).length" class="space-y-1">
                                            <div v-for="(t, tIdx) in cellTimes(row, d.key)" :key="tIdx" class="text-sm font-semibold text-gray-900">
                                                {{ t }}
                                            </div>
                                        </div>
                                        <div v-else class="text-sm font-semibold text-rose-700">—</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mobile -->
            <div class="lg:hidden space-y-4">
                <div v-for="(row, rIdx) in group.rows" :key="rIdx" class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="px-6 pt-6">
                        <div class="text-base font-black text-gray-900">{{ row.doctor }}</div>
                    </div>
                    <div class="px-6 pb-6 pt-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div
                                v-for="d in days"
                                :key="d.key"
                                class="rounded-2xl border p-4"
                                :class="cellTimes(row, d.key).length ? 'border-emerald-200 bg-emerald-50/60' : 'border-rose-200 bg-rose-50/60'"
                            >
                                <div class="text-xs font-black uppercase tracking-widest text-gray-700">{{ d.label }}</div>
                                <div v-if="cellTimes(row, d.key).length" class="mt-2 space-y-1">
                                    <div v-for="(t, tIdx) in cellTimes(row, d.key)" :key="tIdx" class="text-sm font-semibold text-gray-900">
                                        {{ t }}
                                    </div>
                                </div>
                                <div v-else class="mt-2 text-sm font-semibold text-rose-700">—</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

