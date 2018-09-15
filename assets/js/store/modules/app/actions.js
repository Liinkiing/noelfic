import {SET_USER} from "./mutations";

export const LOGIN_USER = 'LOGIN_USER'

export default {
    [LOGIN_USER]({commit}, user) {
        commit(SET_USER, user)
        document.querySelector('script#user').remove()
    }
}