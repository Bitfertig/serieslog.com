import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  { path: '/impress', name: 'Impress', component: () => import(/* webpackChunkName: "impress" */ '../views/Impress.vue') },
  { path: '/privacy', name: 'Privacy', component: () => import(/* webpackChunkName: "privacy" */ '../views/Privacy.vue') },  

  { path: '/register', name: 'Register', component: () => import(/* webpackChunkName: "register" */ '../views/Register.vue') },
  { path: '/login', name: 'Login', component: () => import(/* webpackChunkName: "login" */ '../views/Login.vue') },
  { path: '/logout', name: 'Logout', component: () => import(/* webpackChunkName: "logout" */ '../views/Logout.vue') },
  { path: '/pass_forgotten', name: 'Pass_forgotten', component: () => import(/* webpackChunkName: "pass_forgotten" */ '../views/Pass_forgotten.vue') },
  { path: '/settings', name: 'Settings', component: () => import(/* webpackChunkName: "settings" */ '../views/Settings.vue') },

  { path: '/list', name: 'List', component: () => import(/* webpackChunkName: "list" */ '../views/List.vue') },
  { path: '/search', name: 'Search', component: () => import(/* webpackChunkName: "search" */ '../views/Search.vue') },
  { path: '/genres', name: 'Genres', component: () => import(/* webpackChunkName: "genres" */ '../views/Genres.vue') },
  { path: '/description', name: 'Description', component: () => import(/* webpackChunkName: "description" */ '../views/Description.vue') },
  { path: '/rated', name: 'Rated', component: () => import(/* webpackChunkName: "rated" */ '../views/Rated.vue') }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
