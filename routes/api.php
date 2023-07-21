<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DataCollectionController;
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
    Route::post('reset_password', [PosyanduController::class, 'reset_password']);
});

Route::group(['middleware' => 'api', 'prefix' => 'folder'], function ($router) {
    Route::get('', [FolderController::class, 'index']);    
    Route::get('{id}', [FolderController::class, 'show']);    
});

Route::group(['middleware' => 'api', 'prefix' => 'data'], function ($router) {
    Route::get('based_folder/{folder_id}', [DataCollectionController::class, 'based_folder']);
    Route::get('based_posyandu/{posyandu_id}', [DataCollectionController::class, 'based_posyandu']);
    Route::get('based_children/{children_id}', [DataCollectionController::class, 'based_children']);
});

Route::group(['middleware' => 'api', 'prefix' => 'children'], function ($router) {
    Route::get('{id}', [ChildrenController::class, 'show']);
});