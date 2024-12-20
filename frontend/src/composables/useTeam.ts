// frontend/src/composables/useTeam.ts

import { UpdateTeamPayload, CreateTeamPayload, Team } from '@/types/team';
import { ref, computed } from 'vue';
import { useContext } from '@nuxtjs/composition-api';
import { teamService } from '@/services/teamService';

export const useTeam = () => {
    const team = ref<Team[]>([]);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);
    const { $axios } = useContext();
    const createTeamService = teamService($axios);

    /**
     * チームの一覧取得
     * ログインしているユーザーのチームの一覧を取得
     */
    const fetchTeamList = async (): Promise<void> => {
        loading.value = true;
        error.value = null;
        try {
            team.value = await createTeamService.teamList();
        } catch (e) {
            error.value = '取得に失敗しました';
            console.error(e);
        } finally {
            loading.value = false;
        }
    }

    /**
     * チームの作成
     * @param teamData 作成するチームデータ
     */
    const createTeam = async (teamData: CreateTeamPayload): Promise<void> => {
        loading.value = true;
        error.value = null;

        try {
            const newTeam = await createTeamService.createTeam(teamData);
            team.value.push(newTeam);
        } catch (e) {
            error.value = '作成に失敗しました';
            console.error(e);
        } finally {
            loading.value = false;
        }
    }

    /**
     * チームの更新
     * @param teamId 更新するチームID
     * @param teamData 更新するチームデータ
     */
    const updateTeam = async (teamId: number, teamData: UpdateTeamPayload): Promise<void> => {
        loading.value = true;
        error.value = null;

        try {
            const updatedTeam = await createTeamService.updateTeam(teamId, teamData);
            const index = team.value.findIndex(team => team.id === teamId);
            if (index !== -1) {
                team.value[index] = updatedTeam;
            }
        } catch (e) {
            error.value = '更新に失敗しました';
            console.error(e);
        } finally {
            loading.value = false;
        }
    }

    /**
     * チームの削除
     * @param teamId 削除するチームID
     */
    const deleteTeam = async (teamId: number): Promise<void> => {
        loading.value = true;
        error.value = null;

        try {
            await createTeamService.deleteTeam(teamId);
        } catch (e) {
            error.value = '削除に失敗しました';
            console.error(e);
        } finally {
            loading.value = false;
        }
    }


    return {
        team,
        loading,
        error,
        createTeam,
        updateTeam,
        deleteTeam,
        fetchTeamList
    }
}