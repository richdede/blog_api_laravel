<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\PostController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


const PROFILE_ROUTE = '/profile/{id}';

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/users/{id}', [AuthController::class, 'getUserById']);


    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::get('/posts/user/{userId}', [PostController::class, 'getByUserId']);
    Route::get('/posts/category/{categoryId}', [PostController::class, 'getByCategoryId']);

Route::middleware(['auth'])->group(function () {
    Route::put(PROFILE_ROUTE, [ProfileController::class, 'update']);
    Route::delete(PROFILE_ROUTE, [ProfileController::class, 'delete']);
    Route::get(PROFILE_ROUTE, [ProfileController::class, 'getUserById']);

    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});

