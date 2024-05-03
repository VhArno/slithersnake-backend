<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
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

// skins routes
Route::group(['prefix' => '/skins'], function() {
    Route::get('/', [GameController::class, 'getAllSkins']);
    Route::get('/{id}', [GameController::class, 'getSkin'])->whereNumber('id');
    Route::get('/featured', [GameController::class, 'getFeaturedSkins']);
    //Route::get('/user/{id}', [GameController::class, 'getUserSkins'])->whereNumber('id');
});

// gamemodes routes
Route::group(['prefix' => '/gamemodes'], function() {
    Route::get('/', [GameController::class, 'getGamemodes']);
    Route::get('/{id}', [GameController::class, 'getGamemode'])->whereNumber('id');
});

// maps routes
Route::group(['prefix' => '/maps'], function() {
    Route::get('/', [GameController::class, 'getMaps']);
    Route::get('/maps/{id}', [GameController::class, 'getMap'])->whereNumber('id');
});

// duels routes
Route::post('/duels', [GameController::class, 'createDuels']);

// user routes
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUser']);
Route::middleware('auth:sanctum')->patch('/users/{id}', [AuthController::class, 'patchUser'])->whereNumber('id');
Route::middleware('auth:sanctum')->delete('/users/{id}', [AuthController::class, 'deleteUser'])->whereNumber('id');
Route::middleware('auth:sanctum')->get('/users/{id}/skins', [AuthController::class, 'getUserSkins'])->whereNumber('id');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'createUser']);