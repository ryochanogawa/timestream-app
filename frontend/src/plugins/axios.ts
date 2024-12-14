// frontend/src/plugins/axios.ts
import { Plugin } from '@nuxt/types'

const axiosPlugin: Plugin = ({ $axios, redirect }) => {
  // ベースURLを設定
  $axios.setBaseURL('http://localhost:8000/api/v1')

  // デフォルトヘッダーの設定
  $axios.setHeader('Content-Type', 'application/json')

  $axios.defaults.withCredentials = true

  // リクエストインターセプターを追加
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