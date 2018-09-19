import {SET_LOCALE, SET_TOUCH_DEVICE, SET_USER} from "./mutations";

export const LOGIN_USER = 'LOGIN_USER'
export const CHANGE_LOCALE = 'CHANGE_LOCALE'
export const CHANGE_TOUCH_DEVICE = 'CHANGE_TOUCH_DEVICE'

export default {
    [LOGIN_USER]({commit}, user) {
        commit(SET_USER, user)
        delete window.__USER
    },
    [CHANGE_LOCALE]({commit}, locale) {
        commit(SET_LOCALE, locale)
    },
    [CHANGE_TOUCH_DEVICE]({commit}, value) {
        commit(SET_TOUCH_DEVICE, value)
        delete window.__TOUCHDEVICE
    }
}