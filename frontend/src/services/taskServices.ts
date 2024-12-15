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
  
    /**
     * タスクの取得
     * @param id 取得するタスクのID
     * @returns 取得したタスクデータ
     */
    async getTask(id: number): Promise<Task> {
      const response = await $axios.get(`/tasks/${id}`)
      return response.data
    },
  
    /**
     * タスクの作成
     * @param task 作成するタスクデータ
     * @returns 作成したタスクデータ
     */
    async createTask(task: CreateTaskPayload): Promise<Task> {
      console.log($axios)
      const response = await $axios.post('/tasks', task)
      return response.data
    },
  
    /**
     * タスクの更新
     * @param id 更新するタスクのID
     * @param task 更新するタスクデータ
     * @returns 更新したタスクデータ
     */
    async updateTask(id: number, task: UpdateTaskPayload): Promise<Task> {
      console.log($axios)
      const response = await $axios.put(`/tasks/${id}`, task)
      return response.data
    },
  
    /**
     * タスクの削除
     * @param id 削除するタスクのID
     */
    async deleteTask(id: number): Promise<void> {
      await $axios.delete(`/tasks/${id}`)
    },
  }

}