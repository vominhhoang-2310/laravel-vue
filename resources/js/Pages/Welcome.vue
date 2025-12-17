<script setup>
import { computed, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import SearchBar from '@/Components/SearchBar.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import MusicButton from '@/Components/MusicButton.vue';
import SideCharacters from '@/Components/SideCharacters.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    stories: {
        type: Array,
        default: () => [],
    },
});

const searchTerm = ref('');
const activeCategory = ref('all');

const filteredStories = computed(() => {
    const term = searchTerm.value.trim().toLowerCase();
    const category = activeCategory.value;

    return props.stories.filter((story) => {
        const haystack = `${story.title ?? ''} ${story.author ?? ''} ${story.published_year ?? ''}`.toLowerCase();
        const matchesSearch = term ? haystack.includes(term) : true;
        const matchesCategory =
            category === 'all'
                ? true
                : (story.category ?? '').toLowerCase() === category.toLowerCase();

        return matchesSearch && matchesCategory;
    });
});

const featuredStories = computed(() => filteredStories.value.slice(0, 16));

const setCategory = (category) => {
    activeCategory.value = activeCategory.value === category ? 'all' : category;
};
</script>

<template>
    <GuestLayout fluid hideNav>
        <div class="welcome-shell relative min-h-screen overflow-x-hidden text-slate-800">

            <div class="fixed left-0 right-0 top-6 z-30 flex justify-center px-4">
                <nav
                    class="glass flex w-full max-w-6xl items-center justify-between rounded-full px-6 py-3 shadow-soft transition">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white shadow-glow"
                            aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-5 w-5"
                                fill="currentColor">
                                <path
                                    d="M0 96C0 60.7 28.7 32 64 32H272V448H64c-35.3 0-64-28.7-64-64V96zM576 96V384c0 35.3-28.7 64-64 64H304V32H512c35.3 0 64 28.7 64 64z" />
                            </svg>
                        </div>
                        <span
                            class="text-2xl font-bold text-transparent bg-gradient-to-r from-indigo-600 to-pink-500 bg-clip-text">
                            Story Time
                        </span>
                    </div>
                    <div class="flex flex-1 items-center justify-end gap-3 pl-4">
                        <SearchBar v-model="searchTerm" placeholder="Search stories..." label="Search stories"
                            class="hidden md:block md:max-w-xs md:flex-1" />
                        <Link v-if="canLogin" :href="route('login')"
                            class="bg-gradient-to-r from-pink-500 to-rose-500 text-white font-semibold py-2 px-6 rounded-full hover:shadow-glow-pink transition-all transform hover:-translate-y-0.5 hidden md:block">
                            Add books
                        </Link>
                        <!-- 
                    <Link v-if="canRegister" :href="route('register')"
                        class="hidden items-center rounded-full bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-2 text-sm font-semibold text-white shadow-glow-pink transition hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-300 sm:inline-flex">
                        Become a contributor
                    </Link>
                    -->
                    </div>
                </nav>
            </div>

            <SideCharacters />


            <main class="relative z-10 mx-auto max-w-7xl px-4 pb-16 pt-28">
                <header class="mx-auto mb-12 max-w-3xl text-center">
                    <span
                        class="mb-4 inline-flex items-center gap-2 rounded-full bg-indigo-100 px-3 py-1 text-sm font-bold tracking-wide text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" viewBox="0 0 576 512"
                            fill="currentColor">
                            <path
                                d="M287.9 17.8L354.7 150l146 21.2c26.2 3.8 36.7 36 17.7 54.6L409.3 343.7l25 145.5c4.5 26.1-23 46-46.4 33.7L288 439.6 188 522.9c-23.4 12.3-50.9-7.6-46.4-33.7l25-145.5-108.1-117.9c-19-18.6-8.5-50.8 17.7-54.6L221.3 150 288.1 17.8c11.7-23.6 45.8-23.9 57.5 0z" />
                        </svg>
                        Popular books
                    </span>
                    <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                        Discover your next
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                            big adventure
                        </span>
                    </h1>
                    <p class="mt-4 text-sm text-slate-600">
                        Browse the latest stories from the community. Sign in to add more, edit details, and keep your
                        library fresh.
                    </p>

                    <!-- Modern Pills Filter -->
                    <div class="flex flex-wrap justify-center gap-3 mt-8">
                        <button type="button" @click="setCategory('Animals')"
                            :aria-pressed="activeCategory === 'Animals'"
                            class="px-6 py-3 rounded-full font-semibold transition-all shadow-sm flex items-center group"
                            :class="activeCategory === 'Animals' ? 'bg-indigo-500 text-white' : 'glass text-slate-600 hover:text-white hover:bg-indigo-500'">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center mr-2 transition-colors"
                                :class="activeCategory === 'Animals' ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-500 group-hover:bg-white/20 group-hover:text-white'">
                                <i class="fa-solid fa-paw"></i>
                            </span>
                            Animals
                        </button>
                        <button type="button" @click="setCategory('Spaces')" :aria-pressed="activeCategory === 'Spaces'"
                            class="px-6 py-3 rounded-full font-semibold transition-all shadow-sm flex items-center group"
                            :class="activeCategory === 'Spaces' ? 'bg-pink-500 text-white' : 'glass text-slate-600 hover:text-white hover:bg-pink-500'">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center mr-2 transition-colors"
                                :class="activeCategory === 'Spaces' ? 'bg-white/20 text-white' : 'bg-pink-100 text-pink-500 group-hover:bg-white/20 group-hover:text-white'">
                                <i class="fa-solid fa-rocket"></i>
                            </span>
                            Spaces
                        </button>
                        <button type="button" @click="setCategory('Life')" :aria-pressed="activeCategory === 'Life'"
                            class="px-6 py-3 rounded-full font-semibold transition-all shadow-sm flex items-center group"
                            :class="activeCategory === 'Life' ? 'bg-emerald-500 text-white' : 'glass text-slate-600 hover:text-white hover:bg-emerald-500'">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center mr-2 transition-colors"
                                :class="activeCategory === 'Life' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-500 group-hover:bg-white/20 group-hover:text-white'">
                                <i class="fa-solid fa-leaf"></i>
                            </span>
                            Life
                        </button>
                    </div>
                </header>

                <section aria-label="Featured stories" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <article v-for="story in featuredStories" :key="story.id"
                        class="glass-card group flex h-full cursor-pointer flex-col overflow-hidden rounded-[1.5rem] p-4 transition focus-within:-translate-y-1 focus-within:shadow-lg">
                        <div
                            class="relative aspect-[4/3] w-full overflow-hidden rounded-[1.25rem] bg-gradient-to-br from-indigo-100 to-white shadow-inner">
                            <img v-if="story.thumbnail_url || story.thumbnail"
                                :src="story.thumbnail_url || story.thumbnail" :alt="`Cover for ${story.title}`"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy" decoding="async" />
                            <div v-else
                                class="flex h-full items-center justify-center text-sm font-semibold text-indigo-500">
                                No image
                            </div>
                            <div
                                class="absolute inset-0 bg-white/10 opacity-0 transition-opacity group-hover:opacity-100">
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col px-2 pb-2 pt-4">
                            <h2 class="text-lg leading-tight text-slate-900 line-clamp-2 text-center comic-relief-bold">
                                {{ story.title }}
                            </h2>
                            <div class="mt-auto flex flex-col items-center gap-3 pt-4">

                                <a v-if="story.pdf_url" :href="story.pdf_url" target="_blank" rel="noreferrer"
                                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400">
                                    Open story
                                </a>
                            </div>
                        </div>
                    </article>

                    <div v-if="!featuredStories.length"
                        class="col-span-full rounded-2xl bg-white/80 p-6 text-center text-sm text-gray-600 shadow-inner">
                        No stories published yet. Sign in to add your first one.
                    </div>
                </section>
            </main>
        </div>
    </GuestLayout>
    <MusicButton />
    <Footer />
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Comic+Relief:wght@400;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Fredoka:wdth,wght@96.2,300..700&display=swap');

.comic-relief-bold {
    font-family: "Comic Relief", system-ui;
    font-weight: 700;
    font-style: normal;
}

.welcome-shell {
    font-family: 'Fredoka', sans-serif;
}

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

/* Glassmorphism Utilities (left global so Tailwind hover:bg overrides correctly) */
:global(.glass) {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.5);
}

.glass-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.glass-card:hover {
    transform: translateY(-8px) scale(1.02);
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
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
