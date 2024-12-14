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
    ): \Illuminate\Http\JsonResponse {
        try {
            $checkUser = $this->userRepository->findByEmail($mail);
            if (!$checkUser) {
                return response()->json([
                    'message' => 'メールアドレスが見つかりません。'
                ], 401);
            }

            $userModel = UserModel::where('email', $mail)->first();
            $storedHash = $userModel->getRawOriginal('password');

            if (!password_verify($password, $storedHash)) {
                return response()->json([
                    'message' => 'パスワードが間違っています。'
                ], 401);
            }

            $token = $userModel->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => [
                    'id' => $checkUser->getId(),
                    'name' => $checkUser->getName(),
                    'email' => $checkUser->getEmail(),
                ],
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ログイン処理中にエラーが発生しました。',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}