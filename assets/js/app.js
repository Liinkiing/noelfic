import Vue from 'vue'
import Vuex from 'vuex'
import Argon from 'vue-argon-design-system/src/plugins/argon-kit'
import VueTouch from 'vue-touch'
import PortalVue from 'portal-vue'
import i18n from './i18n'
import './routing'
import {
    FictionChapterTouchPaginator,
    FictionChapterShortcuts,
    IconBase,
    AppHeader,
    Comment,
    Comments,
    UserFavorites,
    FictionSearch,
    BaseNav,
    SortableTable,
    FictionChapterComments,
    BaseComments,
    CommentForm,
    FictionUserFavorite,
    FictionComments,

    ProfilePage
} from './components'
import { createProvider } from "./vue-apollo";
import store from './store'
import '../scss/app.scss'

Vue.config.productionTip = false
Vue.config.devtools = process.env.NODE_ENV === "development"
Vue.config.debug = process.env.NODE_ENV === "development"
Vue.config.silent = process.env.NODE_ENV !== "development"

Vue.component('Comments', Comments)
Vue.component('IconBase', IconBase)
Vue.component('CommentForm', CommentForm)

const components = {
    FictionChapterTouchPaginator,
    AppHeader,
    FictionChapterShortcuts,
    Comment,
    UserFavorites,
    FictionSearch,
    BaseNav,
    SortableTable,
    FictionChapterComments,
    BaseComments,
    FictionUserFavorite,
    FictionComments,

    ProfilePage
}

Vue.use(VueTouch)
Vue.use(PortalVue)
Vue.use(Argon)
Vue.use(Vuex)

new Vue({
    i18n,
    apolloProvider: createProvider(),
    store,
    el: '#app',
    components
})

