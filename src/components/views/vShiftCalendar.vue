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
                    <td class="cell">ФИО</td>
                    <td class="cell">Должность</td>
                    <td class="cell">Отдел</td>
                    <td class="cell">Часы</td>
                    <td class="cell">Оп./час</td>
                    <td class="cell">Итого</td>
                    <td class="cell">Причина отсутствия</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="getShiftCalendarItemDataItem in getShiftCalendarItem.data"
                    :key="getShiftCalendarItemDataItem.id" class="row">
                    <td class="cell">{{ getShiftCalendarItemDataItem.member.surname + ' ' +
            getShiftCalendarItemDataItem.member.name + ' ' +
            getShiftCalendarItemDataItem.member.patronymic }}</td>
                    <td class="cell">{{ getShiftCalendarItemDataItem.member.position }}</td>
                    <td class="cell">{{ getShiftCalendarItemDataItem.member.department }}</td>
                    <td class="cell">{{ getShiftCalendarItemDataItem.hours }}</td>
                    <td class="cell">{{ getShiftCalendarItemDataItem.member.payment }}</td>
                    <td class="cell">{{ getShiftCalendarItemDataItem.hours * getShiftCalendarItemDataItem.member.payment }}</td>
                    <td class="cell">{{ getShiftCalendarItemDataItem.reason }}</td>
                </tr>
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
            date: String(new Date().getFullYear()) + '-' + String(new Date().getMonth() + 1).padStart(2, '0') + '-' + String(new Date().getDate()).padStart(2, '0'),
        }
    },
    components: { vLoader },
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

<style></style>