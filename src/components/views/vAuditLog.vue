<template>
    <div class="parent-div">
        <!-- <vLoader /> -->
        <div class="order">
            <header class="viewer-header">
                <h2 class="viewer__title">Журнал аудита</h2>
            </header>
            <table class="table">
            <thead>
                <tr>
                    <td class="cell">ФИО</td>
                    <td class="cell">Роль</td>
                    <td class="cell">Дата</td>
                    <td class="cell">Действие</td>
                </tr>
            </thead>
            <tbody>
                <tr class="row">
                    <td class="cell">Имя Фамилия Отчество</td>
                    <td class="cell">admin</td>
                    <td class="cell">20.04.2024</td>
                    <td class="cell">Ред. заказ <RouterLink class="order-number" :to="'/orders/' + 123">123</RouterLink><br>
                        <div class="audit-log__action">Стоимость: 500000 => 750000</div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <!-- <div v-if="serverMessage.message" class="server-message" :class="[serverMessage.color]">{{ serverMessage.message }}</div> -->
    </div>
</template>

<script>
import { storeToRefs } from 'pinia'
import { useGeneralStore } from '../store/generalStore'
import vLoader from './service_vLoader.vue'

export default {
    setup() {
        const generalStore = useGeneralStore()
        const { getOrder } = storeToRefs(generalStore)

        return { generalStore, getOrder }
    },
    components: { vLoader },
    data() {
        return {
            orderNumber: this.$route.params.number,
            serverMessage: {
                message: '',
                color: 'green'
            }
        }
    },
}
</script>

<style>
    .order-number {
        text-decoration: underline;
    }
</style>