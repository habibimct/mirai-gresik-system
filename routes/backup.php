<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;


/*
|--------------------------------------------------------------------------
| BACKUP & RESTORE
|--------------------------------------------------------------------------
|
| Backup dan restore database.
| Hanya dapat diakses oleh Super Admin.
|
*/

Route::middleware([
    'auth',
    'role:Super Admin',
])
    ->prefix('admin/backups')
    ->name('admin.backups.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Daftar Backup
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [BackupController::class, 'index']
        )->name('index');


        /*
        |--------------------------------------------------------------------------
        | Buat Backup Database
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/',
            [BackupController::class, 'store']
        )->name('store');


        /*
        |--------------------------------------------------------------------------
        | Restore dari File Upload
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/restore-upload',
            [BackupController::class, 'restoreUpload']
        )->name('restore-upload');


        /*
        |--------------------------------------------------------------------------
        | Download Backup
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/{backup}/download',
            [BackupController::class, 'download']
        )->name('download');


        /*
        |--------------------------------------------------------------------------
        | Restore dari Riwayat Backup
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/{backup}/restore',
            [BackupController::class, 'restore']
        )->name('restore');


        /*
        |--------------------------------------------------------------------------
        | Hapus Backup
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/{backup}',
            [BackupController::class, 'destroy']
        )->name('destroy');

    });