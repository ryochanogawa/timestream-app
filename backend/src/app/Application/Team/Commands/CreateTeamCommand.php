<?php

namespace App\Application\Team\Commands;

use App\Domain\Team\Models\Team;
use App\Domain\Team\Repositories\TeamRepositoryInterface;

/**
 * Teamを作成するコマンド
 */
class CreateTeamCommand
{
    private TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Teamを作成
     *
     * @param string $name
     * @param string|null $description
     * @param int $ownerId
     * @return Team
     */
    public function execute(
        string $name,
        ?string $description,
        int $ownerId
    ): Team {
        $team = new Team(
            name: $name,
            description: $description,
            ownerId: $ownerId
        );
        return $this->teamRepository->createTeam($team);
    }
}
