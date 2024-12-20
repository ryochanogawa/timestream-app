<?php

namespace App\Application\Team\Queries;

use App\Domain\Team\Models\Team;
use App\Domain\Team\Repositories\TeamRepositoryInterface;

class GetTeamQuery
{
    private TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }


    /**
     * チームをIDで取得する
     * 
     * @param int $id
     * @return Team|null
     */
    public function executeById(int $id): ?Team
    {
        return $this->teamRepository->getTeamById($id);
    }


    /**
     * チームをオーナーIDで取得する
     * 
     * @param int $ownerId
     * @return array|null
     */
    public function executeByOwnerId(int $ownerId): ?array
    {
        return $this->teamRepository->getTeamByOwnerId($ownerId);
    }
}
