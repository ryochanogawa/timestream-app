// plugins/auth.ts
import { Plugin } from '@nuxt/types'

const authPlugin: Plugin = ({ app }) => {
  app.router?.beforeEach((to, from, next) => {
    if (process.client) {
      const token = localStorage.getItem('token')
      console.log(to.path)
      console.log(token)
      if ((!token || token == 'undefined') && to.path !== '/login') {
        //next('src/login')
        next('/login')
        console.log('@@@@@@@@')
        //window.location.href = '/login'
      } else if ((token && token !== 'undefined') && to.path === '/login') {
        next('/tasks')
      }else {
        next()
      }
    } else {
      next()
    }
  })
}

export default authPlugin