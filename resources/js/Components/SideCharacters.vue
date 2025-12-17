<template>
    <!-- Left Side Characters (Integrated look) -->
    <div class="side-character left-8 hidden lg:block animate-float opacity-80">
        <div class="relative">
            <div class="absolute inset-0 bg-blue-400 blur-3xl opacity-20 rounded-full"></div>
            <div class="text-[140px] text-indigo-400/80 drop-shadow-lg relative z-10">
                <i class="fa-solid fa-hippo"></i>
            </div>
            <div
                class="absolute -top-4 -right-12 glass px-4 py-2 rounded-2xl rounded-bl-none shadow-sm animate-bounce text-sm font-bold text-indigo-600">
                Hi there! 👋
            </div>
        </div>
        <div class="text-[80px] text-emerald-400/80 mt-8 ml-8 drop-shadow-md animate-float-delayed">
            <i class="fa-solid fa-frog"></i>
        </div>
    </div>

    <!-- Right Side Characters -->
    <div class="side-character right-8 hidden lg:block animate-float-delayed opacity-80">
        <div class="relative">
            <div class="absolute inset-0 bg-pink-400 blur-3xl opacity-20 rounded-full"></div>
            <div class="text-[140px] text-pink-400/80 drop-shadow-lg relative z-10 transform -scale-x-100">
                <i class="fa-solid fa-dragon"></i>
            </div>
        </div>
        <div class="text-[90px] text-amber-400/80 mt-6 mr-10 text-right drop-shadow-md animate-float">
            <i class="fa-solid fa-robot"></i>
        </div>
    </div>
</template>

<style scoped>
.side-character {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    z-index: 0;
    pointer-events: none;
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-20px);
    }
}

@keyframes float-delayed {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-15px);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 6s ease-in-out 3s infinite;
}
</style>
