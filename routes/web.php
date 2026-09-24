<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\WaveController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ActivityLogController;

Route::redirect('/', '/login');

Route::middleware('auth')->get('/no-role', function () {
    return view('auth.no-role');
})->name('no-role');

Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi',
])->group(function () {

    Route::get(
        '/activity-logs',
        [ActivityLogController::class, 'index']
    )->name('activity-logs.index');

    Route::get(
        '/activity-logs/{activity}',
        [ActivityLogController::class, 'show']
    )->name('activity-logs.show');

});

Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMINLTE DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'instructors',
        InstructorController::class
    );

    Route::resource(
        'programs',
        ProgramController::class
    );

    Route::resource(
        'waves',
        WaveController::class
    );

    Route::resource(
        'classrooms',
        ClassroomController::class
    );


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});

Route::middleware(['auth',
    'role:Super Admin|Admin|Staff Administrasi',])
    ->group(function () {

    Route::resource('participants', ParticipantController::class);

});


Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi|Instruktur',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMINLTE DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | CLASSROOM - READ ONLY
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/classrooms',
        [ClassroomController::class, 'index']
    )->name('classrooms.index');

    Route::get(
        '/classrooms/{classroom}',
        [ClassroomController::class, 'show']
    )->name('classrooms.show');

});



require __DIR__. '/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/participant.php';
require __DIR__.'/program.php';
require __DIR__.'/wave.php';
require __DIR__.'/wave_program.php';
require __DIR__.'/participant_wave_program.php';
require __DIR__.'/classroom.php';
require __DIR__.'/schedule.php';
require __DIR__.'/finance.php';
require __DIR__.'/report.php';
require __DIR__.'/pengurus.php';
require __DIR__.'/settings.php';
require __DIR__.'/backup.php';
