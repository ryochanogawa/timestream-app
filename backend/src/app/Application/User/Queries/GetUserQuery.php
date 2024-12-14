<?php

namespace App\Application\User\Queries;

use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class GetUserQuery
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getUser(int $userId): User
    {
        return $this->userRepository->findById($userId);
    }
}