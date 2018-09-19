import Vue from 'vue'
import GlobalComponents from './globalComponents'
import GlobalDirectives from './globalDirectives'
import Notifications from '../components/material-dashboard/NotificationPlugin'

import MaterialDashboard from './material-dashboard'

Vue.use(MaterialDashboard)
Vue.use(GlobalComponents)
Vue.use(GlobalDirectives)
Vue.use(Notifications)

Object.defineProperty(Vue.prototype, '$Chartist', {
  get () {
    return this.$root.Chartist
  }
})
