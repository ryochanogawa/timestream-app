<?php
// src/app/Providers/RepositoryServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\Team\Repositories\TeamRepositoryInterface;
use App\Infrastructure\Task\Repositories\EloquentTaskRepository;
use App\Infrastructure\User\Repositories\EloquentUserRepository;
use App\Infrastructure\Team\Repositories\EloquentTeamRepository;
use App\Application\Task\Commands\CreateTaskCommand;
use App\Application\Task\Commands\UpdateTaskCommand;
use App\Application\User\Commands\LoginUserCommand;
use App\Application\Team\Commands\CreateTeamCommand;
use App\Application\Team\Commands\UpdateTeamCommand;
use App\Application\User\Commands\RegisterUserCommand;
use App\Application\Task\Queries\GetTaskListQuery;
use App\Application\User\Queries\GetUserQuery;
use App\Application\Team\Queries\GetTeamQuery;

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

        // User関連のバインディングを追加
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        // User関連のコマンドの紐付け
        $this->app->bind(RegisterUserCommand::class, function ($app) {
            return new RegisterUserCommand(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->bind(LoginUserCommand::class, function ($app) {
            return new LoginUserCommand(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->bind(GetUserQuery::class, function ($app) {
            return new GetUserQuery(
                $app->make(UserRepositoryInterface::class)
            );
        });


        // Team関連のバインディングを追加
        $this->app->bind(TeamRepositoryInterface::class, EloquentTeamRepository::class);
        $this->app->bind(CreateTeamCommand::class, function ($app) {
            return new CreateTeamCommand(
                $app->make(TeamRepositoryInterface::class)
            );
        });

        $this->app->bind(UpdateTeamCommand::class, function ($app) {
            return new UpdateTeamCommand(
                $app->make(TeamRepositoryInterface::class)
            );
        });

        $this->app->bind(GetTeamQuery::class, function ($app) {
            return new GetTeamQuery(
                $app->make(TeamRepositoryInterface::class)
            );
        });
    }
}
