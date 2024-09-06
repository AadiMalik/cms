<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('data', [PermissionController::class, 'getData'])->name('permission.data');
        Route::get('create', [PermissionController::class, 'create']);
        Route::post('store', [PermissionController::class, 'store']);
        Route::get('edit/{id}', [PermissionController::class, 'edit']);
        Route::post('update', [PermissionController::class, 'update']);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('data', [RoleController::class, 'getData'])->name('role.data');
        Route::get('create', [RoleController::class, 'create']);
        Route::post('store', [RoleController::class, 'store']);
        Route::get('edit/{id}', [RoleController::class, 'edit']);
        Route::post('update', [RoleController::class, 'update']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('data', [UserController::class, 'getData'])->name('user.data');
        Route::get('create', [UserController::class, 'create']);
        Route::post('store', [UserController::class, 'store']);
        Route::get('edit/{id}', [UserController::class, 'edit']);
        Route::post('update', [UserController::class, 'update']);
        // Route::get('destroy/{id}', [UserController::class,'destroy']);
        Route::get('status/{id}', [UserController::class, 'status']);
    });

    Route::group(['prefix' => 'warehouses'], function () {
        Route::get('/', [WarehouseController::class, 'index']);
        Route::post('data', [WarehouseController::class, 'getData'])->name('warehouse.data');
        Route::get('create', [WarehouseController::class, 'create']);
        Route::post('store', [WarehouseController::class, 'store']);
        Route::get('edit/{id}', [WarehouseController::class, 'edit']);
        Route::post('update', [WarehouseController::class, 'update']);
        Route::get('destroy/{id}', [WarehouseController::class, 'destroy']);
    });


    Route::group(['prefix' => 'accounts'], function () {
        Route::get('/', [AccountController::class, 'index']);
        Route::get('getMainAccounts', [AccountController::class, 'getMainAccounts'])->name('accounts.getMainAccounts');
        Route::get('getChildAccounts/{id}', [AccountController::class, 'getChildAccountsByParentId'])->name('accounts.getChildAccounts');
        Route::get('getAccountById/{id}', [AccountController::class, 'getAccountById'])->name('accounts.getAccountById');
        Route::post('addEditAccount', [AccountController::class, 'addEditAccount'])->name('accounts.addEditAccount');
        Route::get('statusAccounts/{id}', [AccountController::class, 'status'])->name('accounts.statusAccounts');
        Route::get('deleteAccounts/{id}', [AccountController::class, 'destroy'])->name('accounts.deleteAccounts');

        Route::get('/js/accounts.js', function () {
            $path = resource_path('views/accounts/js/accounts.js');
            if (file_exists($path)) {
                return Response::file($path, [
                    'Content-Type' => 'application/javascript',
                ]);
            }
            abort(404);
        });
    });

    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('data', [SupplierController::class, 'getData'])->name('supplier.data');
        Route::get('create', [SupplierController::class, 'create']);
        Route::post('store', [SupplierController::class, 'store']);
        Route::get('edit/{id}', [SupplierController::class, 'edit']);
        Route::post('update', [SupplierController::class, 'update']);
        Route::get('destroy/{id}', [SupplierController::class, 'destroy']);
        Route::get('status/{id}', [SupplierController::class, 'status']);
    });

    Route::group(['prefix' => 'journals'], function () {
        Route::get('/', [JournalController::class, 'index']);
        Route::post('data', [JournalController::class, 'getData'])->name('journal.data');
        Route::get('create', [JournalController::class, 'create']);
        Route::post('store', [JournalController::class, 'store']);
        Route::get('edit/{id}', [JournalController::class, 'edit']);
        Route::post('update', [JournalController::class, 'update']);
        Route::get('destroy/{id}', [JournalController::class, 'destroy']);
        Route::get('status/{id}', [JournalController::class, 'status']);
        Route::get('/js/JournalForm.js', function () {
            $path = resource_path('views/journal/js/JournalForm.js');
            if (file_exists($path)) {
                return Response::file($path, [
                    'Content-Type' => 'application/javascript',
                ]);
            }
            abort(404);
        });
    });
});
