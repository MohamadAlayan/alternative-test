<?php

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

/*
 * In this file, we have to define all the routes for the Admin Panel API's
 */

Route::get('/', function (Request $request) {
    return "Welcome to admin API's";
});

// Public Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('admin.login');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');

    // public routes
    Route::controller(PageController::class)->prefix('page')->group(function () {
        Route::get('/all', 'allPages');
        Route::post('/getPage', 'readPage');
    });
});

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout');
        Route::get('/logout-all', 'logoutAll');
    });

    // User Management Routes
    Route::prefix('user-management')->group(function () {
        // User Routes
        Route::controller(UserController::class)->prefix('user')->group(function () {
            Route::get('/list', 'listUsers')->middleware('permission:users.list.user');
            Route::post('/', 'createUser')->middleware('permission:user.create');
            Route::get('/{uuid}', 'readUser')->middleware('permission:users.read.user');
            Route::put('/{uuid}', 'updateUser')->middleware('permission:users.update.user');
            Route::delete('/{uuid}', 'deleteUser')->middleware('permission:users.delete.user');
        });
        // Admin Routes
        Route::controller(UserController::class)->prefix('admin')->group(function () {
            Route::get('/list', 'listAdmins')->middleware('permission:users.list.admin');
            Route::post('/', 'createAdmin')->middleware('permission:users.create.admin');
            Route::get('/{uuid}', 'readAdmin')->middleware('permission:users.read.admin');
            Route::put('/{uuid}', 'updateAdmin')->middleware('permission:users.update.admin');
            Route::delete('/{uuid}', 'deleteAdmin')->middleware('permission:users.delete.admin');
        });
    });

    // Page Routes
    Route::controller(PageController::class)->prefix('page')->group(function () {
        Route::get('/list', 'listPages')->middleware('permission:pages.list.page');
        Route::post('/', 'createPage')->middleware('permission:pages.create.page');
        Route::put('/{uuid}', 'updatePage')->middleware('permission:pages.update.page');
        Route::delete('/{uuid}', 'deletePage')->middleware('permission:pages.delete.page');
    });


});
