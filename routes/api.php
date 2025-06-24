<?php

// routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);


Route::middleware(['auth:api'])->group(function () {

    // Semua role (user/admin)
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('claims', ClaimController::class);
    Route::apiResource('notifications', NotificationController::class);
    Route::get('items/{id}/claims', [ClaimController::class, 'byItem']);
    Route::get('items/{id}/comments', [CommentController::class, 'byItem']);
    Route::post('/items/{id}/claim', [ItemController::class, 'claim']);
    Route::apiResource('users', UserController::class);


    // Khusus admin: Middleware CheckRole hanya untuk UPDATE dan DESTROY
    Route::middleware(\App\Http\Middleware\CheckRole::class.':admin')->group(function () {
        Route::patch('items/{item}', [ItemController::class, 'update']);
        Route::delete('items/{item}', [ItemController::class, 'destroy']);

        Route::patch('locations/{location}', [LocationController::class, 'update']);
        Route::delete('locations/{location}', [LocationController::class, 'destroy']);

        Route::patch('comments/{comment}', [CommentController::class, 'update']);
        Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

        Route::patch('claims/{claim}', [ClaimController::class, 'update']);
        Route::delete('claims/{claim}', [ClaimController::class, 'destroy']);

        Route::patch('notifications/{notification}', [NotificationController::class, 'update']);
        Route::delete('notifications/{notification}', [NotificationController::class, 'destroy']);
    });
});
