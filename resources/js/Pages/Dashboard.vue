<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            weekly: 0,
        }),
    },
    weeklyStories: {
        type: Array,
        default: () => [],
    },
});

const showWeekly = ref(false);
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-4 sm:grid-cols-2">
                    <article class="flex items-center gap-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100"
                        role="status" aria-label="Total stories">
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-700"
                            aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="h-6 w-6"
                                fill="currentColor">
                                <path
                                    d="M0 64C0 28.7 28.7 0 64 0H320c35.3 0 64 28.7 64 64V400c0 26.5-21.5 48-48 48H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H336c26.5 0 48 21.5 48 48V448c0-17.7-14.3-32-32-32H64c-35.3 0-64-28.7-64-64V64z" />
                            </svg>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold uppercase tracking-wide text-gray-600">Total
                                stories</span>
                            <span class="text-3xl font-bold text-gray-900" aria-live="polite">
                                {{ stats.total }}
                            </span>
                        </div>
                    </article>

                    <article
                        class="flex cursor-pointer items-center gap-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400"
                        role="status" aria-label="New stories this week" tabindex="0"
                        @click="showWeekly = !showWeekly" @keyup.enter="showWeekly = !showWeekly"
                        @keyup.space.prevent="showWeekly = !showWeekly">
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-700"
                            aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="h-6 w-6"
                                fill="currentColor">
                                <path
                                    d="M214.6 73.4c-12.5-12.5-32.8-12.5-45.3 0l-96 96c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 173.3V368c0 17.7 14.3 32 32 32s32-14.3 32-32V173.3l41.4 41.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-96-96z" />
                            </svg>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold uppercase tracking-wide text-gray-600">
                                New this week
                            </span>
                            <span class="text-3xl font-bold text-gray-900" aria-live="polite">
                                {{ stats.weekly }}
                            </span>
                            <span class="text-xs text-emerald-700">
                                {{ showWeekly ? 'Hide list' : 'Show list' }}
                            </span>
                        </div>
                    </article>
                </div>

                <section v-show="showWeekly"
                    class="mt-4 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100"
                    aria-label="Books added this week">
                    <header class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-gray-700">
                                Added this week
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ weeklyStories.length }} {{ weeklyStories.length === 1 ? 'book' : 'books' }}
                            </p>
                        </div>
                        <button type="button"
                            class="text-sm font-semibold text-emerald-700 hover:text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-400"
                            @click="showWeekly = false">
                            Close
                        </button>
                    </header>
                    <div v-if="weeklyStories.length === 0" class="px-4 py-6 text-sm text-gray-600">
                        No books added this week.
                    </div>
                    <ul v-else class="divide-y divide-gray-100">
                        <li v-for="story in weeklyStories" :key="story.id" class="flex items-center gap-4 px-4 py-3">
                            <img v-if="story.thumbnail_url || story.thumbnail" :src="story.thumbnail_url || story.thumbnail"
                                :alt="`Cover for ${story.title}`" class="h-14 w-14 rounded-md object-cover" loading="lazy"
                                decoding="async" />
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ story.title }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ story.author }} · {{ story.published_year }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
