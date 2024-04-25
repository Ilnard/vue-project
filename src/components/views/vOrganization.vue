<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Организация</h2>
            <nav class="viewer-header__links">
                <RouterLink to="/shiftcalendar" class="viewer-header__link">Календарь смен</RouterLink>
                <RouterLink to="/addmember" class="viewer-header__link">Добавить сотрудника</RouterLink>
            </nav>
        </header>
        <vLoader v-if="!getMembers.isLoaded" />
        <table v-if="getMembers.isLoaded" class="table">
            <thead>
                <tr>
                    <td class="cell">ФИО</td>
                    <td class="cell">Должность</td>
                    <td class="cell">Отдел</td>
                    <td class="cell">Дата рождения</td>
                    <td class="cell">Дата трудоустройства</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="member in getMembers.members" :key="member.id" class="row">
                    <td class="cell">{{ member.surname + ' ' + member.name + ' ' + member.patronymic}}</td>
                    <td class="cell">{{ member.position }}</td>
                    <td class="cell">{{ member.department }}</td>
                    <td class="cell">{{ member.birthdateVisual }}</td>
                    <td class="cell">{{ member.employmentdateVisual }}</td>
                </tr>
            </tbody>
        </table>
        <div v-else-if="getMembers.isLoaded" class="service-message red">{{ getMembers.errorMessage }}</div>
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
        const { getMembers } = storeToRefs(generalStore)
        return { generalStore, getMembers }
    },
    components: { vLoader },
    created() {
        if (!this.getMembers.members.length) this.generalStore.getMembersFromServer()
    }
}
</script>

<style></style>