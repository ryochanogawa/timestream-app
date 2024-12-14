<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\User\Queries\GetUserQuery;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private GetUserQuery $getUserQuery;

    public function __construct(
        GetUserQuery $getUserQuery
    ) {
        $this->getUserQuery = $getUserQuery;
    }


    /**
     * ログインしているユーザーの情報を取得する
     * Bearerトークンを使用して認証されたユーザーの情報を取得する
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        return response()->json(
            [
                'user' => $request->user(),
                'status' => 200,
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]
        );
    }
}