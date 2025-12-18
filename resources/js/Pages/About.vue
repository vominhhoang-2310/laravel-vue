<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Footer from '@/Components/Footer.vue';
import MusicButton from '@/Components/MusicButton.vue';
import SideCharacters from '@/Components/SideCharacters.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
    <GuestLayout fluid>

        <Head :title="t('about.eyebrow')" />
        <div class="flex min-h-screen flex-col">
            <SideCharacters />
            <div class="relative z-10 mx-auto max-w-5xl px-4 pt-[160px] pb-12 flex-1">
                <section class="rounded-3xl bg-white/90 p-8 shadow-soft ring-1 ring-white/70 backdrop-blur">
                    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p
                                class="mb-2 inline-flex items-center gap-2 rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-indigo-700">
                                {{ t('about.eyebrow') }}
                            </p>
                            <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                                {{ t('about.title') }}
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
                            {{ t('about.introOne') }}
                        </p>
                        <p>
                            {{ t('about.introTwo') }}
                        </p>
                    </div>

                    <div class="mt-10 grid gap-6 md:grid-cols-2">
                        <article class="rounded-2xl bg-indigo-50 p-6 shadow-inner ring-1 ring-indigo-100">
                            <h2 class="text-center text-xl font-semibold text-indigo-900">{{ t('about.forKids') }}</h2>
                            <ul class="mt-3 space-y-2 text-slate-700">
                                <li class="flex items-start gap-2">
                                    <span class="mt-[9px] h-2 w-2 shrink-0 rounded-full bg-indigo-500"></span>
                                    <span>{{ t('about.kidsPointOne') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-[9px] h-2 w-2 shrink-0 rounded-full bg-indigo-500"></span>
                                    <span>{{ t('about.kidsPointTwo') }}</span>
                                </li>
                            </ul>
                        </article>
                        <article class="rounded-2xl bg-emerald-50 p-6 shadow-inner ring-1 ring-emerald-100">
                            <h2 class="text-center text-xl font-semibold text-emerald-900">{{ t('about.forParents') }}
                            </h2>
                            <ul class="mt-3 space-y-2 text-slate-700">
                                <li class="flex items-start gap-2">
                                    <span class="mt-[9px] h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                                    <span>{{ t('about.parentsPointOne') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-[9px] h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                                    <span>{{ t('about.parentsPointTwo') }}</span>
                                </li>
                            </ul>
                        </article>
                    </div>

                    <div class="mt-10 space-y-4 text-slate-700 leading-relaxed">
                        <p>
                            {{ t('about.closingOne') }}
                        </p>
                        <p>
                            {{ t('about.closingTwo') }}
                        </p>
                        <p class="font-semibold text-slate-900">
                            {{ t('about.closingThanks') }} <i class="fa-solid fa-heart"></i>
                        </p>
                    </div>
                </section>
            </div>
            <Footer />
        </div>
        <MusicButton />
    </GuestLayout>
</template>
