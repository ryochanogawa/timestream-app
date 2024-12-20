// frontend/src/composables/useTasks.ts
import { ref, computed } from 'vue'
import { Task, CreateTaskPayload, UpdateTaskPayload, TaskStatus } from '@/types/task'
import { taskService } from '@/services/taskServices'
import { useContext } from '@nuxtjs/composition-api'

export const useTasks = () => {
  const tasks = ref<Task[]>([])
  const loading = ref<boolean>(false)
  const error = ref<string | null>(null)
  const { $axios } = useContext()
  const createTaskService = taskService($axios)

  /**
   * タスクを取得する
   * ログインしているユーザーのタスクデータを取得する
   */
  const fetchTasks = async (): Promise<void> => {
    loading.value = true
    error.value = null
    try {
      tasks.value = await createTaskService.getTasks()
    } catch (e) {
      error.value = '取得に失敗しました'
      console.error(e)
    } finally {
      loading.value = false
    }
  }

  const createTask = async (taskData: CreateTaskPayload): Promise<void> => {
    loading.value = true
    error.value = null
    try {
      const newTask = await createTaskService.createTask(taskData)
      tasks.value.push(newTask)
    } catch (e) {
      error.value = '作成に失敗しました'
      console.error(e)
    } finally {
      loading.value = false
    }
  }

  /**
   * タスクを更新する
   * タスクのステータスを更新する
   * @param id タスクID
   * @param taskData 更新するタスクデータ
   */
  const updateTask = async (id: number, taskData: UpdateTaskPayload): Promise<void> => {
    loading.value = true
    error.value = null
    try {
      const updatedTask = await createTaskService.updateTask(id, taskData)
      const index = tasks.value.findIndex(task => task.id === id)
      if (index !== -1) {
        tasks.value[index] = updatedTask
      }
    } catch (e) {
      error.value = '更新に失敗しました'
      console.error(e)
    } finally {
      loading.value = false
    }
  }

  const deleteTask = async (id: number): Promise<void> => {
    loading.value = true
    error.value = null
    try {
      await createTaskService.deleteTask(id)
      tasks.value = tasks.value.filter(task => task.id !== id)
    } catch (e) {
      error.value = '削除に失敗しました'
      console.error(e)
    } finally {
      loading.value = false
    }
  }

  const tasksByStatus = computed(() => ({
    todo: tasks.value.filter(task => task.status === 'todo'),
    in_progress: tasks.value.filter(task => task.status === 'in_progress'),
    done: tasks.value.filter(task => task.status === 'done')
  }))

  return {
    tasks,
    loading,
    error,
    tasksByStatus,
    fetchTasks,
    createTask,
    updateTask,
    deleteTask
  }
}