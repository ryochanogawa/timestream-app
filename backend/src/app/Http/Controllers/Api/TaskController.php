<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\Task\Commands\CreateTaskCommand;
use App\Application\Task\Commands\UpdateTaskCommand;
use App\Application\Task\Queries\GetTaskListQuery;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private CreateTaskCommand $createTaskCommand;
    private UpdateTaskCommand $updateTaskCommand;
    private GetTaskListQuery $getTaskListQuery;

    public function __construct(
        CreateTaskCommand $createTaskCommand,
        UpdateTaskCommand $updateTaskCommand,
        GetTaskListQuery $getTaskListQuery
    ) {
        $this->createTaskCommand = $createTaskCommand;
        $this->updateTaskCommand = $updateTaskCommand;
        $this->getTaskListQuery = $getTaskListQuery;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $tasks = $this->getTaskListQuery->execute($request->user()->id);
            return response()->json($tasks);
        } catch (\Exception $e) {
            return response()->json(['error' => '処理中にエラーが発生しました。', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $task = $this->createTaskCommand->execute(
            $request->title,
            $request->description,
            $request->due_date,
            $request->status,
            $request->priority,
            $request->user()->id
        );

        return response()->json($task, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->getTaskListQuery->executeById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            // リクエストデータを受け取る
            $task = $this->updateTaskCommand->execute($id, $validated);
        } catch (Exception $e) {
            \Log::error('エラーが発生しました: ' . $e->getMessage());
            return response()->json(['error' => '更新中にエラーが発生しました。'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return response()->json($task);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->updateTaskCommand->delete($id);
        } catch (Exception $e) {
            return response()->json(['error' => '処理中にエラーが発生しました。', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}