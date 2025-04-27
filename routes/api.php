<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login',[AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/users/{id}', [UserController::class, 'show']);  
    Route::put('/users/{id}', [UserController::class, 'update']);

    
    // Route::resource('users', UserController::class);
});