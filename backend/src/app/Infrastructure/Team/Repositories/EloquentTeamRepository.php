<?php

namespace App\Infrastructure\Team\Repositories;

use App\Domain\Team\Repositories\TeamRepositoryInterface;
use App\Models\Team as TeamModel;
use App\Domain\Team\Models\Team;
use Illuminate\Support\Collection;
use DateTime;
use Exception;

/**
 * Eloquentを使用したTeamリポジトリ
 * 
 * @package App\Infrastructure\Team
 */
class EloquentTeamRepository implements TeamRepositoryInterface
{
    /**
     * 全てのTeamを取得
     *
     * @return Collection
     */
    public function getAllTeams(): Collection
    {
        return TeamModel::all();
    }


    /**
     * Team IDでTeamを取得
     *
     * @param int $id
     * @return Team|null
     */
    public function getTeamById(int $id): ?Team
    {
        try {
            $team = TeamModel::find($id);
            return $team ? $this->toEntity($team) : null;
        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Teamを作成
     *
     * @param Team $team
     * @return Team|null
     */
    public function createTeam(Team $team): Team
    {
        return $this->__save($team);
    }

    /**
     * Teamを更新
     *
     * @param Team $team
     * @return Team|null
     */
    public function updateTeam(Team $team): Team
    {
        return $this->__save($team);
    }

    /**
     * チームの保存・更新
     *
     * @param Team $team
     * @return Team
     */
    private function __save(Team $team): Team
    {
        try {
            $teamModel = $team->getId()
                ? TeamModel::find($team->getId())
                : new TeamModel();

            $teamModel->fill([
                'name' => $team->getName(),
                'description' => $team->getDescription(),
                'owner_id' => $team->getOwnerId()
            ]);

            $teamModel->save();
            return $this->toEntity($teamModel);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Teamを削除
     *
     * @param int $id
     * @return bool
     */
    public function deleteTeam(int $id): bool
    {
        try {
            return TeamModel::destroy($id) > 0;
        } catch (Exception $e) {
            \Log::error('チームの削除に失敗しました。: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * オーナーIDでTeamを取得
     *
     * @param int $ownerId
     * @return array|null
     */
    public function getTeamByOwnerId(int $ownerId): ?array
    {
        try {
            $team = TeamModel::where('owner_id', $ownerId)->get();
            $result = $team->map(function (TeamModel $team) {
                $entity = $this->toEntity($team);
                return [
                    'id' => $entity->getId(),
                    'name' => $entity->getName(),
                    'description' => $entity->getDescription(),
                    'owner_id' => $entity->getOwnerId(),
                    'created_at' => $team->created_at,
                    'updated_at' => $team->updated_at,
                ];
            })->all();
            if (count($result) === 0) {
                return null;
            }
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * EloquentのモデルをEntityに変換
     *
     * @param TeamModel $model
     * @return Team
     */
    private function toEntity(TeamModel $model): Team
    {
        return new Team(
            name: $model->name,
            description: $model->description,
            ownerId: $model->owner_id,
            id: $model->id
        );
    }
}
