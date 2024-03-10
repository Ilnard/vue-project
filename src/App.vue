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
import { useOrdersStore } from './components/store/ordersStore'

export default {
    components: { vNavBar },
    created() {
        useOrdersStore().getOrdersFromServer()
    },
}
</script>

<style>
main {
    display: grid;
    grid-template-columns: 1fr 5fr;
    gap: 10px;
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
}
</style>