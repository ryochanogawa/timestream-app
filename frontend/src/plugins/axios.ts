// frontend/src/plugins/axios.ts
import { Plugin } from '@nuxt/types'
import axios from 'axios'

const axiosPlugin: Plugin = ({ $config }, inject) => {
  const api = axios.create({
    baseURL: process.env.API_BASE_URL || 'http://localhost:8000/api/v1',
    headers: {
      'Content-Type': 'application/json',
    },
  })

  inject('api', api)
}

export default axiosPlugin