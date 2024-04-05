import { defineStore } from "pinia"

export const useUserStore = defineStore('userStore', {
    state: () => {
        return {
            userData: {
                id: null,
            },
            jwt: {
                value: '',
                isLoaded: false,
                status: false,
                errorMessage: ''
            }
        }
    },
    actions: {
        createToken(authData) {
            fetch('http://vue-project-server:8080/api/create-token/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(authData)
            })
                .then(res => res.ok ? res.json() : Promise.reject(res))
                .then(data => {
                    this.jwt.isLoaded = true
                    if (data.status) {
                        this.jwt.status = data.status
                        if (data.data.length) {
                            localStorage.setItem('userData', data.data)
                            window.location.reload()
                        }
                        else {
                            this.jwt.errorMessage = 'Нет jwt'
                        }
                    }
                    else {
                        this.jwt.errorMessage = `Ошибка обработки запроса на сервере (${data.message})`
                    }
                })
                .catch(() => {
                    this.jwt.isLoaded = true
                    this.jwt.errorMessage = 'Сервер не отвечает (Ошибка отправки запроса) или ошибка в обработке ответа'
                })
        }
    }
})