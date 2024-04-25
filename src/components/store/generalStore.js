import { defineStore } from "pinia"

export const useGeneralStore = defineStore('generalStore', {
    state: () => {
        return {
            ordersData: {
                orders: [],
                errorMessage: '',
                isLoaded: false,
                status: false
            },
            orderViewData: {
                order: {},
                errorMessage: '',
                isLoaded: false,
                status: false
            },
            membersData: {
                members: [],
                errorMessage: '',
                isLoaded: false,
                status: false
            },
            currentShiftCalendarItem: {
                data: [],
                isLoaded: false,
                status: false,
            }
        }
    },
    getters: {
        getOrders: (state) => state.ordersData,
        getOrder: (state) => state.orderViewData,
        getMembers: (state) => state.membersData,
        getMember: (state) => (id) => state.membersData.members.find(member => member.id == id),
        getShiftCalendarItem: (state) => state.currentShiftCalendarItem,
    },
    actions: {
        fixDateTime(datetime) {
            datetime = new Date(datetime).toLocaleDateString('ru') + ' ' + new Date(datetime).toLocaleTimeString('ru').slice(0, -3)
            return datetime
        },
        fixDate(date) {
            date = new Date(date).toLocaleDateString('ru')
            return date
        },
        getOrdersFromServer() {
            fetch('http://vue-project-server:8080/api/get-orders/', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(res => res.ok ? res.json() : Promise.reject(res))
                .then(data => {
                    this.ordersData.isLoaded = true
                    if (data.status) {
                        this.ordersData.status = data.status
                        if (data.data.length) {
                            data.data.forEach(order => {
                                // Исправляем дату для визуала
                                order.datetimeVisual = this.fixDateTime(order.datetime)
                                // Высчитываем количество проработанных часов
                                switch (order.status) {
                                    case 'В работе': {
                                        const diff = new Date(order.datetime).getTime() - new Date().getTime()
                                        order.hours = Math.round(Math.abs(diff) / (1000 * 3600) * 10) / 10
                                        break
                                    }
                                    case 'Завершена': {
                                        const diff = new Date(order.datetime).getTime() - new Date(order.endpoint).getTime()
                                        order.hours = Math.round(Math.abs(diff) / (1000 * 3600) * 10) / 10
                                        break
                                    }
                                }
                            })
                            this.ordersData.orders = data.data
                        }
                        else {
                            this.ordersData.errorMessage = 'Заказов нет'
                        }
                    }
                    else {
                        this.ordersData.errorMessage = `Ошибка обработки запроса на сервере (${data.message})`
                    }
                })
                .catch(() => {
                    this.ordersData.isLoaded = true
                    this.ordersData.errorMessage = 'Сервер не отвечает (Ошибка отправки запроса) или ошибка в обработке ответа'
                })
        },
        setOrderViewData(number) {
            this.orderViewData.isLoaded = false
            fetch(`http://vue-project-server:8080/api/get-order/?number=${number}`, {
                method: 'GET',
            })
                .then(res => {
                    return res.ok ? res.json() : Promise.reject(res)
                })
                .then(data => {
                    this.orderViewData.isLoaded = true
                    if (data.status) {
                        this.orderViewData.status = data.status
                        if (data.data.number) {
                            data.data.datetimeVisual = this.fixDateTime(data.data.datetime)
                            this.orderViewData.order = data.data
                        }
                        else {
                            this.orderViewData.errorMessage = 'Заказа нет'
                        }
                    }
                    else {
                        this.orderViewData.errorMessage = `Ошибка обработки запроса на сервере (${data.message})`
                    }
                })
                .catch(() => {
                    this.orderViewData.isLoaded = true
                    this.orderViewData.errorMessage = 'Сервер не отвечает (Ошибка отправки запроса)'
                })
        },
        getMembersFromServer() {
            if (!this.membersData.members.length) {
                fetch('http://vue-project-server:8080/api/get-members/', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(res => res.ok ? res.json() : Promise.reject(res))
                    .then(data => {
                        this.membersData.isLoaded = true
                        if (data.status) {
                            this.membersData.status = data.status
                            if (data.data.length) {
                                data.data.forEach(member => {
                                    member.birthdateVisual = this.fixDate(member.birthdate)
                                    member.employmentdateVisual = this.fixDate(member.employmentdate)
                                    member.allowed = 0
                                })
                                this.membersData.members = data.data
                            }
                            else {
                                this.membersData.errorMessage = 'Заказов нет'
                            }
                        }
                        else {
                            this.membersData.errorMessage = `Ошибка обработки запроса на сервере (${data.message})`
                        }
                    })
                    .catch(() => {
                        this.membersData.isLoaded = true
                        this.membersData.errorMessage = 'Сервер не отвечает (Ошибка отправки запроса)'
                    })
            }
        },
        getShiftCalendarItemFromServer(date) {
            if (!this.currentShiftCalendarItem.isChecked) {
                date = date.replace(/\./gi, '-')
                fetch(`http://vue-project-server:8080/api/get-shift-calendar-item/?date=${date}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(res => res.ok ? res.json() : Promise.reject(res))
                    .then(data => {
                        this.currentShiftCalendarItem.isLoaded = true
                        if (data.status) {
                            this.currentShiftCalendarItem.status = data.status
                            if (data.data.length) {
                                data.data.forEach(order => {
                                    // Исправляем даты для визуала
                                    order.datetimeVisual = this.fixDateTime(order.datetime)
                                    order.endpointVisual = this.fixDateTime(order.endpoint)
                                })
                                this.currentShiftCalendarItem.data = data.data
                                this.currentShiftCalendarItem.data.date = date
                            }
                            else {
                                this.currentShiftCalendarItem.errorMessage = 'Заказов нет'
                            }
                        }
                        else {
                            this.currentShiftCalendarItem.errorMessage = `Ошибка обработки запроса на сервере (${data.message})`
                        }
                    })
                    .catch(() => {
                        this.currentShiftCalendarItem.isLoaded = true
                        this.currentShiftCalendarItem.errorMessage = 'Сервер не отвечает (Ошибка отправки запроса)'
                    })
            }
        }
    }
})