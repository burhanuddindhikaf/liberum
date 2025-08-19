<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ThreadController;
use App\Http\Controllers\API\ReplyController;
USE App\Http\Controllers\API\CategoryController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    Route::apiResource('threads', ThreadController::class);
    Route::apiResource('reply', ReplyController::class);
    Route::apiResource('categories', CategoryController::class);

});
