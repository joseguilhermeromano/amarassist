<template>
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</template>

<style scoped>
.spinner {
    width: 40px;
    height: 40px;
    position: relative;
    margin: auto;
}

.double-bounce1,
.double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #621587;
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;
    animation: bounce 2s infinite ease-in-out;
}

.double-bounce2 {
    animation-delay: -1s;
}

@keyframes bounce {
    0%,
    100% {
        transform: scale(0);
    }
    50% {
        transform: scale(1);
    }
}
</style>
