<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', App\Http\Controllers\UserController::class);

Route::apiResource('locations', App\Http\Controllers\LocationController::class);

Route::apiResource('items', App\Http\Controllers\ItemController::class);

Route::apiResource('claims', App\Http\Controllers\ClaimController::class);

Route::apiResource('comments', App\Http\Controllers\CommentController::class);

Route::apiResource('notifications', App\Http\Controllers\NotificationController::class);

