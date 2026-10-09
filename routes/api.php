<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/* apiResource inclut index (get /users), store (post /users), show (get /users/{id}),
update (patch ou put, selon approche choisie, /users/{id}), destroy (delete /users/{id}) */ 
Route::apiResource('/users', UserController::class);
Route::apiResource('/works', WorkController::class);

Route::post('/session', [UserController::class, 'login']);
Route::get('/session', [UserController::class, 'getLoggedUser'])->middleware('auth:sanctum');
Route::delete('/session', [UserController::class, 'logout'])->middleware('auth:sanctum');