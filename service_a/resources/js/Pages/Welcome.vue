<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>

    <Head title="Welcome" />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col justify-center items-center text-center px-6">
        <!-- Top Right Nav -->
        <!-- <div v-if="canLogin" class="absolute top-6 right-6 space-x-4">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow">
            Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg shadow">
                Register
                </Link>
            </template>
        </div> -->

        <!-- Hero Section -->
        <div class="mt-20">
            <h1 class="text-5xl font-bold text-gray-800 dark:text-white mb-4">Welcome to Integration Service</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-xl mx-auto">
                This service provides product data and connects to the user service to enable integrated
                service-to-service
                communication.
            </p>


        </div>

        <!-- Info Card -->
        <!-- Action Card -->
<div v-if="canLogin && !$page.props.auth.user" class="mt-20 grid grid-cols-1 sm:grid-cols-2 gap-6 w-full max-w-3xl">
    <div class="bg-gray-800/60 backdrop-blur p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-semibold text-white mb-4">Already have an account?</h2>
        <p class="text-gray-300 mb-6">Login to manage your products and orders.</p>
        <Link
            :href="route('login')"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow"
        >
            Log In
        </Link>
    </div>
    
    <div v-if="canRegister" class="bg-gray-800/60 backdrop-blur p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-semibold text-white mb-4">New here?</h2>
        <p class="text-gray-300 mb-6">Register now and start exploring our services.</p>
        <Link
            :href="route('register')"
            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow"
        >
            Register
        </Link>
    </div>
</div>

    </div>
</template>
