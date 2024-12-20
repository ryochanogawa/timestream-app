// frontend/src/services/teamService.ts

import { UpdateTeamPayload, CreateTeamPayload, Team } from '@/types/team';
import { NuxtAxiosInstance } from '@nuxtjs/axios';

/**
 * チームサービス
 * @param $axios NuxtAxiosInstance
 * @returns チームサービス
 */
export const teamService = ($axios: NuxtAxiosInstance) => {
    return {

        /**
         * チームの一覧取得
         * ユーザーIDに紐づくチームの一覧を取得
         * @returns チームの一覧
         */
        async teamList(): Promise<Team[]> {
            const response = await $axios.get('/teams/owner');
            return response.data;
        },

        /**
         * チームの作成
         * @param team 作成するチームデータ
         * @returns 作成したチームデータ
         */
        async createTeam(team: CreateTeamPayload): Promise<Team> {
            const response = await $axios.post('/teams', team);
            return response.data;
        },


        /**
         * チームの更新
         * @param teamId 更新するチームID
         * @param team 更新するチームデータ
         * @returns 更新したチームデータ
         */
        async updateTeam(teamId: number, team: UpdateTeamPayload): Promise<Team> {
            const response = await $axios.put(`/teams/${teamId}`, team);
            return response.data;
        },


        /**
         * チームの削除
         * @param teamId 削除するチームID
         */
        async deleteTeam(teamId: number): Promise<void> {
            await $axios.delete(`/teams/${teamId}`);
        }
    }
}