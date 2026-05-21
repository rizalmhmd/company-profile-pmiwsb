<script setup>
import JadwalDokter from '@/Pages/Donor/JadwalDokter.vue';

defineProps({
    pageData: Object,
});
</script>

<template>
    <JadwalDokter :pageData="pageData" />
</template>
