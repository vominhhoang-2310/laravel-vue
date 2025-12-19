<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
    <GuestLayout>
        <div class="relative z-10 mx-auto max-w-5xl px-4 p-12 flex-1">
            <section class="rounded-3xl bg-white/90 p-8 shadow-soft ring-1 ring-white/70 backdrop-blur">
                <h1 class="text-center text-4xl font-extrabold text-indigo-600 pb-1">404</h1>
                <h2 class="text-center text-2xl font-semibold text-gray-900 pb-2">{{ t('common.notFound') }}</h2>
                <p class="text-center text-gray-600 whitespace-nowrap text-[11px] min-[360px]:text-xs sm:text-sm">
                    {{
                        t('common.notFoundMessage') }} <i class="fa-regular fa-face-frown"></i></p>
            </section>
        </div>
    </GuestLayout>

</template>
