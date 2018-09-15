export const SET_USER = 'SET_USER'

export default {
    [SET_USER](state, user) {
        state.user = user
    }
}