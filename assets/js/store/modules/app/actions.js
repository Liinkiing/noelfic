import {SET_IS_HOMEPAGE, SET_LOCALE, SET_TOUCH_DEVICE, SET_USER} from "./mutations";

export const LOGIN_USER = 'LOGIN_USER'
export const CHANGE_LOCALE = 'CHANGE_LOCALE'
export const CHANGE_TOUCH_DEVICE = 'CHANGE_TOUCH_DEVICE'
export const CHANGE_IS_HOMEPAGE = 'CHANGE_IS_HOMEPAGE'
export const FROZE_BODY = 'FROZE_BODY'
export const UNFROZE_BODY = 'UNFROZE_BODY'

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
    },
    [CHANGE_IS_HOMEPAGE]({commit}, value) {
        commit(SET_IS_HOMEPAGE, value)
        delete window.__HOMEPAGE
    },
    [FROZE_BODY]() {
        const $body = document.querySelector('body');
        if (!$body.classList.contains('frozen')) {
            $body.classList.add('frozen')
        }
    },
    [UNFROZE_BODY]() {
        const $body = document.querySelector('body');
        if ($body.classList.contains('frozen')) {
            $body.classList.remove('frozen')
        }
    }
}