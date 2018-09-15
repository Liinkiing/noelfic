import Vue from 'vue'
import Vuex from 'vuex'
import app from './modules/app'
import {LOGIN_USER} from "./modules/app/actions";

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        app
    }
})

store.dispatch(`app/${LOGIN_USER}`, window.__USER)

export default store