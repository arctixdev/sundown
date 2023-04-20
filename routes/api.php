<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MissionController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('missions', MissionController::class)->middleware('auth:api');
Route::apiResource('missions.images', ImageController::class)->middleware('auth:api');
Route::post('login', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\UserController@login']);
