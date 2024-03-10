<template>
    <div class="parent-div">
        <vLoader v-if="!loaded" />
        <div v-if="loaded" class="order">
            <header class="viewer-header">
                <h2 class="viewer__title">{{ getOrderFromComp.number }}</h2>
                <div class="order__date">{{ getOrderFromComp.datetime }}</div>
            </header>
            <div class="order__client">{{ getOrderFromComp.client }}</div>
            <div class="order__title">{{ getOrderFromComp.title }}</div>
            <div class="order__pay">{{ getOrderFromComp.pay }} <span>({{ getOrderFromComp.paid }})</span></div>
            <div class="order__status">{{ getOrderFromComp.status }}</div>
        </div>
        <div v-if="loaded" class="control-bar">
            <button class="btn-save" @click="addOrderFunc()">{{ buttonSaveContent }}</button>
        </div>
        <div v-if="serverMessage.message" class="server-message" :class="[serverMessage.color]">{{ serverMessage.message }}</div>
    </div>
</template>

<script>
import { storeToRefs } from 'pinia'
import { useOrdersStore } from '../store/ordersStore'
import vLoader from './service_vLoader.vue'

export default {
    setup() {
        const OrdersStore = useOrdersStore()
        const { getOrderFromStore } = storeToRefs(OrdersStore)

        return { getOrderFromStore }
    },
    components: { vLoader },
    data() {
        return {
            orderNumber: this.$route.params.number,
            loaded: false,
            buttonSaveContent: 'Сохранить',
            serverMessage: {
                message: '',
                color: 'green'
            }
        }
    },
    computed: {
        getOrderFromComp() {
           return useOrdersStore().getOrderFromStore(this.orderNumber)
        } 
    },
    watch: {
        getOrderFromComp() {
            this.loaded = true
        }
    },
    created() {
        if (this.getOrderFromComp) this.loaded = true
    }
}
</script>