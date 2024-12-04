import { Middleware } from '@nuxt/types'

const auth: Middleware = ({ redirect, route }) => {
  if (process.client) {
    const token = localStorage.getItem('token')
    if ((!token || token === 'undefined') && route.path !== '/login') {
      return redirect('/login')
    }
  }
}

export default auth