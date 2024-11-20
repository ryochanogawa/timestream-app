<?php

namespace App\Application\Task\Queries;

use App\Domain\Task\Repositories\TaskRepositoryInterface;

class GetTaskListQuery
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function execute(): array
    {
        return $this->taskRepository->findAll();
    }

    public function executeById(int $id)
    {
        return $this->taskRepository->findById($id);
    }
}
