<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware([
    'auth',
    'role:Super Admin|Admin',
])->group(function () {

    Route::resource(
        'users',
        UserController::class
    )->names('users');
});
