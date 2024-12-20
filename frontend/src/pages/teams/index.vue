<!-- pages/teams/index.vue -->

<template>
    <div>
        <NavigationHeader />
        <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">チーム一覧</h1>
            <button
            @click="showForm = true"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors"
            >
            新規チーム作成
            </button>
        </div>
    
        <div v-if="loading" class="text-center py-4">
            <p>読み込み中...</p>
        </div>
    
        <div v-else-if="error" class="text-red-600 py-4">
            {{ error }}
        </div>
    
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
            v-for="teams in team"
            :key="teams.id"
            class="bg-white p-6 rounded-lg shadow-md"
            >
            <h2 class="text-xl font-semibold mb-2">{{ teams.name }}</h2>
            <p class="text-gray-600 mb-4">{{ teams.description || '説明なし' }}</p>
            <div class="flex justify-end space-x-2">
                <button
                @click="editTeam(teams)"
                class="text-blue-500 hover:text-blue-600"
                >
                編集
                </button>
                <button
                @click="confirmDelete(teams)"
                class="text-red-500 hover:text-red-600"
                >
                削除
                </button>
            </div>
            </div>
        </div>
    
        <!-- チーム作成/編集モーダル -->
        <TeamForm
            v-if="showForm"
            :team="selectedTeam"
            @submit="handleSubmit"
            @cancel="closeForm"
        />
    
        <!-- 削除確認モーダル -->
        <div v-if="showDeleteConfirm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-xl">
            <p class="mb-4">本当にこのチームを削除しますか？</p>
            <div class="flex justify-end space-x-2">
                <button
                @click="teamDelete"
                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                >
                削除
                </button>
                <button
                @click="showDeleteConfirm = false"
                class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
                >
                キャンセル
                </button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from '@nuxtjs/composition-api';
import { useTeam } from '../../composables/useTeam';
import type { Team, CreateTeamPayload } from '../../types/team';
import { useAuth } from '../../composables/useAuth';
import NavigationHeader from '../../components/NavigationHeader.vue';
const router = useRouter()
const { user, initAuth } = useAuth()
const {
    team,
    loading,
    error,
    createTeam,
    updateTeam,
    deleteTeam,
    fetchTeamList
} = useTeam()

const showForm = ref(false)
const selectedTeam = ref<Team | null>(null)
const showDeleteConfirm = ref(false)

/**
 * ユーザー認証
 */
onMounted(async () => {
    await initAuth()
    if (!user.value?.id) {
        console.error('ユーザーが認証されていません')
        router.push('/')
        return
    }

    try {
        await fetchTeamList()
    } catch (error) {
        console.error('チームの取得に失敗しました:', error)
    }
})


/**
 * チームフォームを閉じる
 */
const closeForm = () => {
    showForm.value = false
    selectedTeam.value = null
}

/**
 * チームフォームのデータを送信
 */
const handleSubmit = async (teamData: CreateTeamPayload) => {
    if (selectedTeam.value) {
        await updateTeam(selectedTeam.value.id, teamData)
        await fetchTeamList()
    } else {
        await createTeam(teamData)
        await fetchTeamList()
    }
    closeForm()
}

/**
 * チームの編集
 * @param team 編集するチーム
 */
const editTeam = (team: Team) => {
    selectedTeam.value = team
    showForm.value = true
}


/**
 * チームの削除確認
 * @param team 削除するチーム
 */
const confirmDelete = (team: Team) => {
    selectedTeam.value = team
    showDeleteConfirm.value = true
}


/**
 * チーム削除処理の実行
 * @var selectedTeam 削除するチーム
 */
const teamDelete = async () => {
    if (!selectedTeam.value) {
        console.error('削除するチームが選択されていません')
        return
    }

    try {
        await deleteTeam(selectedTeam.value.id)
    } catch (error) {
        console.error('チームの削除に失敗しました:', error)
    }
    showDeleteConfirm.value = false
    selectedTeam.value = null
    await fetchTeamList()
}


</script>
