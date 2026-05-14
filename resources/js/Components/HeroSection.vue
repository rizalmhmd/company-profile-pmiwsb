<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

const props = defineProps({
    title: String,
    subtitle: String,
    description: String,
    imageUrl: String,
});

const page = usePage();
const heroSliders = computed(() => page.props.heroSliders || []);
const isHome = computed(() => page.url === '/');

const currentSlide = ref(0);
const lastSlide = ref(0);
const direction = ref('next');
let slideInterval;

const nextSlide = () => {
    if (heroSliders.value.length > 1) {
        direction.value = 'next';
        lastSlide.value = currentSlide.value;
        currentSlide.value = (currentSlide.value + 1) % heroSliders.value.length;
    }
};

const setSlide = (index) => {
    if (index !== currentSlide.value) {
        direction.value = index > currentSlide.value ? 'next' : 'prev';
        lastSlide.value = currentSlide.value;
        currentSlide.value = index;
        resetInterval();
    }
};

const resetInterval = () => {
    clearInterval(slideInterval);
    if (heroSliders.value.length > 1 && !props.imageUrl) {
        slideInterval = setInterval(nextSlide, 5000);
    }
};

onMounted(() => {
    resetInterval();
});

onUnmounted(() => {
    clearInterval(slideInterval);
});

// Fallback image if no sliders are active
const defaultImage = "https://images.unsplash.com/photo-1584432810601-6c7f27d2362b?q=80&w=2070&auto=format&fit=crop";

const getImageUrl = (path) => {
    if (props.imageUrl) return props.imageUrl;
    return path ? (path.startsWith('http') ? path : `/storage/${path}`) : defaultImage;
};
</script>

<template>
    <section class="relative h-[450px] sm:h-[600px] bg-gray-900 overflow-hidden">
        <!-- Single Background if imageUrl is provided -->
        <div v-if="imageUrl" class="absolute inset-0 w-full h-full bg-cover bg-center" :style="`background-image: url('${getImageUrl(imageUrl)}');` ">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 sm:from-black/70 to-transparent"></div>
            <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                <div class="max-w-2xl text-white">
                    <span v-if="subtitle" class="inline-block px-2 py-0.5 sm:px-3 sm:py-1 bg-red-600 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded mb-3 sm:mb-4">{{ subtitle }}</span>
                    <h2 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">{{ title || 'PMI Wonosobo' }}</h2>
                    <p class="text-sm sm:text-lg text-gray-200 mb-6 sm:mb-8 leading-relaxed line-clamp-3 sm:line-clamp-none">
                        {{ description || 'Menjadi lembaga kemanusiaan yang paling dicintai dan dipercaya di Kabupaten Wonosobo melalui pelayanan yang profesional dan responsif.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <Link href="/donor/jadwal" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center shadow-lg text-sm sm:text-base">Cek Jadwal Donor</Link>
                        <Link href="/markas/pertolongan-pertama" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center text-sm sm:text-base">Layanan Kesehatan</Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Backgrounds & Dynamic Text (Only if imageUrl is not provided) -->
        <div v-else-if="heroSliders.length > 0" class="relative h-full w-full">
            <transition name="slide">
                <div :key="currentSlide"
                    class="absolute inset-0 w-full h-full bg-cover bg-center slide-item"
                    :style="`background-image: url('${getImageUrl(heroSliders[currentSlide]?.image_path)}');` ">
                    
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 sm:from-black/70 to-transparent"></div>
                    
                    <!-- Slide Content -->
                    <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                        <div class="max-w-2xl text-white">
                            <span v-if="heroSliders[currentSlide]?.subtitle" class="inline-block px-2 py-0.5 sm:px-3 sm:py-1 bg-red-600 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded mb-3 sm:mb-4">{{ heroSliders[currentSlide]?.subtitle }}</span>
                            <span v-else class="inline-block px-2 py-0.5 sm:px-3 sm:py-1 bg-red-600 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded mb-3 sm:mb-4">PMI Wonosobo</span>
                            
                            <h2 v-if="heroSliders[currentSlide]?.title" class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">{{ heroSliders[currentSlide]?.title }}</h2>
                            <h2 v-else class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">Bersama Untuk <span class="text-red-600">Kemanusiaan</span></h2>
                            
                            <p v-if="heroSliders[currentSlide]?.description" class="text-sm sm:text-lg text-gray-200 mb-6 sm:mb-8 leading-relaxed line-clamp-3 sm:line-clamp-none">
                                {{ heroSliders[currentSlide]?.description }}
                            </p>
                            <p v-else class="text-sm sm:text-lg text-gray-200 mb-6 sm:mb-8 leading-relaxed line-clamp-3 sm:line-clamp-none">
                                Menjadi lembaga kemanusiaan yang paling dicintai dan dipercaya di Kabupaten Wonosobo melalui pelayanan yang profesional dan responsif.
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <Link v-if="isHome" href="#donor" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center shadow-lg text-sm sm:text-base">Cek Jadwal Donor</Link>
                                <Link v-else href="/donor/jadwal" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center shadow-lg text-sm sm:text-base">Cek Jadwal Donor</Link>
                                
                                <Link v-if="isHome" href="#pelayanan" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center text-sm sm:text-base">Layanan Kesehatan</Link>
                                <Link v-else href="/markas/pertolongan-pertama" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center text-sm sm:text-base">Layanan Kesehatan</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <!-- Fallback Default Background (Only if no imageUrl and no sliders) -->
        <div v-else class="absolute inset-0 bg-cover bg-center" :style="`background-image: url('${getImageUrl(null)}');` ">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 sm:from-black/70 to-transparent"></div>
            <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                <div class="max-w-2xl text-white">
                    <span class="inline-block px-2 py-0.5 sm:px-3 sm:py-1 bg-red-600 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded mb-3 sm:mb-4">PMI Wonosobo</span>
                    <h2 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">{{ title || 'Bersama Untuk Kemanusiaan' }}</h2>
                    <p class="text-sm sm:text-lg text-gray-200 mb-6 sm:mb-8 leading-relaxed line-clamp-3 sm:line-clamp-none">
                        {{ description || 'Menjadi lembaga kemanusiaan yang paling dicintai dan dipercaya di Kabupaten Wonosobo melalui pelayanan yang profesional dan responsif.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <Link href="/donor/jadwal" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center shadow-lg text-sm sm:text-base">Cek Jadwal Donor</Link>
                        <Link href="/markas/pertolongan-pertama" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 sm:px-8 sm:py-4 rounded-lg font-bold transition text-center text-sm sm:text-base">Layanan Kesehatan</Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Points / Dots Indicators -->
        <div v-if="heroSliders.length > 1 && !imageUrl" class="absolute bottom-6 left-0 right-0 flex justify-center gap-2 z-20">
            <button v-for="(slider, index) in heroSliders" :key="'dot-'+index" 
                @click="setSlide(index)"
                class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none"
                :class="index === currentSlide ? 'bg-red-600 w-8' : 'bg-white/50 hover:bg-white/80'">
            </button>
        </div>
    </section>
</template>

<style scoped>
.slide-item {
    will-change: transform, opacity;
}

.slide-enter-active,
.slide-leave-active {
    transition: transform 1.2s cubic-bezier(0.645, 0.045, 0.355, 1), opacity 1.2s ease;
}

.slide-enter-from {
    transform: translateX(100%);
    opacity: 0;
    z-index: 20;
}

.slide-enter-to {
    transform: translateX(0);
    opacity: 1;
    z-index: 20;
}

.slide-leave-from {
    transform: translateX(0);
    opacity: 1;
    z-index: 10;
}

.slide-leave-to {
    transform: translateX(-100%);
    opacity: 0;
    z-index: 10;
}
</style>
