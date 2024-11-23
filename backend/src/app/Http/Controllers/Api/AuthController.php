<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\User\Commands\LoginUserCommand;
use App\Application\User\Commands\RegisterUserCommand;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private LoginUserCommand $loginUserCommand;
    private RegisterUserCommand $registerUserCommand;

    public function __construct(
        LoginUserCommand $loginUserCommand,
        RegisterUserCommand $registerUserCommand
    ) {
        $this->loginUserCommand = $loginUserCommand;
        $this->registerUserCommand = $registerUserCommand;
    }


    /**
     * ユーザー登録
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8'
            ]);
            \Log::info($validated);
            $user = $this->registerUserCommand->execute(
                $validated['name'],
                $validated['email'],
                $validated['password']
            );

            return response()->json(['message' => 'ユーザー登録完了しました。', 'user' => $user->toArray()], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'ユーザー登録に失敗しました。', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['message' => 'ユーザー登録中にエラーが発生しました。', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * ログイン
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);
            $user = $this->loginUserCommand->execute(
                $validated['email'],
                $validated['password']
            );
            return response()->json(['message' => 'ログイン完了しました。', 'user' => $user], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'ログインに失敗しました。', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['message' => 'ログイン中にエラーが発生しました。', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * ログアウト
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'ログアウト完了しました。'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => 'ログアウト中にエラーが発生しました。', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
