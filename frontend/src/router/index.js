import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '@/components/Home.vue'
import Registration from '@/components/auth/Registration'
import Forget from '@/components/auth/Forget'
import Login from '@/components/auth/Login'
import Ad from '@/components/ads/Ad'
import NewAd from '@/components/ads/NewAd'
import Order from '@/components/users/Order'
import AdList from '@/components/ads/AdList'
import Logout from '@/components/auth/Logout'
import EmployeeCreate from '@/components/employee/Create'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/logout',
    name: 'logout',
    component: Logout
  },
  {
    path: '/home',
    name: 'home',
    component: Home
  },

  {
    path: '/registration',
    name: 'registration',
    component: Registration
  },
  {
    path: '/forget-password',
    name: 'forget',
    component: Forget
  },
  {
    path: '/employee/create',
    name: 'create',
    component: EmployeeCreate
  },
  {
    path: '/ad/:id',
    name: 'ad',
    component: Ad
  },
  {
    path: '/list',
    name: 'adList',
    component: AdList
  },
  {
    path: '/new',
    name: 'newAd',
    component: NewAd
  },
  {
    path: '/orders',
    name: 'orders',
    component: Order
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/About.vue')
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
