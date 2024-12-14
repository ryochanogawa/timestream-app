// plugins/auth.ts
import { Plugin } from '@nuxt/types'

const authPlugin: Plugin = ({ app }) => {
  app.router?.beforeEach((to, from, next) => {
    if (process.client) {
      next()
    } else {
      next()
    }
  })
}

export default authPlugin