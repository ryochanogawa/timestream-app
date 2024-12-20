<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\Team\Commands\CreateTeamCommand;
use App\Application\Team\Commands\UpdateTeamCommand;
use App\Application\Team\Queries\GetTeamQuery;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    private CreateTeamCommand $createTeamCommand;
    private UpdateTeamCommand $updateTeamCommand;
    private GetTeamQuery $getTeamQuery;

    public function __construct(
        CreateTeamCommand $createTeamCommand,
        UpdateTeamCommand $updateTeamCommand,
        GetTeamQuery $getTeamQuery
    ) {
        $this->createTeamCommand = $createTeamCommand;
        $this->updateTeamCommand = $updateTeamCommand;
        $this->getTeamQuery = $getTeamQuery;
    }

    /**
     * チーム一覧を取得
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // まだ未実装
        return response()->json(['message' => '未実装']);
    }


    /**
     * チームを作成
     *
     * @param CreateTeamRequest $request
     * @return JsonResponse
     */
    public function store(CreateTeamRequest $request): JsonResponse
    {
        $team = $this->createTeamCommand->execute(
            $request->name,
            $request->description,
            $request->user()->id
        );

        return response()->json($team, Response::HTTP_CREATED);
    }


    /**
     * チームを表示
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $team = $this->getTeamQuery->executeById($id);
            if (!$team) {
                return response()->json(['error' => 'チームが見つかりません。'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($team);
        } catch (Exception $e) {
            return response()->json(['error' => 'チームが見つかりません。', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * オーナーのチームを取得
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOwnerTeam(Request $request): JsonResponse
    {
        $team = $this->getTeamQuery->executeByOwnerId($request->user()->id);
        return response()->json($team);
    }


    /**
     * チームを更新
     *
     * @param UpdateTeamRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, int $id): JsonResponse
    {
        try {
            $team = $this->updateTeamCommand->execute($id, $request->validated());
            return response()->json($team);
        } catch (Exception $e) {
            return response()->json(['error' => 'チームが見つかりません。', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * チームを削除
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->updateTeamCommand->delete($id);
        } catch (Exception $e) {
            return response()->json(['error' => 'チームが見つかりません。', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
