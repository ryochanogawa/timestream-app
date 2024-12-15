<?php

namespace App\Application\Task\Commands;

use App\Domain\Task\Models\Task;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\ValueObjects\TaskStatus;

class UpdateTaskCommand
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function execute(int $id, array $data): ?Task
    {
        $task = $this->taskRepository->findById($id);
        if (!$task) {
            return null;
        }

        // 更新処理の実装
        $updatedTask = new Task(
            title: $data['title'] ?? $task->getTitle(),
            description: $data['description'] ?? $task->getDescription(),
            dueDate: isset($data['due_date']) && $data['due_date'] ? new DateTime($data['due_date']) : $task->getDueDate(),
            status: isset($data['status']) && $data['status'] ? TaskStatus::fromOrDefault($data['status']) : $task->getStatus(),
            priority: isset($data['priority']) && $data['priority'] ? TaskPriority::fromOrDefault($data['priority']) : $task->getPriority(),
            id: $id,
            userId: $task->getUserId()
        );

        return $this->taskRepository->save($updatedTask);
    }

    public function delete(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }
}