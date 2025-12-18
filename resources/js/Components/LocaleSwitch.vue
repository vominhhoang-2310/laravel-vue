<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const current = computed(() => page.props.locale?.current ?? 'en');
const available = computed(() => page.props.locale?.available ?? ['en', 'vn']);

const makeUrl = (locale) => {
    const url = new URL(page.url, window.location.origin);
    url.searchParams.set('lang', locale);
    return url.pathname + url.search;
};
</script>

<template>
    <div class="flex items-center gap-2 text-sm">
        <div class="flex items-center gap-2">
            <Link v-for="locale in available" :key="locale" :href="makeUrl(locale)" preserve-scroll preserve-state
                class="rounded-full px-3 py-1 text-xs font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400"
                :class="current === locale ? 'bg-indigo-500 text-white shadow-sm' : 'bg-white/70 text-slate-700 hover:bg-indigo-50'">
                {{ locale === 'en' ? "EN" : "VN" }}
            </Link>
        </div>
    </div>
</template>
