<script setup>
import { computed } from 'vue';

const modelValue = defineModel({ type: String, default: '' });

const props = defineProps({
    placeholder: {
        type: String,
        default: 'Search',
    },
    label: {
        type: String,
        default: 'Search',
    },
    class: {
        type: String,
        default: '',
    },
});

const inputId = computed(() => (props.label ? props.label.toLowerCase().replace(/\s+/g, '-') : 'search'));
</script>

<template>
    <div :class="['relative', props.class]">
        <label class="sr-only" :for="inputId">{{ label }}</label>
        <input :id="inputId" v-model="modelValue" type="search" :placeholder="placeholder" :aria-label="label"
            class="w-full rounded-[20px] border border-gray-300 bg-white px-4 py-2 pr-10 text-sm text-slate-700 shadow-sm transition focus:border-indigo-300 focus:bg-white focus:ring-2 focus:ring-indigo-200" />
        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 512 512" fill="currentColor"
                aria-hidden="true">
                <path
                    d="M500.3 443.7 383.8 327.2c28.4-34.9 45.5-79.5 45.5-128.1C429.3 89.6 339.7 0 229.6 0S29.9 89.6 29.9 199.1 119.5 398.3 229.6 398.3c48.6 0 93.2-17.1 128.1-45.5l116.5 116.5c8.2 8.2 21.5 8.2 29.7 0l-3.6-3.6c8.1-8.2 8.1-21.5-.1-29.6zM229.6 357.6c-87.3 0-158.5-71.1-158.5-158.5S142.3 40.6 229.6 40.6 388.1 111.8 388.1 199.1 316.9 357.6 229.6 357.6z" />
            </svg>
        </span>
    </div>
</template>
