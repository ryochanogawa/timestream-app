<?php

namespace App\Application\Task\Commands;

use App\Domain\Task\Models\Task;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\ValueObjects\TaskStatus;
use App\Domain\Task\ValueObjects\TaskPriority;
use DateTime;

class CreateTaskCommand
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function execute(
        string $title,
        ?string $description,
        ?string $dueDate,
        string $status = 'todo',
        string $priority = 'medium',
        int $userId
    ): Task {
        $task = new Task(
            title: $title,
            description: $description,
            dueDate: $dueDate ? new DateTime($dueDate) : null,
            status: TaskStatus::fromOrDefault($status),
            priority: TaskPriority::fromOrDefault($priority),
            id: null,
            userId: $userId
        );

        return $this->taskRepository->save($task);
    }
}