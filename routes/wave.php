<?php

use App\Http\Controllers\WaveController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth',
    'role:Super Admin|Admin|Staff Administrasi',])
    ->group(function () {

    Route::resource('waves', WaveController::class);

});