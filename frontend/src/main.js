import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueSweetAlert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

Vue.config.productionTip = false

Vue.use(VueSweetAlert2)
Vue.use(VueAxios, axios)

axios.create({
  baseURL: 'http://localhost:8000/',
  headers: {
    Accept: 'application/json'
  }
})

new Vue({
  router,
  store,
  vuetify,
  render: function (h) { return h(App) }
}).$mount('#app')

const toast = Vue.swal.mixin({
  toast: true,
  position: 'top-right',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Vue.swal.stopTimer)
    toast.addEventListener('mouseleave', Vue.swal.resumeTimer)
  }
})

window.toast = toast
