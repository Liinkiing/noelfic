import {SET_LOCALE, SET_USER} from "./mutations";

export const LOGIN_USER = 'LOGIN_USER'
export const CHANGE_LOCALE = 'CHANGE_LOCALE'

export default {
    [LOGIN_USER]({commit}, user) {
        commit(SET_USER, user)
        document.querySelector('script#user').remove()
    },
    [CHANGE_LOCALE]({commit}, locale) {
        commit(SET_LOCALE, locale)
    }
}