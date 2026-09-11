<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ParticipantInvoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PengurusFinanceController extends Controller
{
    /**
     * Daftar tagihan peserta.
     */
    public function invoices(Request $request)
    {
        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])
            ->orderBy('name')
            ->get();

        $invoices = collect();

        if ($request->filled('classroom_id')) {

            $invoices = ParticipantInvoice::with([
                'participantClassroom.participantWaveProgram.participant.user',
                'participantClassroom.participantWaveProgram.waveProgram.program',
                'participantClassroom.classroom.waveProgram.wave',
                'items',
                'payments',
            ])
                ->where('is_final', true)
                ->whereHas('participantClassroom', function ($query) use ($request) {
                    $query->where('classroom_id', $request->classroom_id);
                })
                ->orderByDesc('id')
                ->get();
        }

        return view('pengurus.finance.invoices', compact(
            'classrooms',
            'invoices'
        ));
    }


    /**
     * Riwayat pembayaran.
     */
    public function payments(Request $request)
    {
        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])
            ->orderBy('name')
            ->get();

        $payments = collect();

        if ($request->filled('classroom_id')) {

            $payments = Payment::with([
                'invoice.participantClassroom.participantWaveProgram.participant.user',
                'invoice.participantClassroom.classroom.waveProgram.wave',
                'receiver',
            ])
                ->whereHas('invoice', function ($query) {
                    $query->where('is_final', true);
                })
                ->whereHas('invoice.participantClassroom', function ($query) use ($request) {
                    $query->where('classroom_id', $request->classroom_id);
                })
                ->orderByDesc('payment_date')
                ->orderByDesc('id')
                ->get();
        }

        return view('pengurus.finance.payments', compact(
            'classrooms',
            'payments'
        ));
    }
}
