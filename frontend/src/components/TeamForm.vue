// components/TeamForm.vue
<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
      <h2 class="text-xl font-semibold mb-4">
        {{ team ? 'チームを編集' : '新規チーム作成' }}
      </h2>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">
            チーム名
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            :class="{ 'border-red-500': errors.name }"
          />
          <p v-if="errors.name" class="mt-1 text-sm text-red-600">
            {{ errors.name }}
          </p>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">
            説明
          </label>
          <textarea
            id="description"
            v-model="form.description"
            rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          ></textarea>
        </div>

        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="$emit('cancel')"
            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
          >
            キャンセル
          </button>
          <button
            type="submit"
            class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600"
            :disabled="loading"
          >
            {{ loading ? '保存中...' : '保存' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import type { Team, CreateTeamPayload } from '../types/team'

/**
 * チームフォームのプロパティ
 */
const props = defineProps<{
    team?: Team
  }>()

/**
 * チームフォームのイベント
 */
const emit = defineEmits<{
    (e: 'submit', team: CreateTeamPayload): void
}>()

/**
 * チームフォームのフォームデータ
 */
const form = ref<CreateTeamPayload>({
    name: '',
    description: '',
})

/**
 * ローディング状態
 * ローディング中はボタンを無効化
 */
const loading = ref(false)

/**
 * エラー
 */
const errors = ref<Record<string, string>>({})


/**
 * チームフォームのデータを設定
 * チームがある場合はチームデ���タを設定
 */
onMounted(() => {
    if (props.team) {
        form.value = {
            name: props.team.name,
            description: props.team.description,
        }
    }
})


/**
 * チームフォームのデータを送信
 */
const handleSubmit = () => {
    console.log('送信するデータ');
    emit('submit', form.value)
}

</script>