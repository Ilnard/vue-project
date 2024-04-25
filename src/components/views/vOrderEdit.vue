<template>
    <div class="parent-div">
        <header class="viewer-header">
            <h2 class="viewer__title">{{ mode == 'standart' ? 'Добавить заказ' : 'Обновить заказ ' +
                addOrder.number.value }}</h2>
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
                        <span class="field__name">Начало - Дата и время <span v-show="addOrder.datetime.error"
                                class="field__error">({{ addOrder.datetime.error }})</span></span>
                        <input type="datetime-local" class="field__input" name="datetime"
                            v-model="addOrder.datetime.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Завершение - Дата и время <span v-show="addOrder.endpoint.error"
                                class="field__error">({{ addOrder.endpoint.error
                                }})</span></span>
                        <input type="datetime-local" class="field__input" name="endpoint"
                            v-model="addOrder.endpoint.value">
                    </div>
                    <div></div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Оплата в час <span v-show="addOrder.pay.error"
                                class="field__error">({{
                                    addOrder.pay.error }})</span></span>
                        <input type="number" class="field__input" name="pay" v-model="addOrder.pay.value">
                    </div>
                    <div class="field">
                        <span class="field__name">Статус <span v-show="addOrder.status.error" class="field__error">({{
                            addOrder.status.error }})</span></span>
                        <select name="status" class="field__input" v-model="addOrder.status.value">
                            <option value="В работе">В работе</option>
                            <option value="Завершена">Завершена</option>
                        </select>
                    </div>
                    <div></div>
                </div>
                <div class="row">
                    <div class="field">
                        <span class="field__name">Допущенные <span v-show="addOrder.pay.error" class="field__error">({{
                            addOrder.pay.error }})</span></span>
                        <div class="field__input-wrapper">
                            <select name="status" class="field__input field__input_long"
                                v-model="memberSelectedAllowed">
                                <template v-for="member in members.members">
                                    <option
                                        v-if="!addOrder.allowedMembers.value.find(allowedMember => member.id == allowedMember.id) && !addOrder.notAllowedMembers.value.find(allowedMember => member.id == allowedMember.id)"
                                        :value="member.id">{{ member.name + ' ' +
                                            member.surname + ' ' + member.patronymic + ' (' + member.position + ')' }}
                                    </option>
                                </template>
                            </select>
                            <button type="button" class="btn input-btn"
                                @click="memberAddToAttachments(true)">Добавить</button>
                        </div>
                        <ul class="attachments-members">
                            <li class="attachments-member" v-for="member in addOrder.allowedMembers.value">
                                <div class="attachments-member__name">{{ '- ' + generalStore.getMember(member.id).name +
                                    ' ' +
                                    generalStore.getMember(member.id).surname + ' (' +
                                    generalStore.getMember(member.id).position + ')' }}</div>
                                <input type="number" class="attachments-member__pay" v-model="member.pay">
                                <button type="button" class="btn attachments-member__remove-btn"
                                    @click="memberRemoveFromAttachments(member.id, true)">Убрать</button>
                            </li>
                        </ul>
                    </div>
                    <div class="field">
                        <span class="field__name">Недопущенные <span v-show="addOrder.status.error"
                                class="field__error">({{
                                    addOrder.status.error }})</span></span>
                        <div class="field__input-wrapper">
                            <select name="status" class="field__input field__input_long"
                                v-model="memberSelectedNotAllowed">
                                <template v-for="member in members.members">
                                    <option
                                        v-if="!addOrder.allowedMembers.value.find(allowedMember => member.id == allowedMember.id) && !addOrder.notAllowedMembers.value.find(allowedMember => member.id == allowedMember.id)"
                                        :value="member.id">{{ member.name + ' ' +
                                            member.surname + ' ' + member.patronymic + ' (' + member.position + ')' }}
                                    </option>
                                </template>
                            </select>
                            <button type="button" class="btn input-btn"
                                @click="memberAddToAttachments(false)">Добавить</button>
                        </div>
                        <ul class="attachments-members">
                            <li class="attachments-member" v-for="member in addOrder.notAllowedMembers.value">
                                <div class="attachments-member__name">{{ '- ' + generalStore.getMember(member.id).name +
                                    ' ' +
                                    generalStore.getMember(member.id).surname + ' (' +
                                    generalStore.getMember(member.id).position + ')' }}
                                </div>
                                <button type="button" class="btn attachments-member__remove-btn"
                                    @click="memberRemoveFromAttachments(member.id, false)">Убрать</button>
                            </li>
                        </ul>
                    </div>
                    <div></div>
                </div>
            </div>
            <div class="control-bar">
                <button class="btn save-btn" type="button" @click="addOrderFunc()">{{ buttonSaveContent }}</button>
            </div>
        </form>
        <div v-if="serverMessage.message" class="service-message" :class="[serverMessage.color]">{{
            serverMessage.message }}</div>
    </div>
</template>

<script>
import { storeToRefs } from 'pinia'
import { useGeneralStore } from '../store/generalStore'
import { RouterLink } from 'vue-router'

export default {
    setup() {
        const generalStore = useGeneralStore()
        const { getMembers, getOrder } = storeToRefs(generalStore)

        return { generalStore, getMembers, getOrder }
    },
    data() {
        return {
            mode: 'standart',
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
                endpoint: {
                    value: '',
                    error: ''
                },
                pay: {
                    value: 0,
                    error: ''
                },
                status: {
                    value: 'Не начата',
                    error: ''
                },
                allowedMembers: {
                    value: [],
                    error: ''
                },
                notAllowedMembers: {
                    value: [],
                    error: '',
                }
            },
            members: this.getMembers,
            memberSelectedAllowed: null,
            memberSelectedNotAllowed: null,
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
                        id: this.getOrder.order.id,
                        number: this.addOrder.number.value,
                        client: this.addOrder.client.value,
                        title: this.addOrder.title.value,
                        datetime: this.addOrder.datetime.value,
                        endpoint: this.addOrder.endpoint.value,
                        pay: this.addOrder.pay.value,
                        status: this.addOrder.status.value,
                        allowed: this.addOrder.allowedMembers.value,
                        notAllowed: this.addOrder.notAllowedMembers.value,
                        mode: this.mode,
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        this.buttonSaveContent = 'Сохранить'
                        if (data.status) {
                            this.serverMessage.message = data.message
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
            if (!this.addOrder.pay.value) {
                this.setErrorInput('pay', 'Пустое поле')
                valid = false
            }

            return valid
        },
        setErrorInput(name, error) {
            document.querySelector(`.field__input[name=${name}]`).classList.add('error')
            switch (name) {
                case 'number': {
                    this.addOrder.number.error = error
                    break
                }
                case 'client': {
                    this.addOrder.client.error = error
                    break
                }
                case 'title': {
                    this.addOrder.title.error = error
                    break
                }
                case 'datetime': {
                    this.addOrder.datetime.error = error
                    break
                }
                case 'pay': {
                    this.addOrder.pay.error = error
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
        },
        memberAddToAttachments(allowed) {
            if (allowed) {
                if (this.addOrder.allowedMembers.value.find(member => member.id == this.memberSelectedAllowed)) return false
                this.addOrder.allowedMembers.value.push({
                    id: this.memberSelectedAllowed,
                    pay: 0
                })
            }
            else {
                if (this.addOrder.notAllowedMembers.value.find(member => member.id == this.memberSelectedNotAllowed)) return false
                this.addOrder.notAllowedMembers.value.push({
                    id: this.memberSelectedNotAllowed
                })
            }
        },
        memberRemoveFromAttachments(id, allowed) {
            if (allowed) {
                this.addOrder.allowedMembers.value = this.addOrder.allowedMembers.value.filter(member => member.id != id)
            }
            else {
                this.addOrder.notAllowedMembers.value = this.addOrder.notAllowedMembers.value.filter(member => member.id != id)
            }
        },
        setOrderData() {
            this.addOrder.number.value = this.getOrder.order.number
            this.addOrder.client.value = this.getOrder.order.client
            this.addOrder.title.value = this.getOrder.order.title
            this.addOrder.datetime.value = this.getOrder.order.datetime
            this.addOrder.endpoint.value = this.getOrder.order.endpoint
            this.addOrder.pay.value = this.getOrder.order.pay
            this.addOrder.status.value = this.getOrder.order.status
            this.getOrder.order.attachmentList.forEach(memberAttachment => {
                switch (memberAttachment.allowed) {
                    case '1': {
                        this.addOrder.allowedMembers.value.push({
                            id: memberAttachment.member_id,
                            pay: memberAttachment.pay
                        })
                        break
                    }
                    case '0': {
                        this.addOrder.notAllowedMembers.value.push({
                            id: memberAttachment.member_id,
                        })
                        break
                    }
                }
            })
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
        'getOrder.order'() {
            this.setOrderData()
        }
    },
    created() {
        if (!this.getMembers.members.length) this.generalStore.getMembersFromServer()

        // Получение GET-параметра
        let mode = (new RegExp('[?&]' + encodeURIComponent('mode') + '=([^&]*)')).exec(location.search)
        if (mode) {
            this.mode = decodeURIComponent(mode[1])
            if (mode[1] == 'edit') {
                let number = (new RegExp('[?&]' + encodeURIComponent('number') + '=([^&]*)')).exec(location.search)
                this.generalStore.setOrderViewData(number[1])
            }
        }
    }
}
</script>

<style scoped>
.field__input-wrapper {
    display: flex;
    gap: 5px;
    margin-bottom: 15px;
}

.input-btn {
    padding: 10px 10px;
}

.attachments-member {
    display: flex;
    gap: 10px;
    margin-left: 10px;
    margin-bottom: 10px;
}
.attachments-member__pay {
    width: 70px;
}

.attachments-member__remove-btn {
    background: none;
    padding: 0;
    color: var(--danger);
}

.attachments-member__remove-btn:hover {
    text-decoration: underline;
}
</style>