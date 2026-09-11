<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;

Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi',
])->group(function () {

    Route::get(
        '/classrooms/{classroom}/schedule/create',
        [ScheduleController::class, 'create']
    )->name('classrooms.schedule.create');

    Route::post(
        '/classrooms/{classroom}/schedule',
        [ScheduleController::class, 'store']
    )->name('classrooms.schedule.store');

    Route::get(
        '/classrooms/{classroom}/schedule/{schedule}/edit',
        [ScheduleController::class, 'edit']
    )->name('classrooms.schedule.edit');

    Route::put(
        '/classrooms/{classroom}/schedule/{schedule}',
        [ScheduleController::class, 'update']
    )->name('classrooms.schedule.update');

    Route::delete(
        '/classrooms/{classroom}/schedule/{schedule}',
        [ScheduleController::class, 'destroy']
    )->name('classrooms.schedule.destroy');

});