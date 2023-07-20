<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PosyanduController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('checkUser', [AuthController::class, 'checkUser']);
});

Route::group(['middleware' => 'api', 'prefix' => 'posyandu'], function ($router) {
    Route::get('', [PosyanduController::class, 'index']);
    Route::get('{id}', [PosyanduController::class, 'show']);
    Route::post('store', [PosyanduController::class, 'store']);
    Route::delete('{id}', [PosyanduController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix' => 'folder'], function ($router) {
    Route::get('', [FolderController::class, 'index']);    
    Route::get('{id}', [FolderController::class, 'show']);    
});