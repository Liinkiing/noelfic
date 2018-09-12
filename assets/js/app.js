import Vue from 'vue'
import vueMoment from "vue-moment"
import moment from "moment"
import "moment/locale/fr"
import {Comment, Comments, UserFavorites} from './components'
import '../scss/app.scss'

Vue.config.productionTip = false
Vue.config.devtools = process.env.NODE_ENV === "development"
Vue.config.debug = process.env.NODE_ENV === "development"
Vue.config.silent = process.env.NODE_ENV !== "development"

const components = {Comment, Comments, UserFavorites}

const locale = window.location.pathname.split('/').filter(Boolean).shift()
moment.locale(locale)
moment.defaultFormat = 'LLL'

Vue.use(vueMoment, {moment});
new Vue({
    el: '#app',
    components
})
