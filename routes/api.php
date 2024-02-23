<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// 회원가입
Route::post('/register', [AuthController::class, 'register']);

// 로그인
Route::post('/login', [AuthController::class, 'login']);

// 인증 체크
Route::middleware('auth:sanctum')->group(function () {
    // 유저 정보 수정
    Route::put('/user/update', [AuthController::class, 'update']);

    // 유저 삭제
    Route::delete('/user/destroy', [AuthController::class, 'destroy']);

    // 유저 로그아웃
    Route::post('/logout', [AuthController::class, 'logout']);
});
