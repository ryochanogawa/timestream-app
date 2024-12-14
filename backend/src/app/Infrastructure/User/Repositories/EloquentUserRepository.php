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

    /**
     * IDでユーザーを取得する
     *
     * @param int $id
     * @return ?UserEntity
     */
    public function find(int $id): ?UserEntity
    {
        try {
            $user = UserModel::find($id);
            return $user ? $this->toEntity($user) : null;
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }



    /**
     * メールアドレスでユーザーを取得する
     *
     * @param string $email
     * @return ?UserEntity
     */
    public function findByEmail(string $email): ?UserEntity
    {
        try {
            $user = UserModel::where('email', $email)->first();
            return $user ? $this->toEntity($user) : null;
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }


    /**
     * ユーザーIDでユーザーを取得する
     *
     * @param int $userId
     * @return ?UserEntity
     */
    public function findById(int $userId): ?UserEntity
    {
        try {
            $user = UserModel::find($userId);
            return $user ? $this->toEntity($user) : null;
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }



    /**
     * ユーザーを保存する
     *
     * @param UserEntity $user
     * @return UserEntity
     */
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


    /**
     * 全てのユーザーを取得する
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return UserModel::all();
    }


    /**
     * Eloquentモデルをエンティティに変換する
     *
     * @param UserModel $user
     * @return UserEntity
     */
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