<template>
    <main v-if="userIsLoggedIn">
        <div>
            <vNavBar />
        </div>
        <div>
            <RouterView />
        </div>
    </main>
    <div class="auth-wrapper" v-else>
        <vAuth />
    </div>
</template>

<script>
import { RouterView } from 'vue-router'
import vNavBar from './components/vNavBar.vue'
import vAuth from './components/vAuth.vue'
import { useGeneralStore } from './components/store/generalStore'
import { useUserStore } from './components/store/userStore'

export default {
    components: { vNavBar, vAuth },
    data() {
        return {
            userIsLoggedIn: false
        }
    },
    created() {
        useGeneralStore().getOrdersFromServer()

        if (localStorage.hasOwnProperty('userData')) {
            const userData = localStorage.getItem('userData')
            if (userData.length) {
                this.userIsLoggedIn = true
            }
        }

    },
}
</script>

<style>
main {
    display: grid;
    grid-template-columns: 1fr 5fr;
    gap: 10px;
    max-width: 1300px;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
}
.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
}
</style>./components/store/generakStore