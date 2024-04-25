<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Заказы</h2>
            <RouterLink to="/order/edit" class="viewer-header__link">Добавить заказ</RouterLink>
        </header>
        <vLoader v-if="!getOrders.isLoaded" />
        <table v-if="getOrders.isLoaded && getOrders.status && getOrders.orders.length" class="table">
            <thead>
                <tr>
                    <td class="cell">Заявка</td>
                    <td class="cell">Заказчик</td>
                    <td class="cell">Название заказа</td>
                    <td class="cell">Дата и время</td>
                    <td class="cell">Часы</td>
                    <td class="cell">Оп./час</td>
                    <td class="cell">Итого</td>
                    <td class="cell">Статус</td>
                </tr>
            </thead>
            <tbody>
                <tr class="row" v-for="order in getOrders.orders" :key="order.id">
                    <td class="cell">
                        <RouterLink :to="{ name: 'order', params: { number: order.number } }">{{ order.number }}
                        </RouterLink>
                    </td>
                    <td class="cell">{{ order.client }}</td>
                    <td class="cell">{{ order.title }}</td>
                    <td class="cell">{{ order.datetimeVisual }}</td>
                    <td class="cell">{{ order.hours }}</td>
                    <td class="cell">{{ order.pay }}</td>
                    <td class="cell">{{ order.hours * order.pay }}</td>
                    <td class="cell">{{ order.status }}</td>
                </tr>
            </tbody>
        </table>
        <div v-else-if="getOrders.isLoaded" class="service-message red">{{ getOrders.errorMessage }}</div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useGeneralStore } from '../store/generalStore'
import vLoader from './service_vLoader.vue'

export default {
    setup() {
        const generalStore = useGeneralStore()
        const { getOrders } = storeToRefs(generalStore)
        return { getOrders }
    },
    components: { vLoader },
}
</script>