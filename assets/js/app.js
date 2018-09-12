import Vue from 'vue'
import {Comment, Comments, UserFavorites} from './components'
import '../scss/app.scss'

Vue.config.productionTip = false
Vue.config.devtools = process.env.NODE_ENV === "development"
Vue.config.debug = process.env.NODE_ENV === "development"
Vue.config.silent = process.env.NODE_ENV !== "development"

const components = {Comment, Comments, UserFavorites}

import('./i18n').then(module => {
    const { i18n } = module
    new Vue({
        i18n,
        el: '#app',
        components
    })
})

