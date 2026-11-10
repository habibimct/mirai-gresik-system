<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;


Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi',
])

    ->prefix('settings')
    ->name('settings.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        Route::post('/users/{user}/generate-password', [UserController::class, 'generatePassword'])
            ->name('users.generate-password');

        Route::resource(
            'users',
            UserController::class
        );


        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'roles',
            RoleController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PERMISSION
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'permissions',
            PermissionController::class
        );
    });
