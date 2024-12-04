import { Middleware } from '@nuxt/types'

const guest: Middleware = ({ redirect }) => {
  if (process.client) {
    const token = localStorage.getItem('token')
    if (token && token !== 'undefined') {
      return redirect('/tasks')
    }
  }
}

export default guest