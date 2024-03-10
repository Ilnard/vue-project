import { defineStore } from "pinia"

export const useOrdersStore = defineStore('ordersStore', {
    state: () => {
        return {
            orders: []
        }
    },
    getters: {
        getOrdersFromStore: (state) => state.orders.length ? state.orders : false,
        getOrderFromStore: (state) => number => state.orders.length ? state.orders.find(order => order.number == number) : false,
    },
    actions: {
        fixDateTime(data) {
            data.forEach(item => {
                item.datetime = item.datetime.split(' ')[0].split('-').reverse().join('.') + ', ' + item.datetime.split(' ')[1].slice(0, 5);
            })
            return data
        },
        getOrdersFromServer() {
            fetch('http://vue-project-server:8080/get-orders/', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status && data.code == 0) {
                    data.data = this.fixDateTime(data.data)
                    this.orders = data.data
                }
            })
        }
    }
})