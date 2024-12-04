<?php

namespace App\Application\User\Commands;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;
use DateTime;


class RegisterUserCommand
{
    private UserRepositoryInterface $userRepository;


    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(
        string $name,
        string $email,
        string $password
    ): User {

        // メールアドレスの重複チェック
        try {
            $checkUser = $this->userRepository->findByEmail($email);
            if ($checkUser) {
                throw new \Exception('既に登録済みのメールアドレスです。');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        // パスワードのハッシュ化
        $hashedPassword = Hash::make($password);

        $user = new User(
            id: null,
            name: $name,
            email: $email,
            password: $hashedPassword,
            emailVerifiedAt: new DateTime(),
            createdAt: new DateTime(),
            updatedAt: new DateTime(),
        );

        return $this->userRepository->save($user);
    }
}
