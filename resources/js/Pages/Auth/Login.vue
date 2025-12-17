<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div class="relative overflow-hidden rounded-2xl bg-white/90 p-8 shadow-soft ring-1 ring-white/60">
            <div
                class="absolute -top-10 -right-10 h-24 w-24 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 blur-3xl">
            </div>
            <div
                class="absolute -bottom-10 -left-8 h-28 w-28 rounded-full bg-gradient-to-br from-indigo-200 to-blue-200 blur-3xl">
            </div>

            <div class="relative">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white shadow-glow"
                        aria-hidden="true">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-indigo-500 font-bold">Welcome back</p>
                        <h1 class="text-xl font-bold text-slate-900">Log in to Story Time</h1>
                    </div>
                </div>

                <div v-if="status" class="mb-4 rounded-md bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ status }}
                </div>

                <form class="space-y-5" @submit.prevent="submit">
                    <div class="space-y-1">
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email"
                            class="mt-1 block w-full rounded-xl border border-white/60 bg-white/80 px-4 py-3 shadow-inner focus:border-indigo-300 focus:ring-2 focus:ring-indigo-200"
                            v-model="form.email" required autofocus autocomplete="username" />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>

                    <div class="space-y-1">
                        <InputLabel for="password" value="Password" />
                        <TextInput id="password" type="password"
                            class="mt-1 block w-full rounded-xl border border-white/60 bg-white/80 px-4 py-3 shadow-inner focus:border-indigo-300 focus:ring-2 focus:ring-indigo-200"
                            v-model="form.password" required autocomplete="current-password" />
                        <InputError class="mt-1" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <label class="flex items-center gap-2">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span>Remember me</span>
                        </label>
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="font-semibold text-indigo-600 underline-offset-4 hover:text-indigo-800">
                            Forgot password?
                        </Link>
                    </div>

                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400"
                        :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Log in
                    </button>

                    <!--<p class="text-center text-xs text-slate-500">
                        New here?
                        <Link :href="route('register')" class="font-semibold text-indigo-600 hover:text-indigo-800">
                            Create an account
                        </Link>
                    </p> -->
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
