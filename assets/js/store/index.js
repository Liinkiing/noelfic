import Vue from 'vue'
import Vuex, { Store } from 'vuex'
import app from './modules/app'
import {CHANGE_LOCALE, LOGIN_USER} from "./modules/app/actions";
import { locale } from '../i18n'

Vue.use(Vuex)

const store = new Store({
    modules: {
        app
    }
})

store.dispatch(`app/${LOGIN_USER}`, window.__USER)
store.dispatch(`app/${CHANGE_LOCALE}`, locale)

export default store