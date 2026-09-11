<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeSettingController;
use App\Http\Controllers\WaveFeeSettingController;
use App\Http\Controllers\ParticipantInvoiceController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| FINANCE
|--------------------------------------------------------------------------
|
| Area pengelolaan keuangan.
| Tidak dapat diakses oleh Peserta, Pengurus, maupun Instruktur.
|
*/

Route::middleware([
    'auth',
    'role:Super Admin|Admin|Staff Administrasi|Bendahara',
])
    ->prefix('finance')
    ->name('finance.')
    ->group(function () {


    /*
    |--------------------------------------------------------------------------
    | FEE SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'fee-settings',
        FeeSettingController::class
    );


    /*
    |--------------------------------------------------------------------------
    | WAVE FEE SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::post(
        'wave-fee-settings',
        [WaveFeeSettingController::class, 'store']
    )->name('wave-fee-settings.store');

    Route::put(
        'wave-fee-settings/{waveFeeSetting}',
        [WaveFeeSettingController::class, 'update']
    )->name('wave-fee-settings.update');

    Route::delete(
        'wave-fee-settings/{waveFeeSetting}',
        [WaveFeeSettingController::class, 'destroy']
    )->name('wave-fee-settings.destroy');


    /*
    |--------------------------------------------------------------------------
    | PARTICIPANT INVOICES
    |--------------------------------------------------------------------------
    */

    Route::get(
        'participant-invoices',
        [ParticipantInvoiceController::class, 'index']
    )->name('participant-invoices.index');

    Route::get(
        'participant-invoices/{participantInvoice}',
        [ParticipantInvoiceController::class, 'show']
    )->name('participant-invoices.show');

    Route::post(
        'participant-invoices/generate/{participantClassroom}',
        [ParticipantInvoiceController::class, 'generate']
    )->name('participant-invoices.generate');

    Route::post(
        'participant-invoices/generate-all',
        [ParticipantInvoiceController::class, 'generateAll']
    )->name('participant-invoices.generate-all');

    Route::delete(
        'participant-invoices/{participantInvoice}',
        [ParticipantInvoiceController::class, 'destroy']
    )->name('participant-invoices.destroy');

    Route::get(
        'participant-invoices/{participantInvoice}/whatsapp-data',
        [ParticipantInvoiceController::class, 'whatsappData']
    )->name('participant-invoices.whatsapp-data');

    Route::post(
        'participant-invoices/{participantInvoice}/finalize',
        [ParticipantInvoiceController::class, 'finalize']
    )->name('participant-invoices.finalize');

    Route::post(
        'participant-invoices/{participantInvoice}/unfinal',
        [ParticipantInvoiceController::class, 'unfinal']
    )->name('participant-invoices.unfinal');


    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'payments',
        PaymentController::class
    )->only([
        'store',
        'destroy'
    ]);

});