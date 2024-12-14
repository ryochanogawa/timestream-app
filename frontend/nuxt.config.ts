// frontend/src/nuxt.config.ts
import { NuxtConfig } from '@nuxt/types'

const config: NuxtConfig = {

  srcDir: 'src/',
  ssr: false,

  // Target (SSR無効化に伴いspaに変更)
  target: 'static',
  mode: 'spa',


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
    '@/assets/css/main.css',
    '@/assets/css/tailwind.css',
  ],

  // Plugins
  plugins: [
    '~/plugins/axios',
    '~/plugins/auth'
  ],

  // Auto import components
  components: true,

  // Build modules
  buildModules: [
    '@nuxt/typescript-build',
    '@nuxtjs/tailwindcss',
    ['@nuxtjs/composition-api/module', { baseUrl: 'http://localhost:3000' }]
    // '@nuxtjs/composition-api/module'
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
    },
    devtools: true
  },

  router: {
    middleware: ['auth', 'guest'],
    extendRoutes(routes, resolve) {
      routes.push({
        path: '/',
        redirect: '/login'
      })
    }
  },

  // リダイレクト時のエラーを防ぐために追加
  generate: {
    fallback: true
  },

  // Server setup
  server: {
    host: '0.0.0.0',
    port: 3000
  }
}

export default config