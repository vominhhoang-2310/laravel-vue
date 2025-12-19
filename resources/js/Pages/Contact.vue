<script setup>
import { computed, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Footer from '@/Components/Footer.vue';
import MusicButton from '@/Components/MusicButton.vue';
import SideCharacters from '@/Components/SideCharacters.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const mailSubjects = computed(() => [
    t('contact.form.subjects.inquiry'),
    t('contact.form.subjects.feedback'),
    t('contact.form.subjects.bug'),
    t('contact.form.subjects.feature'),
    t('contact.form.subjects.contribute'),
]);

const form = useForm({
    name: '',
    email: '',
    subject: mailSubjects.value[0],
    message: '',
    attachment: null,
});

const fileInput = ref(null);
const page = usePage();

const successMessage = computed(() => page.props.flash?.success);

const handleFileChange = (event) => {
    const [file] = event.target.files;
    form.attachment = file ?? null;
};

const submit = () => {
    form.post(route('contact.send'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset('name', 'email', 'subject', 'message', 'attachment');
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
    });
};
</script>

<template>
    <GuestLayout fluid>

        <Head :title="t('contact.eyebrow')" />
        <div class="flex min-h-screen flex-col">
            <SideCharacters />
            <div class="relative z-10 mx-auto max-w-4xl px-4 pt-[160px] pb-12 flex-1">
                <section class="rounded-3xl bg-white/90 p-8 shadow-soft ring-1 ring-white/70 backdrop-blur space-y-6">
                    <div>
                        <p
                            class="mb-3 inline-flex items-center gap-2 rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-indigo-700">
                            {{ t('contact.eyebrow') }}
                        </p>
                        <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl mb-8">
                            {{ t('contact.title') }}
                        </h1>
                    </div>

                    <div class="space-y-4 text-base leading-relaxed text-slate-700">
                        <p>
                            {{ t('contact.p1') }}
                        </p>
                        <p>
                            {{ t('contact.p2') }}
                        </p>
                        <p>
                            {{ t('contact.p3') }}
                        </p>
                    </div>

                    <form class="mt-4 space-y-4" @submit.prevent="submit">
                        <div v-if="successMessage"
                            class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 text-center"
                            role="status">
                            {{ successMessage }}
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-1 text-sm font-semibold text-slate-800">
                                {{ t('contact.form.name') }}
                                <input v-model="form.name" required type="text"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 mt-1">
                                <span v-if="form.errors.name" class="text-xs text-red-600">{{ form.errors.name }}</span>
                            </label>
                            <label class="space-y-1 text-sm font-semibold text-slate-800">
                                Email
                                <input v-model="form.email" required type="email"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 mt-1">
                                <span v-if="form.errors.email" class="text-xs text-red-600">{{ form.errors.email
                                    }}</span>
                            </label>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-1 text-sm font-semibold text-slate-800">
                                {{ t('contact.form.subject') }}
                                <select v-model="form.subject" required
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 mt-1">
                                    <option v-for="subject in mailSubjects" :key="subject" :value="subject">
                                        {{ subject }}
                                    </option>
                                </select>
                                <span v-if="form.errors.subject" class="text-xs text-red-600">{{ form.errors.subject
                                    }}</span>
                            </label>
                            <label class="space-y-1 text-sm font-semibold text-slate-800">
                                {{ t('contact.form.upload') }}
                                <input ref="fileInput" type="file" accept=".pdf,.png,.jpg,.jpeg,.gif"
                                    @change="handleFileChange"
                                    class="block w-full text-sm text-slate-700 file:mr-3 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 mt-1" />
                                <span v-if="form.errors.attachment" class="text-xs text-red-600">{{
                                    form.errors.attachment }}</span>
                            </label>
                        </div>

                        <label class="space-y-1 text-sm font-semibold text-slate-800 block">
                            {{ t('contact.form.message') }}
                            <textarea v-model="form.message" required rows="5"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 mt-1"></textarea>
                            <span v-if="form.errors.message" class="text-xs text-red-600">{{ form.errors.message
                                }}</span>
                        </label>

                        <div class="flex justify-center">
                            <button type="submit" :disabled="form.processing"
                                class="inline-flex items-center gap-2 rounded-full bg-indigo-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400 disabled:opacity-50">
                                <span v-if="form.processing"
                                    class="h-3 w-3 animate-spin rounded-full border-2 border-white/70 border-t-transparent"></span>
                                {{ t('contact.form.send') }}
                            </button>
                        </div>
                    </form>
                </section>
            </div>
            <Footer />
        </div>
        <MusicButton />
    </GuestLayout>
</template>
