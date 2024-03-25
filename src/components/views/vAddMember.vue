<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Добавить сотрудника</h2>
            <RouterLink to="/organization" class="viewer-header__link">Вернуться к организации</RouterLink>
        </header>
        <form>
            <div class="form-fields">
                <div class="row">
                    <div class="field">
                        <span class="field__name">Имя <span v-show="addMember.name.error" class="field__error">({{
                            addMember.name.error }})</span></span>
                        <input type="text" class="field__input" name="name" v-model="addMember.name.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Фамилия <span v-show="addMember.surname.error"
                                class="field__error">({{
                            addMember.surname.error }})</span></span>
                        <input type="text" class="field__input" name="surname" v-model="addMember.surname.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Отчество <span v-show="addMember.patronymic.error"
                                class="field__error">({{
                            addMember.patronymic.error }})</span></span>
                        <input type="text" class="field__input" name="patronymic" v-model="addMember.patronymic.value">
                    </div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Дата рождения <span v-show="addMember.birthdate.error"
                                class="field__error">({{
                            addMember.birthdate.error }})</span></span>
                        <input type="date" class="field__input" name="birthdate" v-model="addMember.birthdate.value">
                    </div>
                    <div></div>
                    <div></div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Должность <span v-show="addMember.position.error"
                                class="field__error">({{
                            addMember.position.error }})</span></span>
                        <input type="text" class="field__input" name="position" v-model="addMember.position.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Отдел <span v-show="addMember.department.error"
                                class="field__error">({{
                            addMember.department.error }})</span></span>
                        <input type="text" class="field__input" name="department" v-model="addMember.department.value">
                    </div>
                    <div></div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Дата трудоустройства <span v-show="addMember.employmentdate.error"
                                class="field__error">({{
                            addMember.employmentdate.error }})</span></span>
                        <input type="date" class="field__input" name="employmentdate"
                            v-model="addMember.employmentdate.value">
                    </div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="control-bar">
                <button class="btn-save" type="button" @click="addMemberFunc()">{{ buttonSaveContent }}</button>
            </div>
        </form>
        <div v-if="serverMessage.message" class="service-message" :class="[serverMessage.color]">{{ serverMessage.message }}</div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
    data() {
        return {
            addMember: {
                name: {
                    value: '',
                    error: ''
                },
                surname: {
                    value: '',
                    error: ''
                },
                patronymic: {
                    value: '',
                    error: ''
                },
                birthdate: {
                    value: '',
                    error: ''
                },
                position: {
                    value: '',
                    error: ''
                },
                department: {
                    value: '',
                    error: ''
                },
                employmentdate: {
                    value: '',
                    error: ''
                }
            },
            serverMessage: {
                message: '',
                color: 'green'
            },
            buttonSaveContent: 'Сохранить',
        }
    },
    methods: {
        addMemberFunc() {
            if (this.formValid()) {
                this.buttonSaveContent = 'Загрузка...'
                fetch('http://vue-project-server:8080/api/add-member/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: this.addMember.name.value,
                        surname: this.addMember.surname.value,
                        patronymic: this.addMember.patronymic.value,
                        birthdate: this.addMember.birthdate.value,
                        position: this.addMember.position.value,
                        department: this.addMember.department.value,
                        employmentdate: this.addMember.employmentdate.value,
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        this.buttonSaveContent = 'Сохранить'
                        if (data.status) {
                            this.serverMessage.message = 'Сотрудник успешно добавлен'
                            this.serverMessage.color = 'green'
                        }
                        else {
                            this.serverMessage.message = `Что-то пошло не так (${data.message})`
                            this.serverMessage.color = 'red'
                        }
                    }

                    )
            }
        },
        formValid() {
            let valid = true
            if (!this.addMember.name.value.length) {
                this.setErrorInput('name', 'Пустое поле')
                valid = false
            }
            if (!this.addMember.surname.value.length) {
                this.setErrorInput('surname', 'Пустое поле')
                valid = false
            }
            if (!this.addMember.birthdate.value.length) {
                this.setErrorInput('birthdate', 'Пустое поле')
                valid = false
            }
            if (!this.addMember.position.value.length) {
                this.setErrorInput('position', 'Пустое поле')
                valid = false
            }
            if (!this.addMember.employmentdate.value.length) {
                this.setErrorInput('employmentdate', 'Пустое поле')
                valid = false
            }

            return valid
        },
        setErrorInput(name, error) {
            document.querySelector(`.field__input[name=${name}]`).classList.add('error')
            switch (name) {
                case 'name': {
                    this.addMember.name.error = 'Пустое поле'
                    break
                }
                case 'surname': {
                    this.addMember.surname.error = 'Пустое поле'
                    break
                }
                case 'birthdate': {
                    this.addMember.birthdate.error = 'Пустое поле'
                    break
                }
                case 'position': {
                    this.addMember.position.error = 'Пустое поле'
                    break
                }
                case 'employmentdate': {
                    this.addMember.employmentdate.error = 'Пустое поле'
                    break
                }
            }
        },
        clearErrorInput(name) {
            document.querySelector(`.field__input[name=${name}]`).classList.remove('error')
            switch (name) {
                case 'name': {
                    this.addMember.name.error = ''
                    break
                }
                case 'surname': {
                    this.addMember.surname.error = ''
                    break
                }
                case 'birthdate': {
                    this.addMember.birthdate.error = ''
                    break
                }
                case 'position': {
                    this.addMember.position.error = ''
                    break
                }
                case 'employmentdate': {
                    this.addMember.employmentdate.error = ''
                    break
                }
            }
        },
    },
    watch: {
            'addMember.name.value'(newVal) {
                if (newVal != '') {
                    this.clearErrorInput('name')
                }
            },
            'addMember.surname.value'(newVal) {
                if (newVal != '') {
                    this.clearErrorInput('surname')
                }
            },
            'addMember.birthdate.value'(newVal) {
                if (newVal != '') {
                    this.clearErrorInput('birthdate')
                }
            },
            'addMember.position.value'(newVal) {
                if (newVal != '') {
                    this.clearErrorInput('position')
                }
            },
            'addMember.employmentdate.value'(newVal) {
                if (newVal != '') {
                    this.clearErrorInput('employmentdate')
                }
            },
        }
}
</script>
