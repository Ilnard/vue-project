<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Добавить заказ</h2>
            <RouterLink to="/" class="viewer-header__link">Вернуться к заказам</RouterLink>
        </header>
        <form>
            <div class="form-fields">
                <div class="row">
                    <div class="field">
                        <span class="field__name">Номер <span v-show="addOrder.number.error" class="field__error">({{
                            addOrder.number.error }})</span></span>
                        <input type="text" class="field__input" name="number" v-model="addOrder.number.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Заказчик <span v-show="addOrder.client.error" class="field__error">({{
                            addOrder.client.error }})</span></span>
                        <input type="text" class="field__input" name="client" v-model="addOrder.client.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Название заказа <span v-show="addOrder.title.error"
                                class="field__error">({{ addOrder.title.error }})</span></span>
                        <input type="text" class="field__input" name="title" v-model="addOrder.title.value">
                    </div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Дата и время <span v-show="addOrder.datetime.error"
                                class="field__error">({{ addOrder.datetime.error }})</span></span>
                        <input type="datetime-local" class="field__input" name="datetime"
                            v-model="addOrder.datetime.value">
                    </div>
                    <div></div>
                    <div></div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Сумма <span v-show="addOrder.pay.error" class="field__error">({{
                            addOrder.pay.error }})</span></span>
                        <input type="number" class="field__input" name="pay" v-model="addOrder.pay.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Оплачено <span v-show="addOrder.paid.error" class="field__error">({{
                            addOrder.paid.error }})</span></span>
                        <input type="number" class="field__input" name="paid" v-model="addOrder.paid.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Статус <span v-show="addOrder.status.error" class="field__error">({{
                            addOrder.status.error }})</span></span>
                        <select name="status" class="field__input" v-model="addOrder.status.value">
                            <option selected value="Не начата">Не начата</option>
                            <option value="В работе">В работе</option>
                            <option value="Приостановлена">Приостановлена</option>
                            <option value="Завершена">Завершена</option>
                            <option value="Отменена">Отменена</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="control-bar">
                <button class="btn-save" type="button" @click="addOrderFunc()">{{ buttonSaveContent }}</button>
            </div>
        </form>
        <div v-if="serverMessage.message" class="service-message" :class="[serverMessage.color]">{{
                            serverMessage.message }}</div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
    data() {
        return {
            addOrder: {
                number: {
                    value: '',
                    error: ''
                },
                client: {
                    value: '',
                    error: ''
                },
                title: {
                    value: '',
                    error: ''
                },
                datetime: {
                    value: '',
                    error: ''
                },
                pay: {
                    value: 0,
                    error: ''
                },
                paid: {
                    value: 0,
                    error: ''
                },
                status: {
                    value: 'Не начата',
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
        addOrderFunc() {
            if (this.formValid()) {
                this.buttonSaveContent = 'Загрузка...'
                fetch('http://vue-project-server:8080/api/add-order/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        number: this.addOrder.number.value,
                        client: this.addOrder.client.value,
                        title: this.addOrder.title.value,
                        datetime: this.addOrder.datetime.value,
                        pay: this.addOrder.pay.value,
                        paid: this.addOrder.paid.value,
                        status: this.addOrder.status.value,
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        this.buttonSaveContent = 'Сохранить'
                        if (data.status) {
                            this.serverMessage.message = 'Заказ успешно добавлен'
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
            if (!this.addOrder.number.value.length) {
                this.setErrorInput('number', 'Пустое поле')
                valid = false
            }
            if (!this.addOrder.client.value.length) {
                this.setErrorInput('client', 'Пустое поле')
                valid = false
            }
            if (!this.addOrder.title.value.length) {
                this.setErrorInput('title', 'Пустое поле')
                valid = false
            }
            if (!this.addOrder.datetime.value.length) {
                this.setErrorInput('datetime', 'Пустое поле')
                valid = false
            }

            return valid
        },
        setErrorInput(name, error) {
            document.querySelector(`.field__input[name=${name}]`).classList.add('error')
            switch (name) {
                case 'number': {
                    this.addOrder.number.error = 'Пустое поле'
                    break
                }
                case 'client': {
                    this.addOrder.client.error = 'Пустое поле'
                    break
                }
                case 'title': {
                    this.addOrder.title.error = 'Пустое поле'
                    break
                }
                case 'datetime': {
                    this.addOrder.datetime.error = 'Пустое поле'
                    break
                }
            }
        },
        clearErrorInput(name) {
            document.querySelector(`.field__input[name=${name}]`).classList.remove('error')
            switch (name) {
                case 'number': {
                    this.addOrder.number.error = ''
                    break
                }
                case 'client': {
                    this.addOrder.client.error = ''
                    break
                }
                case 'title': {
                    this.addOrder.title.error = ''
                    break
                }
                case 'datetime': {
                    this.addOrder.datetime.error = ''
                    break
                }
            }
        }
    },
    watch: {
        'addOrder.number.value'(newVal) {
            if (newVal != '') {
                this.clearErrorInput('number')
            }
        },
        'addOrder.client.value'(newVal) {
            if (newVal != '') {
                this.clearErrorInput('client')
            }
        },
        'addOrder.title.value'(newVal) {
            if (newVal != '') {
                this.clearErrorInput('title')
            }
        },
        'addOrder.datetime.value'(newVal) {
            if (newVal != '') {
                this.clearErrorInput('datetime')
            }
        },
    }
}
</script>