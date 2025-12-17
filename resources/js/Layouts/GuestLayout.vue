<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    fluid: {
        type: Boolean,
        default: false,
    },
    hideNav: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="relative min-h-screen overflow-hidden bg-[#eef2ff] text-slate-800 font-fredoka">

        <Head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
                referrerpolicy="no-referrer" />
        </Head>

        <div class="gradient-bg" aria-hidden="true">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>

        <div v-if="!hideNav" class="fixed left-0 right-0 top-6 z-30 flex justify-center px-4">
            <nav
                class="glass flex w-full max-w-5xl items-center justify-between rounded-full px-6 py-3 shadow-soft transition">
                <Link :href="route('welcome')" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white shadow-glow"
                        aria-hidden="true">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <span
                        class="text-2xl font-bold text-transparent bg-gradient-to-r from-indigo-600 to-pink-500 bg-clip-text">
                        Story Time
                    </span>
                </Link>
                <Link :href="route('welcome')"
                    class="hidden items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-indigo-600 shadow-sm transition hover:bg-indigo-50 hover:text-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400 sm:inline-flex">
                    Back to home
                </Link>
            </nav>
        </div>

        <div class="relative z-10 flex min-h-screen"
            :class="fluid ? 'flex-col items-stretch px-0 pt-6 pb-0' : 'items-center justify-center px-4 py-12'">
            <div v-if="!fluid"
                class="w-full max-w-lg rounded-2xl bg-white/90 p-8 shadow-soft ring-1 ring-white/60 backdrop-blur">
                <slot />
            </div>
            <div v-else class="w-full">
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Fredoka:wdth,wght@96.2,300..700&display=swap');

.gradient-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    background: #eef2ff;
}

.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.6;
}

.blob-1 {
    top: -10%;
    left: -10%;
    width: 50vw;
    height: 50vw;
    background: #c7d2fe;
    animation: blob 7s infinite;
}

.blob-2 {
    top: 20%;
    right: -20%;
    width: 40vw;
    height: 40vw;
    background: #fbcfe8;
    animation: blob 7s infinite 2s;
}

.blob-3 {
    bottom: -20%;
    left: 20%;
    width: 50vw;
    height: 50vw;
    background: #d1fae5;
    animation: blob 7s infinite 4s;
}

.glass {
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.6);
}

.shadow-soft {
    box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
}

.shadow-glow {
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
}

.font-fredoka {
    font-family: 'Fredoka', sans-serif;
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }

    33% {
        transform: translate(30px, -50px) scale(1.1);
    }

    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }

    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
</style>
