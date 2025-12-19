<script setup>
import { useI18n } from 'vue-i18n';

const props = defineProps({
    stories: {
        type: Array,
        default: () => [],
    },
    activeStoryId: {
        type: Number,
        default: null,
    },
    processing: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['select', 'delete']);
const { t } = useI18n();
</script>

<template>
    <section class="rounded-lg bg-white p-4 shadow sm:p-6">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-indigo-700">
                    {{ t('savedStories.title') }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ t('savedStories.subtitle') }}
                </p>
            </div>
            <span
                class="inline-flex items-center justify-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-700 shadow-sm ring-1 ring-indigo-100"
                aria-label="Total saved stories">
                {{ t('savedStories.count', { count: props.stories.length }) }}
            </span>
        </div>

        <div v-if="!props.stories.length"
            class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center text-sm text-gray-600">
            {{ t('savedStories.empty') }}
        </div>

        <ul v-else
            class="mt-4 max-h-[calc(8*5.5rem)] overflow-y-auto divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white/80 pr-1"
            aria-label="Saved stories">
            <li v-for="story in props.stories" :key="story.id" :class="[
                'flex items-center gap-4 px-3 py-3 sm:px-4 transition hover:bg-indigo-50/60',
                props.activeStoryId === story.id ? 'bg-indigo-50/80 ring-1 ring-indigo-100' : '',
            ]" tabindex="0" role="button" :aria-pressed="props.activeStoryId === story.id"
                @click="emit('select', story)" @keyup.enter="emit('select', story)"
                @keyup.space.prevent="emit('select', story)">
                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100 ring-1 ring-gray-200">
                    <img v-if="story.thumbnail_url || story.thumbnail" :src="story.thumbnail_url || story.thumbnail"
                        :alt="`Cover for ${story.title}`" class="h-full w-full object-cover" loading="lazy"
                        decoding="async" />
                    <div v-else
                        class="flex h-full w-full items-center justify-center text-xs font-semibold text-gray-400">
                        {{ t('savedStories.noImage') }}
                    </div>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-gray-900 truncate">{{ story.title }}</p>
                    <p class="text-sm text-gray-600 truncate">
                        {{ story.author }} · {{ story.published_year }}
                    </p>
                </div>

                <div class="flex flex-shrink-0 items-center gap-[20px]">
                    <a class="text-sm font-semibold text-indigo-700 hover:text-indigo-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400"
                        :href="story.pdf_url || story.pdf_link" target="_blank" rel="noreferrer" @click.stop>
                        {{ t('savedStories.openPdf') }}
                    </a>
                    <button type="button"
                        class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-red-700 transition hover:bg-red-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 disabled:opacity-50"
                        :disabled="props.processing" @click.stop="emit('delete', story.id)">
                        {{ t('savedStories.delete') }}
                    </button>
                </div>
            </li>
        </ul>
    </section>
</template>
