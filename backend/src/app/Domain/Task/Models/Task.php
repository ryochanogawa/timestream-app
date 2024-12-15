<?php

// app/Domain/Task/Models/Task.php

namespace app\Domain\Task\Models;

use App\Domain\Task\ValueObjects\TaskStatus;
use App\Domain\Task\ValueObjects\TaskPriority;
use DateTime;

class Task
{
    private ?int $id;
    private string $title;
    private ?string $description;
    private ?DateTime $dueDate;
    private TaskStatus $status;
    private TaskPriority $priority;
    private int $userId;

    public function __construct(
        string $title,
        ?string $description = null,
        ?DateTime $dueDate = null,
        ?TaskStatus $status = null,
        ?TaskPriority $priority = null,
        ?int $id = null,
        int $userId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->status = $status ?? TaskStatus::TODO;
        $this->priority = $priority ?? TaskPriority::MEDIUM;
        $this->userId = $userId;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getPriority(): TaskPriority
    {
        return $this->priority;
    }

    // 状態を変更するメソッド
    public function updateStatus(TaskStatus $newStatus): void
    {
        $this->status = $newStatus;
    }

    public function updatePriority(TaskPriority $newPriority): void
    {
        $this->priority = $newPriority;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}