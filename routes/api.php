<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Services\Http\Responses\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('registration', 'registration');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
});

Route::middleware('auth:api')->group(function() {
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::post('getByEmailOrName', 'getByEmailOrName');
        Route::get('{user}', 'getInfo');
    });

    Route::prefix('chat')->controller(MessageController::class)->group(function () {
        Route::post('new', 'store');
        Route::prefix('{id}')->group(function () {
            Route::get('', 'getOne');
            Route::post('message/push', 'pushToChat');
        });
    });
});

Route::fallback(function () {
    return JsonResponse::srcNotFound();
});
