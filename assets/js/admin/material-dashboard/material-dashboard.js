// Sidebar on the right. Used as a local plugin in DashboardLayout.vue
import SideBar from '../components/material-dashboard/SidebarPlugin'

import VueMaterial from 'vue-material'

/**
 * This is the main Light Bootstrap Dashboard Vue plugin where dashboard related plugins are registerd.
 */
export default{
  install (Vue) {
    Vue.use(SideBar)
    Vue.use(VueMaterial)
  }
}
