<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantPaymentController;
use App\Http\Controllers\ParticipantDashboardController;
use App\Http\Controllers\ParticipantInvoiceController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\ParticipantProgramController;


/*
|--------------------------------------------------------------------------
| PESERTA
|--------------------------------------------------------------------------
|
| Area khusus peserta.
| Menggunakan layout Tailwind, bukan AdminLTE.
|
*/

Route::middleware(['auth', 'role:Peserta'])
    ->prefix('participant')
    ->name('participant.')
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [ParticipantDashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Tagihan / Invoice
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/invoices',
        [ParticipantInvoiceController::class, 'myInvoices']
    )->name('invoices.index');


    /*
    |--------------------------------------------------------------------------
    | Pembayaran
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/payment/{invoice}',
        [ParticipantPaymentController::class, 'show']
    )->name('payment.show');

    Route::post(
        '/payment/{invoice}/create',
        [ParticipantPaymentController::class, 'createPayment']
    )->name('payment.create');


    /*
    |--------------------------------------------------------------------------
    | Program
    |--------------------------------------------------------------------------
    */

Route::get('/program', [ParticipantProgramController::class, 'index'])
    ->name('program.index');
    

});


/*
|--------------------------------------------------------------------------
| MIDTRANS NOTIFICATION
|--------------------------------------------------------------------------
|
| Endpoint ini dipanggil oleh server Midtrans.
| Tidak menggunakan middleware auth.
|
*/

Route::post(
    '/midtrans/notification',
    [MidtransNotificationController::class, 'handle']
)->name('midtrans.notification');