<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    src: {
        type: String,
        default: '../public/audio/music.mp3',
    },
    positionClass: {
        type: String,
        default: 'fixed bottom-24 right-6',
    },
    volume: {
        type: Number,
        default: 0.35,
    },
});

const audio = ref(null);
const isPlaying = ref(false);

const ensureAudio = () => {
    if (!audio.value) {
        audio.value = new Audio(props.src);
        audio.value.loop = true;
        audio.value.volume = props.volume;
        audio.value.muted = false;
    }
    return audio.value;
};

const playAudio = async () => {
    const player = ensureAudio();
    try {
        await player.play();
        isPlaying.value = true;
    } catch (error) {
        // Autoplay might be blocked; keep state false so the button can be used.
        isPlaying.value = false;
    }
};

const toggleAudio = async () => {
    const player = ensureAudio();
    if (isPlaying.value) {
        player.pause();
        isPlaying.value = false;
        return;
    }
    await playAudio();
};

onMounted(() => {
    playAudio();
});

onBeforeUnmount(() => {
    if (audio.value) {
        audio.value.pause();
        audio.value = null;
    }
});
</script>

<template>
    <button type="button" @click="toggleAudio" :class="[
        positionClass,
        'z-40 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-pink-500 text-white shadow-glow transition hover:scale-105 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400',
    ]" :aria-pressed="isPlaying" :aria-label="isPlaying ? 'Pause background music' : 'Play background music'">
        <i v-if="isPlaying" class="fa-solid fa-music text-lg"></i>
        <i v-else class="fa-solid fa-volume-xmark text-lg"></i>
    </button>
</template>
