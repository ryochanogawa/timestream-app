<?php

namespace App\Application\Team\Commands;

use App\Domain\Team\Models\Team;
use App\Domain\Team\Repositories\TeamRepositoryInterface;

/**
 * チームの更新
 */
class UpdateTeamCommand
{
    public function __construct(private TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * チームの更新
     *
     * @param integer $id
     * @param array $data
     * @return Team
     */
    public function execute(int $id, array $data): ?Team
    {
        $team = $this->teamRepository->getTeamById($id);
        if (!$team) {
            return null;
        }

        // エンティティに変換
        $updateTeam = new Team(
            name: $data['name'] ?? $team->getName(),
            description: $data['description'] ?? $team->getDescription(),
            ownerId: $team->getOwnerId(),
            id: $id
        );

        return $this->teamRepository->updateTeam($updateTeam);
    }


    /**
     * チームの削除
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool
    {
        return $this->teamRepository->deleteTeam($id);
    }
}
