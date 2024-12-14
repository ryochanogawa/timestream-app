import { Middleware } from '@nuxt/types'

const guest: Middleware = ({ redirect, route }) => {
  if (process.client) {
    const token = localStorage.getItem('token')
    if (token && token !== 'undefined' && route.path === '/login') {
      return redirect('/tasks')
    }
  }
}

export default guest