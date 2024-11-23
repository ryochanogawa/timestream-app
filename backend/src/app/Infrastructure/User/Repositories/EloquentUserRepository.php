<?php

namespace App\Infrastructure\User\Repositories;

use App\Domain\User\Models\User as UserEntity;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\User as UserModel;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function find(int $id): ?UserEntity
    {
        try {
            $user = UserModel::find($id);
            return $user ? $this->toEntity($user) : null;
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }


    public function findByEmail(string $email): ?UserEntity
    {
        try {
            $user = UserModel::where('email', $email)->first();
            return $user ? $this->toEntity($user) : null;
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }


    public function save(UserEntity $user): UserEntity
    {
        try {
            $userModel = $user->getId() ? UserModel::find($user->getId()) : new UserModel();

            $userModel->fill([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
            $userModel->save();

            return $this->toEntity($userModel);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }


    public function all(): Collection
    {
        return UserModel::all();
    }


    private function toEntity(UserModel $user): UserEntity
    {
        return new UserEntity(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            password: $user->password,
            emailVerifiedAt: $user->email_verified_at ? new DateTime($user->email_verified_at) : null,
            createdAt: new DateTime($user->created_at),
            updatedAt: new DateTime($user->updated_at)
        );
    }
}
