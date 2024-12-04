// frontend/src/plugins/axios.ts
import { Plugin } from '@nuxt/types'

const axiosPlugin: Plugin = ({ $axios, redirect }) => {
  $axios.onRequest(config => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.common['Authorization'] = `Bearer ${token}`
    }
    return config
  })

  $axios.onError(error => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token')
      redirect('/login')
    }
    return Promise.reject(error)
  })
}

export default axiosPlugin