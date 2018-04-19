import Vue from 'vue'
import Router from 'vue-router'
import auth from '../services/auth'

import Home from '@/components/HelloWorld'
import Login from '@/components/Login'
import NotFoundComponent from '@/components/NotFound'

Vue.use(Router)

let router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    { path: '*', component: NotFoundComponent }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.meta.requireAuth && !auth.authenticated()) {
    next({path: '/login', query: {redirect: to.fullPath}})
  } else {
    next()
  }
})

export default router
