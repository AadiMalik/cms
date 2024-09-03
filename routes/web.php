<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix'=>'permissions'], function(){
    Route::get('/',[PermissionController::class,'index']);
    Route::post('data',[PermissionController::class,'getData'])->name('permission.data');
    Route::get('create', [PermissionController::class,'create']);
    Route::post('store', [PermissionController::class,'store']);
    Route::get('edit/{id}', [PermissionController::class,'edit']);
    Route::post('update', [PermissionController::class,'update']);
    // Route::get('destroy/{id}', [PermissionController::class,'destroy']);
    // Route::get('status/{id}', [PermissionController::class,'status']);
});

Route::group(['prefix'=>'roles'], function(){
    Route::get('/',[RoleController::class,'index']);
    Route::post('data',[RoleController::class,'getData'])->name('role.data');
    Route::get('create', [RoleController::class,'create']);
    Route::post('store', [RoleController::class,'store']);
    Route::get('edit/{id}', [RoleController::class,'edit']);
    Route::post('update', [RoleController::class,'update']);
    // Route::get('destroy/{id}', [PermissionController::class,'destroy']);
    // Route::get('status/{id}', [PermissionController::class,'status']);
});

Route::group(['prefix'=>'users'], function(){
    Route::get('/',[UserController::class,'index']);
    Route::post('data',[UserController::class,'getData'])->name('user.data');
    Route::get('create', [UserController::class,'create']);
    Route::post('store', [UserController::class,'store']);
    Route::get('edit/{id}', [UserController::class,'edit']);
    Route::post('update', [UserController::class,'update']);
    Route::get('destroy/{id}', [UserController::class,'destroy']);
    Route::get('status/{id}', [UserController::class,'status']);
});
