<!-- src/pages/login.vue -->
<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            新規登録
          </h2>
        </div>
        <!-- エラーメッセージ表示 -->
        <div v-if="error" class="rounded-md bg-red-50 p-4">
          <div class="text-sm text-red-700">
            {{ error }}
          </div>
        </div>
        <!-- 成功メッセージ表示 -->
        <div v-if="success" class="rounded-md bg-green-50 p-4">
          <div class="text-sm text-green-700">
            {{ success }}
          </div>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
          <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <label for="username" class="sr-only">名前</label>
                <input
                    id="username"
                    v-model="username"
                    type="text"
                    required
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="名前"
                />
            </div>
            <div>
              <label for="email" class="sr-only">メールアドレス</label>
              <input
                id="email"
                v-model="email"
                type="email"
                required
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="メールアドレス"
              />
            </div>
            <div>
              <label for="password" class="sr-only">パスワード</label>
              <input
                id="password"
                v-model="password"
                type="password"
                required
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="パスワード"
              />
            </div>
          </div>
  
          <div>
            <button
              type="submit"
              :disabled="loading"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
            >
              <span v-if="loading">新規登録中...</span>
              <span v-else>新規登録</span>
            </button>
          </div>
          <div class="text-center">
            <a href="/login" class="text-sm text-gray-500 hover:text-gray-900">
              ログインはこちら
            </a>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <!-- src/pages/login.vue -->
  <script lang="ts">
  import { defineComponent, ref, onMounted } from 'vue'
  import { useContext } from '@nuxtjs/composition-api'
  import { useAuth } from '../composables/useAuth'
  import { useRouter } from '@nuxtjs/composition-api'
  
  export default defineComponent({
    middleware: 'guest',
    
    setup() {
      const username = ref('')
      const email = ref('')
      const password = ref('')
      const error = ref('')
      const success = ref('')
      const loading = ref(false)
      // const { app } = useContext()
      const router = useRouter()
      const { register, initAuth } = useAuth()

      if (!router) {
        console.error('Router is undefined')
      }


      const handleRegister = async () => {
        error.value = ''
        success.value = ''
        loading.value = true
        try {
          await register({
            name: username.value,
            email: email.value,
            password: password.value
          });

          success.value = '新規登録に成功しました。'
          // console.log(router)
          await router.push({ path: '/login', query: {success: success.value}})
        } catch (e) {
          error.value = '新規登録に失敗しました。'
          console.log('error', e)
        }
      }

      onMounted(() => {
        initAuth()
      })
  
      return {
        username,
        email,
        password,
        error,
        success,
        loading,
        handleRegister
      }
    }
  })
  </script>