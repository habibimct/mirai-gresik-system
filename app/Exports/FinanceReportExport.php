<?php

namespace App\Exports;

use App\Models\Classroom;
use App\Models\ParticipantInvoice;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Wave;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class FinanceReportExport implements FromView
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = ParticipantInvoice::with([
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
            'payments',
        ])
        ->where('is_final', true);

        // =========================
        // FILTER PROGRAM
        // =========================

        if ($this->request->filled('program_id')) {

            $query->whereHas(
                'participantClassroom.participantWaveProgram.waveProgram',
                function ($q) {
                    $q->where(
                        'program_id',
                        $this->request->program_id
                    );
                }
            );
        }

        // =========================
        // FILTER GELOMBANG
        // =========================

        if ($this->request->filled('wave_id')) {

            $query->whereHas(
                'participantClassroom.classroom.waveProgram',
                function ($q) {
                    $q->where(
                        'wave_id',
                        $this->request->wave_id
                    );
                }
            );
        }

        // =========================
        // FILTER KELAS
        // =========================

        if ($this->request->filled('classroom_id')) {

            $query->whereHas(
                'participantClassroom',
                function ($q) {
                    $q->where(
                        'classroom_id',
                        $this->request->classroom_id
                    );
                }
            );
        }

        // =========================
        // INVOICE
        // =========================

        $invoices = $query
            ->orderBy('id')
            ->get();

        // =========================
        // REKAP TAGIHAN TIAP PESERTA
        // =========================

        $participantSummaries = $invoices
            ->groupBy(function ($invoice) {

                return $invoice
                    ->participantClassroom
                    ->participantWaveProgram
                    ->participant
                    ->id;

            })
            ->map(function ($participantInvoices) {

                $participant = $participantInvoices
                    ->first()
                    ->participantClassroom
                    ->participantWaveProgram
                    ->participant;

                $totalTagihan = $participantInvoices
                    ->sum('total_amount');

                $totalDibayar = $participantInvoices
                    ->sum('paid_amount');

                $sisaTagihan = max(
                    0,
                    $totalTagihan - $totalDibayar
                );

                if ($totalTagihan <= 0) {

                    $status = 'Belum Ada Tagihan';

                } elseif ($sisaTagihan <= 0) {

                    $status = 'Lunas';

                } elseif ($totalDibayar > 0) {

                    $status = 'Sebagian';

                } else {

                    $status = 'Belum Bayar';
                }

                return [
                    'participant' => $participant,
                    'total_tagihan' => $totalTagihan,
                    'total_dibayar' => $totalDibayar,
                    'sisa_tagihan' => $sisaTagihan,
                    'status' => $status,
                ];
            })
            ->sortBy(function ($summary) {

                return $summary['participant']
                    ->user
                    ->name;

            })
            ->values();

        // =========================
        // RIWAYAT PEMBAYARAN
        // =========================

        $payments = Payment::with([
            'invoice.participantClassroom.participantWaveProgram.participant.user',
            'receiver',
        ])
            ->whereIn(
                'participant_invoice_id',
                $invoices->pluck('id')
            )
            ->latest('payment_date')
            ->get();

        // =========================
        // VIEW EXCEL
        // =========================

        return view('reports.finances.excel', [

            'invoices' => $invoices,

            'payments' => $payments,

            'participantSummaries' => $participantSummaries,

            'program' => Program::find(
                $this->request->program_id
            ),

            'wave' => Wave::find(
                $this->request->wave_id
            ),

            'classroom' => Classroom::find(
                $this->request->classroom_id
            ),

            'totalInvoice' => $invoices->sum(
                'total_amount'
            ),

            'totalPaid' => $invoices->sum(
                'paid_amount'
            ),

            'totalRemaining' => $invoices->sum(
                'total_amount'
            ) - $invoices->sum(
                'paid_amount'
            ),

        ]);
    }
}