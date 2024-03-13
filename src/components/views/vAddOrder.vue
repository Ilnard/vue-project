<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">Добавить заказ</h2>
            <RouterLink to="/" class="viewer-header__link">Вернуться к заказам</RouterLink>
        </header>
        <div class="addorder">
            <div class="row">
                <div class="field">
                    <span class="field__name">Номер</span>
                    <input type="text" class="field__input" name="number" v-model="addOrder.number">
                </div>
                <div class="field">
                    <span class="field__name">Заказчик</span>
                    <input type="text" class="field__input" name="client" v-model="addOrder.client">
                </div>
                <div class="field">
                    <span class="field__name">Название заказа</span>
                    <input type="text" class="field__input" name="title" v-model="addOrder.title">
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <span class="field__name">Дата и время</span>
                    <input type="datetime-local" class="field__input" name="datetime" v-model="addOrder.datetime">
                </div>
                <div></div>
                <div></div>
            </div>
            <div class="row">
                <div class="field">
                    <span class="field__name">Сумма</span>
                    <input type="number" class="field__input" name="pay" v-model="addOrder.pay">
                </div>
                <div class="field">
                    <span class="field__name">Оплачено</span>
                    <input type="number" class="field__input" name="paid" v-model="addOrder.paid">
                </div>
                <div class="field">
                    <span class="field__name">Статус</span>
                    <select name="status" class="field__input" v-model="addOrder.status">
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
            <button class="btn-save" @click="addOrderFunc()">{{ buttonSaveContent }}</button>
        </div>
        <div v-if="serverMessage.message" class="server-message" :class="[serverMessage.color]">{{ serverMessage.message }}</div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
    data() {
        return {
            addOrder: {
                number: '',
                client: '',
                title: '',
                datetime: '',
                pay: 0,
                paid: 0,
                status: 'Не начата'
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
            this.buttonSaveContent = 'Загрузка...'
            fetch('http://vue-project-server:8080/api/add-order/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(this.addOrder)
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
    }
}
</script>

<style scoped>
.addorder {
    width: 100%;
}
.addorder .row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 5%;
    padding: 25px 0;
    border-bottom: 1px solid var(--grey-lv2);
}
.addorder .row:last-child {
    border-bottom: none;
}
.field__name, .field__input {
    display: block;
}
.field__name {
    margin-bottom: 10px;
}
.field__input {
    height: 40px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid var(--grey-lv2);
    padding: 10px;
}
</style>