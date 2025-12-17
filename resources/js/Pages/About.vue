<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Footer from '@/Components/Footer.vue';
</script>

<template>
    <GuestLayout fluid>

        <Head title="About" />

        <main class="relative z-10 mx-auto max-w-5xl px-4 pt-28">
            <section class="rounded-3xl bg-white/90 p-8 shadow-soft ring-1 ring-white/70 backdrop-blur">
                <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p
                            class="mb-2 inline-flex items-center gap-2 rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-indigo-700">
                            About
                        </p>
                        <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                            Welcome to <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">Story
                                Time</span>
                        </h1>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-pink-500 text-white shadow-glow"
                        aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-7 w-7"
                            fill="currentColor">
                            <path
                                d="M0 96C0 60.7 28.7 32 64 32H272V448H64c-35.3 0-64-28.7-64-64V96zM576 96V384c0 35.3-28.7 64-64 64H304V32H512c35.3 0 64-28.7 64 64z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-6 text-slate-700 leading-relaxed">
                    <p>
                        Welcome to Story Time — a warm, playful digital library built for parents and children (ages
                        3–8) to enjoy stories together. It’s a place where you can store, organize, and revisit your
                        favorite children’s books in one simple space, whether you’re reading at bedtime, during quiet
                        time, or squeezing in a quick story before heading out the door.
                    </p>
                    <p>
                        This app started as a personal project, but it’s driven by something bigger: my belief in the
                        power of early literacy. I care deeply about children’s education, and I wanted to create a tool
                        that encourages reading as a daily habit. Research and real life both show that early reading
                        helps children build vocabulary, comprehension, attention, empathy, and imagination — and when
                        parents read with kids, that shared time becomes a strong foundation for learning and emotional
                        connection.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2">
                    <article class="rounded-2xl bg-indigo-50 p-6 shadow-inner ring-1 ring-indigo-100">
                        <h2 class="text-xl font-semibold text-indigo-900">For kids</h2>
                        <ul class="mt-3 space-y-2 text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-indigo-500"></span>
                                <span>Large, friendly typography and bright visuals.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-indigo-500"></span>
                                <span>Easy-to-understand layout that makes picking a book feel fun and
                                    independent.</span>
                            </li>
                        </ul>
                    </article>
                    <article class="rounded-2xl bg-emerald-50 p-6 shadow-inner ring-1 ring-emerald-100">
                        <h2 class="text-xl font-semibold text-emerald-900">For parents</h2>
                        <ul class="mt-3 space-y-2 text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Clean, modern interface with simple organization.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Quickly find the right story for bedtime, quiet time, or on-the-go reading.</span>
                            </li>
                        </ul>
                    </article>
                </div>

                <div class="mt-10 space-y-4 text-slate-700 leading-relaxed">
                    <p>
                        You’ll also notice the design choices are intentional. The app aims for high contrast, clear
                        spacing, and big tap targets to support accessibility and reduce frustration for little hands.
                        The overall experience is meant to feel welcoming and calm — a friendly “bookshelf” rather than
                        a complicated app.
                    </p>
                    <p>
                        At its heart, Story Time is about community. I’m building it because I want to contribute
                        something meaningful: a safe, delightful reading space that supports families and helps children
                        fall in love with books. If it makes story time easier, helps a child discover a new favorite
                        character, or gives parents a simple way to keep stories organized, then it’s already doing what
                        I hoped it would do.
                    </p>
                    <p class="font-semibold text-slate-900">
                        Thank you for being part of this journey — and happy reading!
                    </p>
                </div>
            </section>
        </main>
    </GuestLayout>
    <div class="relative">
        <Footer />
        <div class="pointer-events-none absolute inset-x-0 -top-8 z-30 overflow-hidden">
            <div class="cat-runner" aria-hidden="true">
                <i class="fa-solid fa-cat cat text-indigo-500"></i>
            </div>
        </div>
    </div>
</template>

<style scoped>
.cat-runner {
    position: relative;
    width: 100%;
    height: 48px;
}

.cat {
    display: inline-block;
    font-size: 34px;
    animation: run-across 12s linear infinite;
}

@keyframes run-across {
    0% {
        transform: translateX(-80px) rotate(-4deg);
    }

    20% {
        transform: translateX(10%) translateY(-2px) rotate(4deg);
    }

    50% {
        transform: translateX(50%) translateY(2px) rotate(-2deg);
    }

    80% {
        transform: translateX(90%) translateY(-3px) rotate(3deg);
    }

    100% {
        transform: translateX(calc(100% + 80px)) rotate(0deg);
    }
}
</style>
