// components/NavigationHeader.vue
<template>
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- ロゴ/ホーム -->
          <div class="flex-shrink-0 flex items-center">
            <h1 class="text-xl font-bold">Task Manager</h1>
          </div>
          <!-- ナビゲーションリンク -->
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <NuxtLink
              to="/tasks"
              class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
            >
              タスク一覧
            </NuxtLink>
          </div>
        </div>

        <!-- ユーザーメニュー -->
        <div class="flex items-center">
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <div class="relative ml-3">
              <div>
                <button
                  @click="isOpen = !isOpen"
                  class="flex text-sm rounded-full focus:outline-none"
                  id="user-menu-button"
                >
                  <span class="sr-only">メニューを開く</span>
                  <span class="text-gray-700">{{ userName }}</span>
                  <svg
                    class="ml-2 h-5 w-5 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </button>
              </div>

              <!-- ドロップダウンメニュー -->
              <div
                v-if="isOpen"
                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                role="menu"
              >
                
                  <a
                  href="#"
                  @click.prevent="handleLogout"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  role="menuitem"
                >
                  ログアウト
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAuth } from '../composables/useAuth'
import { useRouter } from '@nuxtjs/composition-api'

const router = useRouter()
const { user, logout, initAuth } = useAuth()
const isOpen = ref(false)

const userName = computed(() => {
  initAuth()
  return user.value?.name || 'ユーザー'
})

const handleLogout = async () => {
  try {
    await logout()
    router.push('/login')
  } catch (error) {
    console.error('ログアウトに失敗しました:', error)
  }
}
</script>