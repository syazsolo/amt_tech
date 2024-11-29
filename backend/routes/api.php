<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('user/add', [UserController::class, 'store']);
Route::post('user/all', [UserController::class, 'all']);
Route::post('user/edit', [UserController::class, 'update']);
