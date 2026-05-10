<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login/admin', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login Admin" />

    <div class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center mb-4 text-red-600">
                    <svg class="w-16 h-16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 11h-5V6h-4v5H5v4h5v5h4v-5h5v-4z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Login Admin</h2>
                <p class="mt-2 text-gray-600">Portal Manajemen PMI Wonosobo</p>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" v-model="form.email" type="email" autocomplete="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-600 focus:border-red-600 sm:text-sm"
                        placeholder="admin@pmi.com">
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" v-model="form.password" type="password" autocomplete="current-password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-600 focus:border-red-600 sm:text-sm"
                        placeholder="••••••••">
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" v-model="form.remember" type="checkbox"
                            class="h-4 w-4 text-red-600 focus:ring-red-600 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">Ingat saya</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition"
                        :disabled="form.processing">
                    {{ form.processing ? 'Memproses...' : 'Login' }}
                </button>

                <!-- Error Messages -->
                <div v-if="Object.keys(form.errors).length > 0" class="rounded-lg bg-red-50 p-4 border border-red-200">
                    <div class="text-sm text-red-700">
                        <p v-for="(error, key) in form.errors" :key="key">• {{ error }}</p>
                    </div>
                </div>
            </form>

            <!-- Back Link -->
            <div class="text-center">
                <Link href="/" class="text-sm text-red-600 hover:text-red-700">
                    ← Kembali ke Beranda
                </Link>
            </div>


        </div>
    </div>
</template>
