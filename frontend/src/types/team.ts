// frontend/src/types/Team.ts

/**
 * チーム
 * チームの型定義
 * @param id: チームID
 * @param name: チーム名
 * @param description: チーム説明
 * @param owner_id: オーナーID
 * @param created_at: 作成日時
 * @param updated_at: 更新日時
 */
export interface Team {
    id: number;
    name: string;
    description: string | null;
    owner_id: number;
    created_at: string;
    updated_at: string;
}

/**
 * チーム作成時のペイロード
 * チーム作成時にはidは不要
 * Omitを使用して、Teamからidを除外
 */
export type CreateTeamPayload = Omit<Team, 'id' | 'created_at' | 'updated_at'| 'owner_id'>;

/**
 * チーム更新時のペイロード
 * チーム更新時にはidは必須
 * チーム更新時にはowner_idは更新できない
 * Partialを使用して、CreateTeamPayloadの型をPartialに変換
 */
export type UpdateTeamPayload = Partial<CreateTeamPayload>;
