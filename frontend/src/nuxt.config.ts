// frontend/src/nuxt.config.ts
import { NuxtConfig } from '@nuxt/types'

const config: NuxtConfig = {
  // Target
  target: 'static',

  // Global page headers
  head: {
    title: 'TimeStream',
    htmlAttrs: {
      lang: 'ja'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Task Management Application' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS
  css: [
    '@/assets/css/main.css'
  ],

  // Plugins
  plugins: [
    '~/plugins/axios'
  ],

  // Auto import components
  components: true,

  // Build modules
  buildModules: [
    '@nuxt/typescript-build',
    '@nuxtjs/tailwindcss'
  ],

  // Modules
  modules: [
    '@nuxtjs/axios'
  ],

  // Axios module configuration
  axios: {
    baseURL: process.env.API_BASE_URL || 'http://localhost:8000/api/v1',
    credentials: true
  },

  // Build Configuration
  build: {
    postcss: {
      postcssOptions: {
        plugins: {
          'tailwindcss': {},
          'autoprefixer': {},
        }
      }
    }
  },

  // Server setup
  server: {
    host: '0.0.0.0',
    port: 3000
  }
}

export default config