<template>
    <main>
        <div>
            <vNavBar/>
        </div>
        <div>
            <RouterView />
        </div>
    </main>
</template>

<script>
import { RouterView } from 'vue-router'
import vNavBar from './components/vNavBar.vue'
import { useGeneralStore } from './components/store/generalStore'

export default {
    components: { vNavBar },
    created() {
        useGeneralStore().getOrdersFromServer()
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
</style>./components/store/generakStore