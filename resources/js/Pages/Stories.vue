<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SavedStories from '@/Components/SavedStories.vue';
import TextInput from '@/Components/TextInput.vue';
import SearchBar from '@/Components/SearchBar.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    stories: {
        type: Array,
        default: () => [],
    },
});

const categories = ['Animals', 'Life', 'Spaces'];

const form = useForm({
    title: '',
    author: '',
    pdf_link: null,
    description: '',
    published_year: '',
    thumbnail: null,
    category: categories[0],
});

const deleteForm = useForm({});
const activeStoryId = ref(null);
const liveMessage = ref('');
const thumbnailInput = ref(null);
const thumbnailPreview = ref(null);
const pdfInput = ref(null);
const pdfPreview = ref(null);
const page = usePage();

watch(
    () => page.props.flash?.success,
    (message) => {
        if (message) {
            liveMessage.value = message;
        }
    },
    { immediate: true }
);

const searchTerm = ref('');

const filteredStories = computed(() => {
    const term = searchTerm.value.trim().toLowerCase();

    return props.stories.filter((story) => {
        const haystack = `${story.title ?? ''} ${story.author ?? ''} ${story.published_year ?? ''} ${story.description ?? ''}`.toLowerCase();
        return term ? haystack.includes(term) : true;
    });
});

const isEditing = computed(() => activeStoryId.value !== null);

const resetThumbnailInput = (preview = null) => {
    thumbnailPreview.value = preview;
    form.thumbnail = null;
    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
    }
};

const resetPdfInput = (preview = null) => {
    pdfPreview.value = preview;
    form.pdf_link = null;
    if (pdfInput.value) {
        pdfInput.value.value = '';
    }
};

const startCreate = () => {
    activeStoryId.value = null;
    form.reset();
    form.clearErrors();
    resetThumbnailInput();
    resetPdfInput();
};

const selectStory = (story) => {
    activeStoryId.value = story.id;
    form.clearErrors();
    form.title = story.title ?? '';
    form.author = story.author ?? '';
    form.description = story.description ?? '';
    form.published_year = story.published_year?.toString() ?? '';
    form.category = story.category ?? categories[0];
    resetThumbnailInput(story.thumbnail_url ?? story.thumbnail ?? null);
    resetPdfInput(story.pdf_url ?? story.pdf_link ?? null);
};

const handleFileChange = (event) => {
    const [file] = event.target.files;
    form.thumbnail = file ?? null;
    thumbnailPreview.value = file ? URL.createObjectURL(file) : thumbnailPreview.value;
};

const handlePdfChange = (event) => {
    const [file] = event.target.files;
    form.pdf_link = file ?? null;
    pdfPreview.value = file ? file.name : pdfPreview.value;
};

const submit = () => {
    if (isEditing.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(route('stories.update', activeStoryId.value), {
            preserveScroll: true,
            forceFormData: true,
            onFinish: () => {
                form.transform((data) => data);
            },
            onSuccess: () => {
                liveMessage.value = 'Story updated.';
                startCreate();
            },
        });
        return;
    }

    form.post(route('stories.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            liveMessage.value = 'Story added.';
            startCreate();
        },
    });
};

const confirmDelete = (storyId) => {
    if (deleteForm.processing || !confirm('Delete this story?')) {
        return;
    }

    deleteForm.delete(route('stories.destroy', storyId), {
        preserveScroll: true,
        onSuccess: () => {
            if (activeStoryId.value === storyId) {
                startCreate();
            }
            liveMessage.value = 'Story removed.';
        },
    });
};

</script>

<template>

    <Head title="Stories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>

                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Story generator
                    </h2>
                    <p class="text-sm text-gray-600">
                        Build a library of stories. Select a card on the right to edit or delete.
                    </p>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:grid-cols-2">
                    <section class="rounded-lg bg-white p-6 shadow sm:p-8 w-full max-w-3xl mx-auto">
                        <div class="flex flex-col gap-2">
                            <p class="text-sm font-semibold uppercase tracking-wide text-indigo-700">
                                Story generator
                            </p>
                            <p class="text-sm text-gray-600">
                                Keep fields short and descriptive. Upload a thumbnail image from your device and link to
                                the
                                PDF.
                            </p>
                        </div>

                        <div v-if="liveMessage"
                            class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                            role="status" aria-live="polite">
                            {{ liveMessage }}
                        </div>

                        <div class="sr-only" aria-live="polite">
                            {{ isEditing ? 'Editing story' : 'Creating story' }}
                        </div>

                        <form class="mt-6 grid w-full max-w-full gap-5 sm:max-w-2xl" @submit.prevent="submit">
                            <div class="grid gap-1.5">
                                <InputLabel for="title" value="Title" />
                                <TextInput id="title" v-model="form.title" type="text" required maxlength="255"
                                    autocomplete="off" class="w-full" />
                                <InputError :message="form.errors.title" />
                            </div>

                            <div class="grid gap-1.5">
                                <InputLabel for="author" value="Author" />
                                <TextInput id="author" v-model="form.author" type="text" required maxlength="255"
                                    autocomplete="off" class="w-full" />
                                <InputError :message="form.errors.author" />
                            </div>

                            <div class="grid gap-1.5">
                                <InputLabel for="published_year" value="Published year" />
                                <TextInput id="published_year" v-model="form.published_year" type="number"
                                    inputmode="numeric" min="0" max="2100" required class="w-full" />
                                <InputError :message="form.errors.published_year" />
                            </div>

                            <div class="grid gap-1.5">
                                <InputLabel for="category" value="Category" />
                                <select id="category" v-model="form.category" name="category" required
                                    class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option disabled value="">Select a category</option>
                                    <option v-for="option in categories" :key="option" :value="option">
                                        {{ option }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.category" />
                            </div>

                            <div class="grid gap-1.5">
                                <InputLabel for="pdf_link" value="Upload PDF" />
                                <input id="pdf_link" ref="pdfInput" type="file" name="pdf_link" accept="application/pdf"
                                    :required="!isEditing"
                                    class="block w-full cursor-pointer rounded-md border border-dashed border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                                    aria-describedby="pdf_help" @change="handlePdfChange" />
                                <div v-if="pdfPreview"
                                    class="flex items-center gap-3 rounded-md border border-gray-200 bg-gray-50 p-3 text-sm text-gray-700">
                                    <span class="font-semibold">PDF:</span>
                                    <span class="break-all">{{ pdfPreview }}</span>
                                </div>
                                <InputError :message="form.errors.pdf_link" />
                            </div>

                            <div class="grid gap-1.5">
                                <InputLabel for="thumbnail" value="Upload thumbnail" />
                                <input id="thumbnail" ref="thumbnailInput" type="file" name="thumbnail" accept="image/*"
                                    :required="!isEditing"
                                    class="block w-full cursor-pointer rounded-md border border-dashed border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                                    aria-describedby="thumbnail_help" @change="handleFileChange" />
                                <div v-if="thumbnailPreview"
                                    class="flex items-center gap-3 rounded-md border border-gray-200 bg-gray-50 p-3">
                                    <img :src="thumbnailPreview"
                                        :alt="form.title ? `Preview for ${form.title}` : 'Thumbnail preview'"
                                        class="h-16 w-16 rounded-md object-cover" />
                                    <div class="text-sm text-gray-700">
                                        <p class="font-semibold">Selected thumbnail</p>
                                        <p class="text-xs text-gray-500">Shown on the story card.</p>
                                    </div>
                                </div>
                                <InputError :message="form.errors.thumbnail" />
                            </div>

                            <div class="grid gap-1.5">
                                <InputLabel for="description" value="Description" />
                                <textarea id="description" v-model="form.description" rows="4"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                <InputError :message="form.errors.description" />
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <PrimaryButton type="submit" :disabled="form.processing" :class="[
                                    'disabled:opacity-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500',
                                ]">
                                    {{ isEditing ? 'Update story' : 'Add story' }}
                                </PrimaryButton>
                                <SecondaryButton
                                    v-show="form.title || form.author || form.published_year || form.pdf_link || form.thumbnail || form.description"
                                    type="button" :disabled="form.processing" @click="startCreate" :class="[
                                        'inline-flex items-center rounded-md border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-red-700 transition hover:bg-red-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 disabled:opacity-50',
                                    ]">
                                    Cancel
                                </SecondaryButton>
                            </div>
                        </form>
                    </section>

                    <div class="space-y-4">
                        <SearchBar v-model="searchTerm" placeholder="Search stories..." />

                        <SavedStories :stories="filteredStories" :active-story-id="activeStoryId"
                            :processing="form.processing || deleteForm.processing" @select="selectStory"
                            @delete="confirmDelete" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
