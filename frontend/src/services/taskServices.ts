// services/taskService.ts
import type { Task, CreateTaskPayload, UpdateTaskPayload } from '@/types/task'
import { NuxtAxiosInstance } from '@nuxtjs/axios'


export const taskService = ($axios: NuxtAxiosInstance) => {
  return {
    async getTasks(): Promise<Task[]> {
      // ログインしているユーザー情報のタスクデータの取得
      const response = await $axios.get(`/tasks/`)
      return response.data
    },
  
    async getTask(id: number): Promise<Task> {
      const response = await $axios.get(`/tasks/${id}`)
      return response.data
    },
  
    async createTask(task: CreateTaskPayload): Promise<Task> {
      const response = await $axios.post('/tasks', task)
      return response.data
    },
  
    async updateTask(id: number, task: UpdateTaskPayload): Promise<Task> {
      const response = await $axios.put(`/tasks/${id}`, task)
      return response.data
    },
  
    async deleteTask(id: number): Promise<void> {
      await $axios.delete(`/tasks/${id}`)
    },
  }

}