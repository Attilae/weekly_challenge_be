<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [\App\Http\Controllers\Api\AuthController::class, 'createUser']);
Route::post('/auth/login', [\App\Http\Controllers\Api\AuthController::class, 'loginUser']);

Route::post('/user/change-password', [\App\Http\Controllers\Api\UserController::class, 'changePassword'])->middleware('auth:sanctum');

Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me'])->middleware('auth:sanctum');


Route::resource('challenges', \App\Http\Controllers\Api\ChallengeController::class)->middleware('auth:sanctum');

Route::get('/challenges/{id}/applications', [\App\Http\Controllers\Api\ChallengeApplicationController::class, 'index'])->middleware('auth:sanctum');
Route::get('/application/{id}', [\App\Http\Controllers\Api\ChallengeApplicationController::class, 'show'])->middleware('auth:sanctum');
Route::post('/application/create', [\App\Http\Controllers\Api\ChallengeApplicationController::class, 'store'])->middleware('auth:sanctum');
Route::get('/applications/me', [\App\Http\Controllers\Api\ChallengeApplicationController::class, 'me'])->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
