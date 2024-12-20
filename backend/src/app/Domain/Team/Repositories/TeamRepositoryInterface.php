<?php

namespace App\Domain\Team\Repositories;

use Illuminate\Support\Collection;
use App\Domain\Team\Models\Team;


interface TeamRepositoryInterface
{
    public function getAllTeams(): Collection;
    public function getTeamById(int $id): ?Team;
    public function createTeam(Team $team): Team;
    public function updateTeam(Team $team): Team;
    public function deleteTeam(int $id): bool;
    public function getTeamByOwnerId(int $ownerId): ?array;
}
