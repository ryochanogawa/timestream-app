<!-- frontend/src/components/TaskForm.vue -->
<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
        <input
          id="title"
          v-model="form.title"
          type="text"
          required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        />
      </div>
  
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">説明</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="3"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        />
      </div>
  
      <div>
        <label for="due_date" class="block text-sm font-medium text-gray-700">期限</label>
        <input
          id="due_date"
          v-model="form.due_date"
          type="date"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        />
      </div>
  
      <div>
        <label for="priority" class="block text-sm font-medium text-gray-700">優先度</label>
        <select
          id="priority"
          v-model="form.priority"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        >
          <option value="low">低</option>
          <option value="medium">中</option>
          <option value="high">高</option>
        </select>
      </div>
  
      <div class="flex justify-end space-x-2">
        <button
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          {{ task ? '更新' : '作成' }}
        </button>
      </div>
    </form>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import type { Task, CreateTaskPayload } from '../types/task'
  
  const props = defineProps<{
    task?: Task
  }>()
  
  const emit = defineEmits<{
    (e: 'submit', task: CreateTaskPayload): void
  }>()
  
  const form = ref<CreateTaskPayload>({
    title: '',
    description: '',
    due_date: null,
    status: 'todo',
    priority: 'medium'
  })
  
  onMounted(() => {
    if (props.task) {
      form.value = {
        title: props.task.title,
        description: props.task.description,
        due_date: props.task.due_date,
        status: props.task.status,
        priority: props.task.priority
      }
    }
  })
  
  const handleSubmit = () => {
    console.log('送信するデータ');
    emit('submit', form.value)
  }
  </script>