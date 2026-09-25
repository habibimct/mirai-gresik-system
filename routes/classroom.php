<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ScoreSessionController;
use App\Http\Controllers\ScoreTypeController;
use App\Http\Controllers\ScoreRecapController;
use App\Http\Controllers\AttitudeTypeController;
use App\Http\Controllers\AttitudeSessionController;
use App\Http\Controllers\AttitudeScoreController;


/*
|--------------------------------------------------------------------------
| CLASSROOM / ATTENDANCE / SCORES
|--------------------------------------------------------------------------
|
| Area pengelolaan kelas, peserta kelas, absensi,
| nilai, tipe nilai, dan rekap nilai.
|
| Role yang memiliki akses:
| - Super Admin
| - Admin
| - Instruktur
|
*/

Route::middleware([
    'auth',
    'role:Super Admin|Admin|Instruktur',
])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | CLASSROOMS
    |--------------------------------------------------------------------------
    */

    Route::delete(
        'classrooms/{classroom}/participants/{participantClassroom}',
        [ClassroomController::class, 'removeParticipant']
    )->name('classrooms.removeParticipant');

    Route::post(
        'classrooms/{classroom}/assign-participants',
        [ClassroomController::class, 'assignParticipants']
    )->name('classrooms.assignParticipants');


    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE
    |--------------------------------------------------------------------------
    */

    Route::post(
        'classrooms/{classroom}/attendance',
        [AttendanceController::class, 'store']
    )->name('classrooms.attendance.store');

    Route::put(
        'classrooms/{classroom}/attendance/{attendanceSession}',
        [AttendanceController::class, 'update']
    )->name('classrooms.attendance.update');

    Route::delete(
        'classrooms/{classroom}/attendance/{attendanceSession}',
        [AttendanceController::class, 'destroy']
    )->name('classrooms.attendance.destroy');


    /*
    |--------------------------------------------------------------------------
    | SCORES
    |--------------------------------------------------------------------------
    */

    Route::post(
        'classrooms/{classroom}/scores',
        [ScoreSessionController::class, 'store']
    )->name('classrooms.scores.store');

    Route::put(
        'classrooms/{classroom}/scores/{scoreSession}',
        [ScoreSessionController::class, 'update']
    )->name('classrooms.scores.update');

    Route::delete(
        'classrooms/{classroom}/scores/{scoreSession}',
        [ScoreSessionController::class, 'destroy']
    )->name('classrooms.scores.destroy');


    /*
    |--------------------------------------------------------------------------
    | SCORE TYPES
    |--------------------------------------------------------------------------
    */

    Route::post(
        'score-types',
        [ScoreTypeController::class, 'store']
    )->name('score-types.store');

    Route::put(
        'score-types/{scoreType}',
        [ScoreTypeController::class, 'update']
    )->name('score-types.update');

    Route::delete(
        'score-types/{scoreType}',
        [ScoreTypeController::class, 'destroy']
    )->name('score-types.destroy');


    /*
    |--------------------------------------------------------------------------
    | SCORE INPUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        'score-sessions/{scoreSession}/input',
        [ScoreSessionController::class, 'saveScores']
    )->name('score-sessions.saveScores');


    /*
    |--------------------------------------------------------------------------
    | SCORE RECAP
    |--------------------------------------------------------------------------
    */

    Route::get(
        'score-recaps',
        [ScoreRecapController::class, 'index']
    )->name('score-recaps.index');

    Route::get(
        'score-recaps/{classroom}',
        [ScoreRecapController::class, 'show']
    )->name('score-recaps.show');

    Route::put(
        'classrooms/{classroom}/graduation-setting',
        [ScoreRecapController::class, 'updateGraduationSetting']
    )->name('score-recaps.graduation-setting');

    Route::get(
        'classrooms/{classroom}/score-recaps/{participantClassroom}',
        [ScoreRecapController::class, 'participant']
    )->name('score-recaps.participant');

    Route::get(
        'classrooms/{classroom}/score-recaps/{participantClassroom}/print',
        [ScoreRecapController::class, 'printParticipant']
    )->name('score-recaps.printParticipant');

    Route::get(
        'score-recaps/{classroom}/participant/{participantClassroom}/pdf',
        [ScoreRecapController::class, 'exportParticipantPdf']
    )->name('score-recaps.participant.pdf');






    Route::post(
        '/classrooms/{classroom}/attitude-types',
        [AttitudeTypeController::class, 'store']
    )->name('classrooms.attitude-types.store');

    Route::put(
        '/classrooms/{classroom}/attitude-types/{attitudeType}',
        [AttitudeTypeController::class, 'update']
    )->name('classrooms.attitude-types.update');

    Route::delete(
        '/classrooms/{classroom}/attitude-types/{attitudeType}',
        [AttitudeTypeController::class, 'destroy']
    )->name('classrooms.attitude-types.destroy');

    Route::post(
        '/classrooms/{classroom}/attitude-sessions',
        [AttitudeSessionController::class, 'store']
    )->name('classrooms.attitude-sessions.store');

    Route::get(
        '/classrooms/{classroom}/attitude-sessions/{attitudeSession}/scores',
        [AttitudeSessionController::class, 'scores']
    )->name('classrooms.attitude-sessions.scores');

    Route::post(
        '/classrooms/{classroom}/attitude-sessions/{attitudeSession}/scores',
        [AttitudeScoreController::class, 'store']
    )->name('classrooms.attitude-sessions.scores.store');

    Route::delete(
        '/classrooms/{classroom}/attitude-sessions/{attitudeSession}',
        [AttitudeSessionController::class, 'destroy']
    )->name('classrooms.attitude-sessions.destroy');
});
