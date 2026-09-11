<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Wave;
use App\Models\Classroom;
use App\Models\ParticipantInvoice;
use App\Models\Payment;
use App\Exports\FinanceReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::orderBy('name')->get();
        $waves = Wave::orderBy('name')->get();

        /* 
        |-------------------------------------------------------------------------- 
        | CLASSROOM FILTER 
        |-------------------------------------------------------------------------- 
        | Kelas difilter berdasarkan Program dan Gelombang 
        | sebelum menjalankan ->get() 
        |-------------------------------------------------------------------------- 
        */

        $classroomQuery = Classroom::with(['waveProgram.wave', 'waveProgram.program',]);
        if ($request->filled('program_id')) {
            $classroomQuery->whereHas('waveProgram', function ($q) use ($request) {
                $q->where('program_id', $request->program_id);
            });
        }
        if ($request->filled('wave_id')) {
            $classroomQuery->whereHas('waveProgram', function ($q) use ($request) {
                $q->where('wave_id', $request->wave_id);
            });
        }
        $classrooms = $classroomQuery->orderBy('name')->get();

        /* 
        |-------------------------------------------------------------------------- 
        | INVOICE QUERY 
        |-------------------------------------------------------------------------- 
        */

        $invoiceQuery = ParticipantInvoice::with(['participantClassroom.participantWaveProgram.participant.user', 'participantClassroom.participantWaveProgram.waveProgram.program', 'participantClassroom.classroom.waveProgram.wave', 'payments',])->where('is_final', true); /* |-------------------------------------------------------------------------- | FILTER PROGRAM |-------------------------------------------------------------------------- */
        if ($request->filled('program_id')) {
            $invoiceQuery->whereHas('participantClassroom.participantWaveProgram.waveProgram', function ($q) use ($request) {
                $q->where('program_id', $request->program_id);
            });
        }
        /* 
        |-------------------------------------------------------------------------- 
        | FILTER GELOMBANG 
        |-------------------------------------------------------------------------- 
        */

        if ($request->filled('wave_id')) {
            $invoiceQuery->whereHas('participantClassroom.classroom.waveProgram', function ($q) use ($request) {
                $q->where('wave_id', $request->wave_id);
            });
        }

        /* 
        |-------------------------------------------------------------------------- 
        | FILTER KELAS 
        |-------------------------------------------------------------------------- 
        */

        if ($request->filled('classroom_id')) {
            $invoiceQuery->whereHas('participantClassroom', function ($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id);
            });
        }

        /* 
        |-------------------------------------------------------------------------- 
        | GET INVOICES 
        |-------------------------------------------------------------------------- 
        */

        $invoices = $invoiceQuery->orderBy('id')->get();

        /* 
        |-------------------------------------------------------------------------- 
        | PARTICIPANT SUMMARY 
        |-------------------------------------------------------------------------- 
        */

        $participantSummaries = $invoices->groupBy(function ($invoice) {
            return $invoice->participantClassroom->participantWaveProgram->participant->id;
        })->map(function ($participantInvoices) {
            $participant = $participantInvoices->first()->participantClassroom->participantWaveProgram->participant;
            $totalTagihan = $participantInvoices->sum('total_amount');
            $totalDibayar = $participantInvoices->sum('paid_amount');
            $sisaTagihan = max(0, $totalTagihan - $totalDibayar);
            if ($participantInvoices->isEmpty()) {
                $status = 'Belum Ada Tagihan';
            } elseif ($participantInvoices->every(function ($invoice) {
                return $invoice->status === 'Lunas';
            })) {
                $status = 'Lunas';
            } elseif ($totalDibayar > 0) {
                $status = 'Sebagian';
            } else {
                $status = 'Belum Bayar';
            }
            return ['participant' => $participant, 'total_tagihan' => $totalTagihan, 'total_dibayar' => $totalDibayar, 'sisa_tagihan' => $sisaTagihan, 'status' => $status,];
        })->sortBy(function ($summary) {
            return $summary['participant']->user->name;
        })->values();

        /* 
        |-------------------------------------------------------------------------- 
        | PAYMENT 
        |-------------------------------------------------------------------------- 
        */

        $payments = Payment::with(['invoice.participantClassroom.participantWaveProgram.participant.user', 'receiver',])->whereIn('participant_invoice_id', $invoices->pluck('id'))->orderByDesc('payment_date')->get(); /* |-------------------------------------------------------------------------- | STATISTICS |-------------------------------------------------------------------------- */
        $totalInvoice = $invoices->sum('total_amount');
        $totalPaid = $invoices->sum('paid_amount');
        $totalRemaining = max(0, $totalInvoice - $totalPaid);
        $percentPaid = $totalInvoice > 0 ? round(($totalPaid / $totalInvoice) * 100, 2) : 0;

        /* 
        |-------------------------------------------------------------------------- 
        | VIEW 
        |-------------------------------------------------------------------------- 
        */

        return view('reports.finances.index', compact('programs', 'waves', 'classrooms', 'invoices', 'payments', 'totalInvoice', 'totalPaid', 'totalRemaining', 'percentPaid', 'participantSummaries'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new FinanceReportExport($request),
            'Laporan Keuangan.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getFinanceData($request);

        $pdf = Pdf::loadView(
            'reports.finances.pdf',
            $data
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan Keuangan.pdf');
    }

    private function getFinanceData(Request $request)
    {
        $invoiceQuery = ParticipantInvoice::with([
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
            'payments',
        ])->where('is_final', true);

        if ($request->filled('program_id')) {

            $invoiceQuery->whereHas(
                'participantClassroom.participantWaveProgram.waveProgram',
                fn($q) => $q->where('program_id', $request->program_id)
            );
        }

        if ($request->filled('wave_id')) {

            $invoiceQuery->whereHas(
                'participantClassroom.classroom.waveProgram',
                fn($q) => $q->where('wave_id', $request->wave_id)
            );
        }

        if ($request->filled('classroom_id')) {

            $invoiceQuery->whereHas(
                'participantClassroom',
                fn($q) => $q->where('classroom_id', $request->classroom_id)
            );
        }

        $invoices = $invoiceQuery->get();

        $participantSummaries = $invoices
            ->groupBy(function ($invoice) {
                return $invoice->participantClassroom
                    ->participantWaveProgram
                    ->participant_id;
            })
            ->map(function ($participantInvoices) {

                $participant = $participantInvoices
                    ->first()
                    ->participantClassroom
                    ->participantWaveProgram
                    ->participant;

                $totalTagihan = $participantInvoices->sum('total_amount');

                $totalDibayar = $participantInvoices->sum('paid_amount');

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
            ->values();

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

        return [

            'invoices' => $invoices,
            'payments' => $payments,
            'participantSummaries' => $participantSummaries,
            'program' => Program::find($request->program_id),
            'wave' => Wave::find($request->wave_id),
            'classroom' => Classroom::find($request->classroom_id),
            'totalInvoice' => $invoices->sum('total_amount'),
            'totalPaid' => $invoices->sum('paid_amount'),
            'totalRemaining' => $invoices->sum('total_amount') - $invoices->sum('paid_amount'),
        ];
    }

    public function getClassrooms(Request $request)
    {
        $query = Classroom::query();

        /*
    |--------------------------------------------------------------------------
    | Filter berdasarkan Program
    |--------------------------------------------------------------------------
    */

        if ($request->filled('program_id')) {

            $query->whereHas(
                'waveProgram',
                function ($q) use ($request) {

                    $q->where(
                        'program_id',
                        $request->program_id
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Filter berdasarkan Gelombang
    |--------------------------------------------------------------------------
    */

        if ($request->filled('wave_id')) {

            $query->whereHas(
                'waveProgram',
                function ($q) use ($request) {

                    $q->where(
                        'wave_id',
                        $request->wave_id
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Ambil Kelas
    |--------------------------------------------------------------------------
    */

        $classrooms = $query
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);


        return response()->json($classrooms);
    }
}
