<template>
    <div class="navbar parent-div">
        <div class="navbar__group">
        </div>
        <div class="navbar__group">
            <RouterLink to="/" class="navbar__link">Заказы</RouterLink>
            <RouterLink to="/organization" class="navbar__link">Организация</RouterLink>
        </div>
        <div class="navbar__group">
            <button class="navbar__link red-bg" @click="logout()">Выйти</button>
        </div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
    data() {
        return {
            name: 'Алексей'
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('userData')
            window.location.reload()
        }
    }
}
</script>

<style scoped>
.navbar__group {
    display: flex;
    flex-direction: column;
    padding: 10px 0;
    gap: 10px;
    border-bottom: 1px solid var(--grey-lv2);
}

.navbar__group:first-child {
    padding: 0 0 10px 0;
}

.navbar__group:last-child {
    border-bottom: none;
    padding: 10px 0 0 0;
}

.navbar__link {
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    background: none;
    transition: background-color .1s linear, color .1s linear;
}

.navbar__link:hover {
    background-color: var(--grey-lv1);
}

.navbar__link.red-bg {
    color: var(--danger);
    border: 1px solid var(--danger);
}
.navbar__link.red-bg:hover {
    color: white;
    background-color: var(--danger);
}
</style>