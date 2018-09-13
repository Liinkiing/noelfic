import Vue from 'vue'
import Argon from 'vue-argon-design-system/src/plugins/argon-kit'
import i18n from './i18n'
import {Comment, Comments, UserFavorites, FictionSearch, BaseNav} from './components'
import '../scss/app.scss'

Vue.config.productionTip = false
Vue.config.devtools = process.env.NODE_ENV === "development"
Vue.config.debug = process.env.NODE_ENV === "development"
Vue.config.silent = process.env.NODE_ENV !== "development"

const components = {Comment, Comments, UserFavorites, FictionSearch, BaseNav}

Vue.use(Argon)

new Vue({
    i18n,
    el: '#app',
    components
})

