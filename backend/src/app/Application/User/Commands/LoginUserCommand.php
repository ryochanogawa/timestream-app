<?php

namespace App\Application\User\Commands;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;
use DateTime;

class LoginUserCommand
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function execute(
        string $mail,
        string $password
    ): array {
        try {
            $checkUser = $this->userRepository->findByEmail($mail);

            if (!$checkUser) {
                throw new \RuntimeException('メールアドレスが見つかりません。');
            }
        } catch (\RuntimeException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        // パスワードチェック
        try {
            $userModel = UserModel::where('email', $mail)->first();
            // デバッグ用のログ出力を詳細に
            // パスワード検証の詳細なデバッグ
            $storedHash = $userModel->getRawOriginal('password');


            \Log::info('Multiple verification attempts:', [
                'input_password' => $password,
                'stored_hash' => $storedHash,
                // Laravel's Hash facade
                'hash_check_result' => Hash::check($password, $storedHash),
                // Direct password_verify
                'password_verify_result' => password_verify($password, $storedHash),
                // New hash verification
                'new_hash' => Hash::make($password),
                'verify_with_new' => Hash::check($password, Hash::make($password))
            ]);

            if (!password_verify($password, $storedHash)) {
                throw new \RuntimeException('パスワードが間違っています。');
            }
        } catch (\RuntimeException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        // tokenの生成
        $token = $userModel->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $checkUser->toArray(),
        ];
    }
}
