<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantReportController;
use App\Http\Controllers\AcademicReportController;
use App\Http\Controllers\FinanceReportController;

Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi',
])
    ->prefix('reports')
    ->name('reports.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Laporan Peserta
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/participants',
            [ParticipantReportController::class, 'index']
        )->name('participants.index');

        Route::get(
            '/participants/export-excel',
            [ParticipantReportController::class, 'exportExcel']
        )->name('participants.export');

        Route::get(
            '/participants/export-pdf',
            [ParticipantReportController::class, 'exportPdf']
        )->name('participants.export-pdf');
    });


Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi|Instruktur',
])
    ->prefix('reports')
    ->name('reports.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Laporan Akademik
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/academic',
            [AcademicReportController::class, 'index']
        )->name('academics.index');

        Route::get(
            '/academic/export-excel',
            [AcademicReportController::class, 'exportExcel']
        )->name('academics.export-excel');

        Route::get(
            '/reports/academics/attendance/export-excel',
            [AcademicReportController::class, 'exportAttendanceExcel']
        )->name('academics.attendance.export-excel');

        Route::get(
            '/reports/academics/attendance/export-pdf',
            [AcademicReportController::class, 'exportAttendancePdf']
        )->name('academics.attendance.export-pdf');

        Route::get(
            '/reports/academics/score/export-excel',
            [AcademicReportController::class, 'exportScoreExcel']
        )->name('academics.score.export-excel');

        Route::get(
            '/reports/academics/score/export-pdf',
            [AcademicReportController::class, 'exportScorePdf']
        )->name('academics.score.export-pdf');

        Route::get(
            '/academic/export-pdf',
            [AcademicReportController::class, 'exportPdf']
        )->name('academics.export-pdf');
    });


Route::middleware([
    'auth',
    'role:Super Admin|Admin|Bendahara',
])
    ->prefix('reports')
    ->name('reports.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Laporan Keuangan
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/finance',
            [FinanceReportController::class, 'index']
        )->name('finances.index');

        Route::get(
            '/finance/export-excel',
            [FinanceReportController::class, 'exportExcel']
        )->name('finances.export-excel');

        Route::get(
            '/finance/export-pdf',
            [FinanceReportController::class, 'exportPdf']
        )->name('finances.export-pdf');

        Route::get(
            '/finances/classrooms',
            [FinanceReportController::class, 'getClassrooms']
        )->name('finances.classrooms');
    });
