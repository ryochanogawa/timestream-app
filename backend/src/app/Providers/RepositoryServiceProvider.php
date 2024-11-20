<?php
// src/app/Providers/RepositoryServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Infrastructure\Task\Repositories\EloquentTaskRepository;
use App\Application\Task\Commands\CreateTaskCommand;
use App\Application\Task\Commands\UpdateTaskCommand;
use App\Application\Task\Queries\GetTaskListQuery;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // リポジトリの紐付け
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);

        // コマンドの紐付け
        $this->app->bind(CreateTaskCommand::class, function ($app) {
            return new CreateTaskCommand(
                $app->make(TaskRepositoryInterface::class)
            );
        });

        $this->app->bind(UpdateTaskCommand::class, function ($app) {
            return new UpdateTaskCommand(
                $app->make(TaskRepositoryInterface::class)
            );
        });

        $this->app->bind(GetTaskListQuery::class, function ($app) {
            return new GetTaskListQuery(
                $app->make(TaskRepositoryInterface::class)
            );
        });
    }
}