<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // 認証が不要なルート
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    //Route::apiResource('tasks', TaskController::class);

    // 認証が必要なルート
    Route::middleware('auth:sanctum')->group(function () {
        // TODO: taskのルートを追加
        // tasksのルートプレフィックスに変更して追加
        // カスタム以外のルートはapiResourceで作成
        // Route::prefix('tasks')->group(function () {
        //     Route::apiResource('/', TaskController::class);
        // });
        Route::apiResource('tasks', TaskController::class);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [UserController::class, 'getUser']);
        // チームのカスタムルート
        Route::prefix('teams')->group(function () {
            Route::get('/owner', [TeamController::class, 'getOwnerTeam']);
        });
        Route::apiResource('teams', TeamController::class);
    });
});
