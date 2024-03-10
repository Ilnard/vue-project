<template>
    <div class="loader-wrapper">
        <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g>
                <path fill="none" d="M0 0h24v24H0z" />
                <path d="M18.364 5.636L16.95 7.05A7 7 0 1 0 19 12h2a9 9 0 1 1-2.636-6.364z" />
            </g>
        </svg>

    </div>
</template>

<style>
.loader-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 200px;
}

.loader {
    width: 100px;
    height: 100px;
    animation-name: loader;
    animation-duration: 1.5s;
    animation-timing-function: ease;
    animation-iteration-count: infinite;
}

@keyframes loader {
    0% {

        transform: rotate(0);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
