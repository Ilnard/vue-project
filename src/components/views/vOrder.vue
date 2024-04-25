<template>
    <div class="parent-div">
        <vLoader v-if="!getOrder.isLoaded" />
        <div v-if="getOrder.isLoaded" class="order">
            <header class="viewer-header">
                <h2 class="viewer__title">{{ getOrder.order.number }}</h2>
                <div class="order__date">{{ getOrder.order.datetime }}</div>
            </header>
            <div class="order__client">{{ getOrder.order.client }}</div>
            <div class="order__title">{{ getOrder.order.title }}</div>
            <div class="order__pay">{{ getOrder.order.pay }} руб <span class="order__paid">({{ getOrder.order.hours }} ч.)</span></div>
            <div class="order__status" :class="{active: getOrder.order.status == 'В работе', completed: getOrder.order.status == 'Завершена'}">{{ getOrder.order.status }}</div>
            <div class="order-members applied">
                <h3 class="order-members__title">Привязанные к объекту:</h3>
                <ul class="order-members__list">
                    <template v-for="member in getOrder.order.attachmentList">
                        <li v-if="member.allowed == 1" class="order-members__member">{{ member.surname + ' ' + member.name + ' ' + member.patronymic }} <span class="order-members__member-position">({{ member.position }})</span></li>
                    </template>
                </ul>
            </div>
            <div class="order-members applied">
                <h3 class="order-members__title">Недопущенные к объекту:</h3>
                <ul class="order-members__list">
                    <template v-for="member in getOrder.order.attachmentList">
                        <li v-if="member.allowed == 0" class="order-members__member">{{ member.surname + ' ' + member.name + ' ' + member.patronymic }} <span class="order-members__member-position">({{ member.position }})</span></li>
                    </template>
                </ul>
            </div>
        </div>
        <div v-if="getOrder.isLoaded" class="control-bar">
            <button class="btn save-btn" @click="addOrderFunc()">{{ buttonSaveContent }}</button>
            <RouterLink :to="'/order/edit?mode=edit&number=' + getOrder.order.number" class="btn edit-btn">Редактировать</RouterLink>
        </div>
        <div v-if="serverMessage.message" class="server-message" :class="[serverMessage.color]">{{ serverMessage.message }}</div>
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
        const { getOrder } = storeToRefs(generalStore)

        return { generalStore, getOrder }
    },
    components: { vLoader },
    data() {
        return {
            orderNumber: this.$route.params.number,
            buttonSaveContent: 'Сохранить',
            serverMessage: {
                message: '',
                color: 'green'
            }
        }
    },
    created() {
        this.generalStore.setOrderViewData(this.orderNumber)
    }
}
</script>

<style scoped>
    .order {
        font-size: 16px;
    }
    .order__client, .order__title {
        font-size: 1em;
        margin-bottom: 10px;
    }
    .order__pay {
        font-size: 1em;
        margin-bottom: 20px;
    }
    .order__paid {
        font-size: 1em;
    }
    .order__status {
        font-size: 1em;
        margin-bottom: 20px;
    }
    .order__status.active {
        color: rgb(255, 166, 0);
    }
    .order__status.completed {
        color: var(--safety);
    }
    .order-members {
        margin-bottom: 20px;
    }
    .order-members__title {
        font-size: 16px;
        margin-bottom: 10px;
    }
    .order-members__member {
        margin-left: 20px;
    }
    .order-members__member-position {
        color: var(--grey-lv3);
    }
</style>