<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

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
    Route::get('/maps', [GameController::class, 'getMaps']);
    Route::get('/maps/{id}', [GameController::class, 'getMap'])->whereNumber('id');
});

// duels routes
Route::post('/duels', [GameController::class, 'createDuels']);

// user routes
Route::get('/users/{id}', [UserController::class, 'getUser'])->whereNumber('id');
Route::get('/users/{id}/skins', [UserController::class, 'getUserSkins'])->whereNumber('id');

Route::post('/users', [UserController::class, 'createUser']);
Route::patch('/users/{id}', [UserController::class, 'patchUser'])->whereNumber('id');
Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->whereNumber('id');