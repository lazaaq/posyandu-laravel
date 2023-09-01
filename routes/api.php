<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DataCollectionController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasController;
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
    Route::get('{id}', [PosyanduController::class, 'show'])->middleware('role:kelurahan,posyandu,puskesmas');
    Route::post('store', [PosyanduController::class, 'store'])->middleware('role:kelurahan,puskesmas');
    Route::get('get_username/{posyandu_id}', [PosyanduController::class, 'get_username'])->middleware('role:kelurahan');
    Route::post('reset_password', [PosyanduController::class, 'reset_password'])->middleware('role:kelurahan');
    Route::get('settings/{posyandu_id}', [PosyanduController::class, 'settings'])->middleware('role:kelurahan');
    Route::get('list_children/{posyandu_id}', [PosyanduController::class, 'list_children'])->middleware('role:kelurahan,puskesmas');
});

Route::group(['middleware' => 'api', 'prefix' => 'folder'], function ($router) {
    Route::get('all_based_posyandu/{posyandu_id}', [FolderController::class, 'all_based_posyandu'])->middleware('role:kelurahan,puskesmas');
    Route::get('{id}', [FolderController::class, 'show'])->middleware('role:kelurahan,posyandu,puskesmas');
    Route::post('store', [FolderController::class, 'store'])->middleware('role:posyandu');
});

Route::group(['middleware' => 'api', 'prefix' => 'data'], function ($router) {
    Route::get('{id}', [DataCollectionController::class, 'show'])->middleware('role:kelurahan,puskesmas');
    Route::post('store', [DataCollectionController::class, 'store'])->middleware('role:posyandu');
    Route::get('history/{children_id}', [DataCollectionController::class, 'history'])->middleware('role:kelurahan,posyandu,puskesmas');
    Route::delete('{data_id}', [DataCollectionController::class, 'destroy'])->middleware('role:posyandu');
    Route::put('{data_id}', [DataCollectionController::class, 'update'])->middleware('role:posyandu');
});

Route::group(['middleware' => 'api', 'prefix' => 'children'], function ($router) {
    Route::get('list/{posyandu_id}', [ChildrenController::class, 'list_children'])->middleware('role:posyandu');
    Route::get('age/{children_id}', [ChildrenController::class, 'age'])->middleware('role:posyandu');
    Route::get('{id}', [ChildrenController::class, 'show'])->middleware('role:kelurahan,posyandu,puskesmas');
    Route::post('store', [ChildrenController::class, 'store'])->middleware('role:posyandu');
    Route::put('{id}', [ChildrenController::class, 'update'])->middleware('role:posyandu');
    Route::get('export_data/{folder_id}', [ChildrenController::class, 'export_data'])->middleware('role:kelurahan,puskesmas');
});

Route::group(['middleware' => 'api', 'prefix' => 'kelurahan'], function ($router) {
    Route::get('show', [KelurahanController::class, 'show'])->middleware('role:kelurahan');
});

Route::group(['middleware' => 'api', 'prefix' => 'puskesmas'], function ($router) {
    Route::get('show', [PuskesmasController::class, 'show'])->middleware('role:puskesmas');
});