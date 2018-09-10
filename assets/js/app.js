import Vue from 'vue';
import {Comment, Comments, UserFavorites} from './components'

import 'bootstrap/scss/bootstrap.scss'
import '../scss/app.scss';

Vue.config.productionTip = false;
Vue.config.devtools = process.env.NODE_ENV === "development";
Vue.config.debug = process.env.NODE_ENV === "development";
Vue.config.silent = process.env.NODE_ENV !== "development";

new Vue({
    el: '#app',
    components: {Comment, Comments, UserFavorites}
});

