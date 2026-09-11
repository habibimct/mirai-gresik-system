<?php

namespace App\Exports;

use App\Models\Program;
use App\Models\Wave;
use App\Models\Classroom;
use App\Models\ParticipantClassroom;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ParticipantReportExport implements
    FromView,
    ShouldAutoSize,
    WithStyles,
    WithTitle
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);

        // Filter Program
        if ($this->request->filled('program_id')) {

            $query->whereHas(
                'participantWaveProgram.waveProgram',
                function ($q) {

                    $q->where(
                        'program_id',
                        $this->request->program_id
                    );
                }
            );
        }

        // Filter Gelombang
        if ($this->request->filled('wave_id')) {

            $query->whereHas(
                'classroom.waveProgram',
                function ($q) {

                    $q->where(
                        'wave_id',
                        $this->request->wave_id
                    );
                }
            );
        }

        // Filter Kelas
        if ($this->request->filled('classroom_id')) {

            $query->where(
                'classroom_id',
                $this->request->classroom_id
            );
        }

        // Filter Status
        if ($this->request->filled('status')) {

            $query->whereHas(
                'participantWaveProgram',
                function ($q) {

                    $q->where(
                        'status',
                        $this->request->status
                    );
                }
            );
        }

        $no = 1;

        return $query
            ->orderBy('id')
            ->get()
            ->map(function ($item) use (&$no) {

                return [

                    $no++,

                    $item->participantWaveProgram?->participant?->user?->name,

                    $item->participantWaveProgram?->waveProgram?->program?->name,

                    $item->classroom?->waveProgram?->wave?->name,

                    $item->classroom?->name,

                    $item->participantWaveProgram?->status,

                ];
            });
    }

    public function title(): string
    {
        return 'Laporan Peserta';
    }

    public function headings(): array
    {
        return [

            'No',

            'Nama Peserta',

            'Program',

            'Gelombang',

            'Kelas',

            'Status',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            1 => [

                'font' => [

                    'bold' => true,

                    'size' => 16,

                ],

            ],

            2 => [

                'font' => [

                    'bold' => true,

                    'size' => 13,

                ],

            ],

            6 => [

                'font' => [

                    'bold' => true,

                ],

            ],

        ];
    }

    public function view(): View
    {
        $query = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);

        if ($this->request->filled('program_id')) {

            $query->whereHas(
                'participantWaveProgram.waveProgram',
                fn($q) => $q->where(
                    'program_id',
                    $this->request->program_id
                )
            );
        }

        if ($this->request->filled('wave_id')) {

            $query->whereHas(
                'classroom.waveProgram',
                fn($q) => $q->where(
                    'wave_id',
                    $this->request->wave_id
                )
            );
        }

        if ($this->request->filled('classroom_id')) {

            $query->where(
                'classroom_id',
                $this->request->classroom_id
            );
        }

        if ($this->request->filled('status')) {

            $query->whereHas(
                'participantWaveProgram',
                fn($q) => $q->where(
                    'status',
                    $this->request->status
                )
            );
        }

        $program = null;
        $wave = null;
        $classroom = null;

        if ($this->request->filled('program_id')) {
            $program = Program::find($this->request->program_id);
        }

        if ($this->request->filled('wave_id')) {
            $wave = Wave::find($this->request->wave_id);
        }

        if ($this->request->filled('classroom_id')) {
            $classroom = Classroom::find($this->request->classroom_id);
        }

        $total = $query->count();

        $totalActive = (clone $query)
            ->whereHas('participantWaveProgram', function ($q) {
                $q->where('status', 'Aktif');
            })
            ->count();

        $totalGraduate = (clone $query)
            ->whereHas('participantWaveProgram', function ($q) {
                $q->where('status', 'Lulus');
            })
            ->count();

        $totalInactive = (clone $query)
            ->whereHas('participantWaveProgram', function ($q) {
                $q->where('status', 'Nonaktif');
            })
            ->count();

        $participants = $query->get();

        return view(
            'reports.participants.excel',
            compact(
                'participants',
                'program',
                'wave',
                'classroom',
                'total',
                'totalActive',
                'totalGraduate',
                'totalInactive'
            )
        );
    }

    public function exportPdf(Request $request)
    {
        $query = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);

        // Filter Program
        if ($request->filled('program_id')) {
            $query->whereHas('participantWaveProgram.waveProgram', function ($q) use ($request) {
                $q->where('program_id', $request->program_id);
            });
        }

        // Filter Gelombang
        if ($request->filled('wave_id')) {
            $query->whereHas('classroom.waveProgram', function ($q) use ($request) {
                $q->where('wave_id', $request->wave_id);
            });
        }

        // Filter Kelas
        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->whereHas('participantWaveProgram', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $participants = $query->get();

        $program = $request->filled('program_id')
            ? Program::find($request->program_id)
            : null;

        $wave = $request->filled('wave_id')
            ? Wave::find($request->wave_id)
            : null;

        $classroom = $request->filled('classroom_id')
            ? Classroom::find($request->classroom_id)
            : null;

        $pdf = Pdf::loadView(
            'reports.participants.pdf',
            compact(
                'participants',
                'program',
                'wave',
                'classroom'
            )
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan Peserta.pdf');
    }
}
