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
    Route::post('login', [AuthController::class, 'login']); // kelurahan, posyandu, puskesmas
    Route::post('logout', [AuthController::class, 'logout']); // kelurahan, posyandu, puskesmas
    Route::get('checkUser', [AuthController::class, 'checkUser']); // kelurahan, posyandu, puskesmas
});

Route::group(['middleware' => 'api', 'prefix' => 'posyandu'], function ($router) {
    Route::get('', [PosyanduController::class, 'index'])->middleware('role:kelurahan'); 
    Route::get('{id}', [PosyanduController::class, 'show'])->middleware('role:kelurahan,posyandu');
    Route::post('store', [PosyanduController::class, 'store'])->middleware('role:kelurahan');
    Route::delete('{id}', [PosyanduController::class, 'destroy'])->middleware('role:kelurahan');
    Route::post('reset_password', [PosyanduController::class, 'reset_password'])->middleware('role:kelurahan');
    Route::get('settings/{posyandu_id}', [PosyanduController::class, 'settings'])->middleware('role:kelurahan');
});

Route::group(['middleware' => 'api', 'prefix' => 'folder'], function ($router) {
    Route::get('', [FolderController::class, 'index'])->middleware('role:kelurahan,posyandu');
    Route::get('{id}', [FolderController::class, 'show'])->middleware('role:kelurahan,posyandu');
    Route::post('store', [FolderController::class, 'store'])->middleware('role:posyandu');
    Route::get('based_posyandu/{posyandu_id}', [FolderController::class, 'based_posyandu'])->middleware('role:kelurahan,posyandu');
});

Route::group(['middleware' => 'api', 'prefix' => 'data'], function ($router) {
    Route::get('based_folder/{folder_id}', [DataCollectionController::class, 'based_folder'])->middleware('role:kelurahan');
    Route::get('based_posyandu/{posyandu_id}', [DataCollectionController::class, 'based_posyandu'])->middleware('role:kelurahan');
    Route::get('based_children/{children_id}', [DataCollectionController::class, 'based_children'])->middleware('role:kelurahan');
    Route::post('store', [DataCollectionController::class, 'store'])->middleware('role:posyandu');
    Route::get('history/{children_id}', [DataCollectionController::class, 'history'])->middleware('role:posyandu');
    Route::delete('{data_id}', [DataCollectionController::class, 'destroy'])->middleware('role:posyandu');
});

Route::group(['middleware' => 'api', 'prefix' => 'children'], function ($router) {
    Route::get('list', [ChildrenController::class, 'list_children'])->middleware('role:posyandu');
    Route::get('{id}', [ChildrenController::class, 'show'])->middleware('role:kelurahan,posyandu');
    Route::post('store', [ChildrenController::class, 'store'])->middleware('role:posyandu');
    Route::put('{id}', [ChildrenController::class, 'update'])->middleware('role:posyandu');
    Route::delete('{id}', [ChildrenController::class, 'destroy'])->middleware('role:posyandu');
    Route::get('based_posyandu/{posyandu_id}', [ChildrenController::class, 'based_posyandu'])->middleware('role:kelurahan');
});