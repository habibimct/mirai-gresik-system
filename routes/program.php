<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;

Route::middleware(['auth',
    'role:Super Admin|Admin|Staff Administrasi',])
    ->group(function () {

    Route::resource('programs', ProgramController::class)
        ->middleware('auth');
});
