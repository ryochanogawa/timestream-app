<?php

// app/Domain/Task/Repositories/TaskRepositoryInterface.php

namespace App\Domain\Task\Repositories;

use App\Domain\Task\Models\Task;

interface TaskRepositoryInterface
{
    public function findById(int $id): ?Task;
    public function findAll(): array;
    public function save(Task $task): Task;
    public function delete(int $id): bool;
}