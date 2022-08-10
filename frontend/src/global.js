import Vue from 'vue'

export const userKey = '__sgc_user'

export const baseApiUrl = 'http://localhost:8000/api'

export function showError (e) {
    if(e && e.response && e.response.data
        && typeof e.response.data === 'string') {
        Vue.toasted.global.defaultError({ msg: e.response.data })
    } else if(typeof e === 'string') {
        Vue.toasted.global.defaultError({ msg: e })
    } else {
        Vue.toasted.global.defaultError()
    }
}

export function formatDate(date) {
    if (date && (typeof date === 'string')) {
        const dateObj = new Date(date)
        const formatedDate = dateObj.toLocaleDateString('pt-BR')
        return formatedDate
    } else {
        throw new Error('Data inválida')
    }
}

export default { userKey, baseApiUrl, showError }
