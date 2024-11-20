// frontend/src/types/task.ts
export enum TaskStatus {
    TODO = 'todo',
    IN_PROGRESS = 'in_progress',
    DONE = 'done'
  }
  
  export enum TaskPriority {
    LOW = 'low',
    MEDIUM = 'medium',
    HIGH = 'high'
  }
  
  export interface Task {
    id: number;
    title: string;
    description: string | null;
    due_date: string | null;
    status: TaskStatus;
    priority: TaskPriority;
    created_at: string;
    updated_at: string;
  }
  
  export type CreateTaskPayload = Omit<Task, 'id' | 'created_at' | 'updated_at'>;
  export type UpdateTaskPayload = Partial<CreateTaskPayload>;