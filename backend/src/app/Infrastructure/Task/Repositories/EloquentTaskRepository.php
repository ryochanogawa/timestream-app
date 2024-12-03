<?php

namespace App\Infrastructure\Task\Repositories;

use App\Domain\Task\Models\Task;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Models\Task as TaskModel;
use App\Domain\Task\ValueObjects\TaskStatus;
use App\Domain\Task\ValueObjects\TaskPriority;
use DateTime;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    /**
     * 全タスクの取得
     *
     * @return array
     */
    public function findAll(): array
    {
        //\Log::info('リポジトリ: 全タスク取得開始');
        $tasks = TaskModel::all();

        $result = $tasks->map(function (TaskModel $task) {
            $entity = $this->toEntity($task);
            return [
                'id' => $entity->getId(),
                'title' => $entity->getTitle(),
                'description' => $entity->getDescription(),
                'due_date' => $entity->getDueDate()?->format('Y-m-d'),
                'status' => $entity->getStatus(),
                'priority' => $entity->getPriority(),
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at
            ];
        })->all();

        //\Log::info('リポジトリ: 全タスク取得完了', ['count' => count($result)]);
        // arrayに変換

        return $result;
    }

    public function findById(int $id): ?Task
    {
        $task = TaskModel::find($id);
        return $task ? $this->toEntity($task) : null;
    }

    public function findByUserId(int $userId): array
    {
        $tasks = TaskModel::where('user_id', $userId)->get();
        return $tasks->map(function (TaskModel $task) {
            return $this->toEntity($task);
        })->all();
    }

    public function save(Task $task): Task
    {
        $taskModel = $task->getId()
            ? TaskModel::find($task->getId())
            : new TaskModel();
        \Log::info($taskModel);

        $taskModel->fill([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'due_date' => $task->getDueDate()?->format('Y-m-d'),
            'status' => $task->getStatus()->value,
            'priority' => $task->getPriority()->value
        ]);

        $taskModel->save();

        return $this->toEntity($taskModel);
    }

    public function delete(int $id): bool
    {
        return TaskModel::destroy($id) > 0;
    }

    private function toEntity(TaskModel $model): Task
    {
        return new Task(
            title: $model->title,
            description: $model->description,
            dueDate: $model->due_date ? DateTime::createFromFormat('Y-m-d H:i:s', $model->due_date) : null,
            status: TaskStatus::fromOrDefault($model->status),
            priority: TaskPriority::fromOrDefault($model->priority),
            id: $model->id,
            userId: $model->user_id
        );
    }
}
