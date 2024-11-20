<!-- frontend/src/pages/index.vue -->
<template>
  <div class="container mx-auto px-4 py-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">
        タスク管理
      </h1>
      <button
        @click="showForm = true"
        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors"
      >
        新規タスク作成
      </button>
    </div>

    <div v-if="loading" class="text-center py-4">
      <p>読み込み中...</p>
    </div>

    <div v-else-if="error" class="text-red-600 py-4">
      {{ error }}
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- ToDo列 -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">ToDo</h2>
        <div class="space-y-4">
          <div
            v-for="task in tasksByStatus.todo"
            :key="task.id"
            class="bg-white p-4 rounded-lg shadow-sm"
          >
            <h3 class="font-medium">{{ task.title }}</h3>
            <p class="text-sm text-gray-600">{{ task.description }}</p>
            <div class="mt-2 flex items-center justify-between">
              <span class="text-sm text-gray-500">
                期限: {{ formatDate(task.due_date) }}
              </span>
              <div class="flex space-x-2">
                <button
                  @click="handleStatusChange(task.id, TaskStatus.IN_PROGRESS)"
                  class="text-sm px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                  開始
                </button>
              </div>
            </div>
          </div>
          <div v-if="tasksByStatus.todo.length === 0" class="text-gray-500 text-center py-4">
            タスクがありません
          </div>
        </div>
      </div>

      <!-- 進行中列 -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">進行中</h2>
        <div class="space-y-4">
          <div
            v-for="task in tasksByStatus.in_progress"
            :key="task.id"
            class="bg-white p-4 rounded-lg shadow-sm"
          >
            <h3 class="font-medium">{{ task.title }}</h3>
            <p class="text-sm text-gray-600">{{ task.description }}</p>
            <div class="mt-2 flex items-center justify-between">
              <span class="text-sm text-gray-500">
                期限: {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '未設定' }}
              </span>
              <div class="flex space-x-2">
                <button
                  @click="handleStatusChange(task.id, TaskStatus.DONE)"
                  class="text-sm px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600"
                >
                  完了
                </button>
              </div>
            </div>
          </div>
          <div v-if="tasksByStatus.in_progress.length === 0" class="text-gray-500 text-center py-4">
            タスクがありません
          </div>
        </div>
      </div>

      <!-- 完了列 -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">完了</h2>
        <div class="space-y-4">
          <div
            v-for="task in tasksByStatus.done"
            :key="task.id"
            class="bg-white p-4 rounded-lg shadow-sm"
          >
            <h3 class="font-medium">{{ task.title }}</h3>
            <p class="text-sm text-gray-600">{{ task.description }}</p>
            <div class="mt-2 flex items-center justify-between">
              <span class="text-sm text-gray-500">
                期限: {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '未設定' }}
              </span>
              <div class="flex space-x-2">
                <button
                  @click="handleDeleteTask(task.id)"
                  class="text-sm px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                >
                  削除
                </button>
              </div>
            </div>
          </div>
          <div v-if="tasksByStatus.done.length === 0" class="text-gray-500 text-center py-4">
            タスクがありません
          </div>
        </div>
      </div>
    </div>

    <!-- タスク作成/編集モーダル -->
    <div
      v-if="showForm"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
    >
      <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">
          {{ selectedTask ? 'タスクの編集' : '新規タスク作成' }}
        </h2>
        <TaskForm
          :task="selectedTask"
          @submit="handleSubmit"
        />
        <div class="mt-4 flex justify-end space-x-2">
          <button
            @click="closeForm"
            class="px-4 py-2 text-gray-600 hover:text-gray-800"
          >
            キャンセル
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useTasks } from '../composables/useTasks'
import type { CreateTaskPayload, Task } from '../types/task'
import { TaskStatus } from '../types/task'  // 追加
import TaskForm from '../components/TaskForm.vue'

const showForm = ref(false)
const selectedTask = ref<Task | null>(null)
const {
  tasks,
  loading,
  error,
  tasksByStatus,
  fetchTasks,
  createTask,
  updateTask: updateTaskStatus,
  deleteTask: deleteTask
} = useTasks()

onMounted(() => {
  fetchTasks()
})

const closeForm = () => {
  showForm.value = false
  selectedTask.value = null
}

const handleSubmit = async (taskData: CreateTaskPayload) => {
  if (selectedTask.value) {
    await updateTaskStatus(selectedTask.value.id, taskData)
  } else {
    await createTask(taskData)
  }
  closeForm()
}

const handleStatusChange = async (taskId: number, newStatus: TaskStatus) => {
  try {
    await updateTaskStatus(taskId, { status: newStatus })
    await fetchTasks()
  } catch (error) {
    console.error('タスクの更新に失敗しました:', error)
  }
}

const formatDate = (dateString: string) => {
  if (!dateString) return '未設定';
  const [year, month, day] = dateString.split('-').map(Number);
  const date = new Date(year, month - 1, day);

  return date.toLocaleDateString('ja-JP', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit'
  });
};

// タスクの削除
const handleDeleteTask = async (taskId: number) => {
  try {
    await deleteTask(taskId)
    await fetchTasks()
  } catch (error) {
    console.error('タスクの削除に失敗しました:', error)
  }
}
</script>