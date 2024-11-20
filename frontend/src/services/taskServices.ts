// services/taskService.ts
import type { Task, CreateTaskPayload, UpdateTaskPayload } from '@/types/task'
import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api/v1',
})

export const taskService = {
  async getTasks(): Promise<Task[]> {
    const response = await api.get('/tasks')
    return response.data
  },

  async getTask(id: number): Promise<Task> {
    const response = await api.get(`/tasks/${id}`)
    return response.data
  },

  async createTask(task: CreateTaskPayload): Promise<Task> {
    const response = await api.post('/tasks', task)
    return response.data
  },

  async updateTask(id: number, task: UpdateTaskPayload): Promise<Task> {
    const response = await api.put(`/tasks/${id}`, task)
    return response.data
  },

  async deleteTask(id: number): Promise<void> {
    await api.delete(`/tasks/${id}`)
  },
}