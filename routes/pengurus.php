<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengurusDashboardController;
use App\Http\Controllers\PengurusProgramController;
use App\Http\Controllers\PengurusClassroomController;
use App\Http\Controllers\PengurusAttendanceController;
use App\Http\Controllers\PengurusScoreController;
use App\Http\Controllers\PengurusFinanceController;
use App\Http\Controllers\PengurusReportController;

/*
|--------------------------------------------------------------------------
| PENGURUS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Pengurus'])
    ->prefix('pengurus')
    ->name('pengurus.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            PengurusDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        Route::get('/programs', [
            PengurusProgramController::class,
            'index'
        ])->name('programs.index');



        Route::get('/classrooms', [
            PengurusClassroomController::class,
            'index'
        ])->name('classrooms.index');

        Route::get('/classrooms/{classroom}', [
            PengurusClassroomController::class,
            'show'
        ])->name('classrooms.show');

        /*
        |--------------------------------------------------------------------------
        | AKADEMIK
        |--------------------------------------------------------------------------
        */

        Route::get('/attendances', [
            PengurusAttendanceController::class,
            'index'
        ])->name('attendances.index');



        Route::get('/scores', [PengurusScoreController::class, 'index'])
            ->name('scores.index');

        Route::get('/scores/{classroom}', [PengurusScoreController::class, 'show'])
            ->name('scores.show');

        /*
        |--------------------------------------------------------------------------
        | KEUANGAN
        |--------------------------------------------------------------------------
        */

        Route::get('/invoices', [
            PengurusFinanceController::class,
            'invoices'
        ])->name('invoices.index');


        Route::get('/payments', [
            PengurusFinanceController::class,
            'payments'
        ])->name('payments.index');


        // =====================================================
        // LAPORAN
        // =====================================================

        Route::get('/reports/participants', [
            PengurusReportController::class,
            'participants'
        ])->name('reports.participants');

        Route::get('/reports/participants/print', [
            PengurusReportController::class,
            'participantsPrint'
        ])->name('reports.participants.print');

        Route::get('/reports/academic', [
            PengurusReportController::class,
            'academic'
        ])->name('reports.academic');

        Route::get('/reports/academic/print', [
            PengurusReportController::class,
            'academicPrint'
        ])->name('reports.academic.print');

        Route::get('/reports/finance', [
            PengurusReportController::class,
            'finance'
        ])->name('reports.finance');

        Route::get('/reports/finance/print', [
            PengurusReportController::class,
            'financePrint'
        ])->name('reports.finance.print');
    });
