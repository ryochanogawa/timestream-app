import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL, decode } from 'ufo'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _1cd9f278 = () => interopDefault(import('../src/pages/login.vue' /* webpackChunkName: "pages/login" */))
const _02f16b98 = () => interopDefault(import('../src/pages/register.vue' /* webpackChunkName: "pages/register" */))
const _63e0f869 = () => interopDefault(import('../src/pages/tasks.vue' /* webpackChunkName: "pages/tasks" */))

const emptyFn = () => {}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/login",
    component: _1cd9f278,
    name: "login"
  }, {
    path: "/register",
    component: _02f16b98,
    name: "register"
  }, {
    path: "/tasks",
    component: _63e0f869,
    name: "tasks"
  }, {
    path: "/",
    redirect: "/login"
  }],

  fallback: false
}

export function createRouter (ssrContext, config) {
  const base = (config._app && config._app.basePath) || routerOptions.base
  const router = new Router({ ...routerOptions, base  })

  // TODO: remove in Nuxt 3
  const originalPush = router.push
  router.push = function push (location, onComplete = emptyFn, onAbort) {
    return originalPush.call(this, location, onComplete, onAbort)
  }

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    return resolve(to, current, append)
  }

  return router
}
