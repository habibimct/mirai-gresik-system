<?php

use App\Http\Controllers\ParticipantWaveProgramController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PARTICIPANT WAVE PROGRAMS
|--------------------------------------------------------------------------
|
| Pengelolaan program peserta berdasarkan wave.
|
*/

Route::middleware(['auth',
    'role:Super Admin|Admin|Staff Administrasi',])
    ->group(function () {

    Route::get(
        'participants/{participant}/waves/{wave}/available-programs',
        [ParticipantWaveProgramController::class, 'availablePrograms']
    )->name('participants.waves.available-programs');


    Route::resource(
        'participants.programs',
        ParticipantWaveProgramController::class
    );

});