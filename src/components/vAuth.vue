<template>
    <div class="auth-wrapper">
        <form class="auth parent-div">
            <h2 class="auth__title">Авторизация</h2>
            <div class="auth-field">
                <span class="auth-field__name">Логин</span>
                <input type="text" name="login" v-model="formData.login" class="auth-field__input">
            </div>
            <div class="auth-field">
                <span class="auth-field__name">Пароль</span>
                <input type="password" name="password" v-model="formData.password" class="auth-field__input">
            </div>
            <div class="auth-btn-wrapper">
                <button class="btn auth-btn" type="button" @click="userStore.createToken(formData)">Авторизоваться</button>
            </div>
        </form>
    </div>
</template>

<script>
import { useUserStore } from './store/userStore'

export default {
    setup() {
        const userStore = useUserStore();
        return { userStore }
    },
    data() {
        return {
            formData: {
                login: '',
                password: ''
            }
            
        }
    },
}
</script>

<style scoped>
.auth {
    width: 300px;
}

.auth__title {
    font-size: 20px;
    text-align: center;
    margin-bottom: 20px;
}

.auth-field {
    margin-bottom: 20px;
}

.auth-field__name {
    display: block;
    margin-bottom: 5px;
}

.auth-field__input {
    height: 40px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid var(--grey-lv2);
    padding: 10px;
}

.auth-btn-wrapper {
    display: flex;
    justify-content: center;
}

.auth-btn {
    margin-top: 10px;
}
</style>