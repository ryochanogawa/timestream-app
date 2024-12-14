// frontend/src/types/task.ts

/**
 * タスクステータス
 * enumを使用して、タスクステータスを定義
 */
export enum TaskStatus {
    TODO = 'todo',
    IN_PROGRESS = 'in_progress',
    DONE = 'done'
  }
  
  /**
   * タスク優先度
   * enumを使用して、タスク優先度を定義
   */
  export enum TaskPriority {
    LOW = 'low',
    MEDIUM = 'medium',
    HIGH = 'high'
  }
  
  /**
   * タスク
   * タスクの型定義
   * @param id: タスクID
   * @param user_id: ユーザーID
   * @param title: タスクタイトル
   * @param description: タスク説明
   * @param due_date: タスク期限
   * @param status: タスクステータス
   * @param priority: タスク優先度
   * @param created_at: タスク作成日時
   * @param updated_at: タスク更新日時
   */
  export interface Task {
    id: number;
    user_id: number;
    title: string;
    description: string | null;
    due_date: string | null;
    status: TaskStatus;
    priority: TaskPriority;
    created_at: string;
    updated_at: string;
  }
  
  /**
   * タスク作成時のペイロード
   * タスク作成時にはid, created_at, updated_atは不要
   * Omitを使用して、Taskからid, created_at, updated_atを除外
   */
  export type CreateTaskPayload = Omit<Task, 'id' | 'created_at' | 'updated_at'>;

  /**
   * タスク更新時のペイロード
   * タスク更新時にはidは不要
   * Partialを使用して、CreateTaskPayloadの型をPartialに変換
   */
  export type UpdateTaskPayload = Partial<CreateTaskPayload>;