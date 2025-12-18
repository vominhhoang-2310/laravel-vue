<script setup>
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
    <footer
        class="sticky bottom-0 z-20 flex flex-wrap items-center justify-between gap-4 bg-white/90 px-6 py-4 text-sm text-slate-700 shadow-soft ring-1 ring-white/60 backdrop-blur max-[459px]:flex-col max-[459px]:items-center max-[459px]:justify-center">
        <div class="flex items-center gap-3 text-slate-800 max-[459px]:justify-center max-[459px]:w-full max-[459px]:justify-center">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white shadow-glow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-4 w-4" fill="currentColor">
                    <path
                        d="M0 96C0 60.7 28.7 32 64 32H272V448H64c-35.3 0-64-28.7-64-64V96zM576 96V384c0 35.3-28.7 64-64 64H304V32H512c35.3 0 64 28.7 64 64z" />
                </svg>
            </span>
            <div class="leading-tight">
                <p class="text-xs uppercase tracking-wide text-slate-500">Story Time</p>
                <p class="text-sm font-bold text-slate-800">{{ t('footer.tagline') }}</p>
            </div>
        </div>

        <div
            class="flex flex-wrap items-center gap-5 text-sm text-slate-700 max-[459px]:w-full max-[459px]:justify-center max-[459px]:text-center">
            <Link
                class="hover:text-indigo-600 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400"
                :href="route('about')">
                {{ t('footer.about') }}
            </Link>
            <Link
                class="hover:text-indigo-600 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400"
                :href="route('contact')">
                {{ t('footer.contact') }}
            </Link>
        </div>
    </footer>
</template>
