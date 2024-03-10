<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Заказы</h2>
            <RouterLink to="/addorder" class="viewer-header__link">Добавить заказ</RouterLink>
        </header>
        <vLoader v-if="!loaded"/>
        <table v-if="loaded" class="orders">
            <thead>
                <tr>
                    <td class="orders__cell">Заявка</td>
                    <td class="orders__cell">Заказчик</td>
                    <td class="orders__cell">Название заказа</td>
                    <td class="orders__cell">Дата и время</td>
                    <td class="orders__cell">Сумма</td>
                    <td class="orders__cell">Оплачено</td>
                    <td class="orders__cell">Статус</td>
                </tr>
            </thead>
            <tbody>
                <tr class="order" v-for="order in getOrdersFromStoreComp" :key="order.id">
                    <td class="orders__cell"><RouterLink :to="{name: 'order', params: {number: order.number}}">{{ order.number }}</RouterLink></td>
                    <td class="orders__cell">{{ order.client }}</td>
                    <td class="orders__cell">{{ order.title }}</td>
                    <td class="orders__cell">{{ order.datetime }}</td>
                    <td class="orders__cell">{{ order.pay }}</td>
                    <td class="orders__cell">{{ order.paid }}</td>
                    <td class="orders__cell">{{ order.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'
import { useOrdersStore } from '../store/ordersStore'
import vLoader from './service_vLoader.vue'

export default {
    components: { vLoader },
    data() {
        return {
            loaded: false,
        }
    },
    computed: {
        getOrdersFromStoreComp: () => useOrdersStore().getOrdersFromStore
    },
    watch: {
        getOrdersFromStoreComp() {
            this.loaded = true
        }
    },
    created() {
        if (this.getOrdersFromStoreComp) this.loaded = true
    }
}
</script>

<style scoped>
.orders {
    border-spacing: 0;
    width: 100%;
}
.orders__cell {
    padding: 12px;
}
.order:hover {
    outline: 1px solid var(--grey-lv2);
}
.order:nth-child(odd) {
    background-color: #E2E2E2;
}
</style>