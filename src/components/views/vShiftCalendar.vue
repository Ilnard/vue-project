<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Календарь смен</h2>
            <nav class="viewer-header__links">
                <RouterLink to="/organization" class="viewer-header__link">Организация</RouterLink>
                <RouterLink to="/addmember" class="viewer-header__link">Добавить сотрудника</RouterLink>
            </nav>
        </header>
        <input v-if="getShiftCalendarItem.isLoaded" type="date" class="shift-date" v-model="date">
        <vLoader v-if="!getShiftCalendarItem.isLoaded" />
        <table v-if="getShiftCalendarItem.isLoaded" class="table">
            <thead>
                <tr>
                    <td class="cell">Заявка</td>
                    <td class="cell">Название</td>
                    <td class="cell">Дата начала</td>
                    <td class="cell">Дата окончания</td>
                    <td class="cell">ФИО</td>
                    <td class="cell">Должность</td>
                    <td class="cell">Часы</td>
                    <td class="cell">Оп./час</td>
                    <td class="cell">Итого</td>
                    <td class="cell">Причина отсутствия</td>
                    <td class="cell"></td>
                </tr>
            </thead>
            <tbody>
                <template v-for="order in shiftCalendarItem.data">
                    <tr v-for="attachment in order.attachments">
                        <td class="cell">{{ order.number }}</td>
                        <td class="cell">{{ order.title }}</td>
                        <td class="cell">{{ order.datetimeVisual }}</td>
                        <td class="cell">{{ order.endpointVisual }}</td>
                        <td class="cell">{{ attachment.name + ' ' + attachment.surname }}</td>
                        <td class="cell">{{ attachment.position }}</td>
                        <td class="cell"><input type="text" class="attachment-input" v-model="attachment.hours"></td>
                        <td class="cell">{{ attachment.pay }}</td>
                        <td class="cell">{{ attachment.hours * attachment.pay }}</td>
                        <td class="cell"><textarea type="text" class="" v-model="attachment.reason"></textarea></td>
                        <td class="cell"
                            @click="updateMemberInShiftCalendar(order.id, attachment.member_id, attachment.hours, attachment.reason)">
                            <button class="btn shift-save-btn">✓</button></td>
                    </tr>
                </template>
            </tbody>
        </table>
        <div v-else-if="getShiftCalendarItem.isLoaded" class="service-message red">{{ getShiftCalendarItem.errorMessage
            }}</div>
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
        const { getShiftCalendarItem } = storeToRefs(generalStore)
        return { generalStore, getShiftCalendarItem }
    },
    data() {
        return {
            shiftCalendarItem: this.getShiftCalendarItem,
            date: String(new Date().getFullYear()) + '-' + String(new Date().getMonth() + 1).padStart(2, '0') + '-' + String(new Date().getDate()).padStart(2, '0'),
        }
    },
    components: { vLoader },
    methods: {
        updateMemberInShiftCalendar(orderId, memberId, hours, reason) {
            fetch(`http://vue-project-server:8080/api/update-shift-calendar-item/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    date: this.date,
                    orderId: orderId,
                    memberId: memberId,
                    hours: hours,
                    reason: reason
                })
            })
                .then(res => res.ok ? res.json() : Promise.reject(res))
                .then(data => {
                    if (data.status) {
                        this.shiftCalendarItem.errorMessage = "Данные обновились"
                    }
                    else {
                        this.shiftCalendarItem.errorMessage = `Ошибка обработки запроса на сервере (${data.message})`
                    }
                })
                .catch(() => {
                    this.shiftCalendarItem.errorMessage = 'Сервер не отвечает (Ошибка отправки запроса)'
                })
        }
    },
    watch: {
        date(newVal) {
            if (newVal.length == 10) this.generalStore.getShiftCalendarItemFromServer(newVal)
        }
    },
    created() {
        this.generalStore.getShiftCalendarItemFromServer(this.date)
    }

}
</script>

<style>
.shift-save-btn {
    padding: 5px 10px;
}

.attachment-input {
    width: 50px;
}
</style>