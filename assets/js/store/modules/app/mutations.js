export const SET_USER = 'SET_USER'
export const SET_LOCALE = 'SET_LOCALE'
export const SET_TOUCH_DEVICE = 'SET_TOUCH_DEVICE'

export default {
    [SET_USER](state, user) {
        state.user = user
    },
    [SET_LOCALE](state, locale) {
        state.locale = locale
    },
    [SET_TOUCH_DEVICE](state, value) {
        state.isTouchDevice = value
    }
}