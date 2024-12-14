<!-- src/pages/login.vue -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          ログイン
        </h2>
      </div>
      <!-- エラーメッセージ表示 -->
      <div v-if="error" class="rounded-md bg-red-50 p-4">
        <div class="text-sm text-red-700">
          {{ error }}
        </div>
      </div>
      <!-- 成功メッセージ表示 -->
      <div v-if="successMessage" class="rounded-md bg-green-50 p-4">
        <div class="text-sm text-green-700">
          {{ successMessage }}
        </div>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email" class="sr-only">メールアドレス</label>
            <input
              id="email"
              v-model="email"
              type="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
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
            <span v-if="loading">ログイン中...</span>
            <span v-else>ログイン</span>
          </button>
        </div>
        <div class="text-center">
          <a href="/register" class="text-sm text-gray-500 hover:text-gray-900">
            新規登録はこちら
          </a>
        </div>
      </form>
    </div>
  </div>
</template>

<!-- src/pages/login.vue -->
<script lang="ts">
console.log('login.vue')
import { defineComponent, ref } from 'vue'
import { useContext } from '@nuxtjs/composition-api'
import { useRoute, useRouter } from '@nuxtjs/composition-api'
import { useAuth } from '../composables/useAuth'

export default defineComponent({
  middleware: 'guest',
  
  setup() {
    const email = ref('')
    const password = ref('')
    const error = ref('')
    const loading = ref(false)
    const router = useRouter()
    const route = useRoute()
    const successMessage = ref(route.value.query?.success || '')

    const handleLogin = async () => {
      error.value = ''
      loading.value = true
      
      try {
        await useAuth().login({
          email: email.value,
          password: password.value
        })

        await router.push('/tasks')
        console.log('ログイン成功')
      } catch (e) {
        error.value = 'ログインに失敗しました。メールアドレスとパスワードを確認してください。'
      } finally {
        loading.value = false
      }
    }

    return {
      email,
      password,
      error,
      successMessage,
      loading,
      handleLogin
    }
  }
})
</script>