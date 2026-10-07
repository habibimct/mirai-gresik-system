<?php

namespace App\Exports;

use App\Models\AttitudeSession;
use App\Models\Classroom;
use App\Models\ParticipantClassroom;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class AcademicAttitudeExport implements FromView
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Peserta
        |--------------------------------------------------------------------------
        */

        $participantQuery = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);

        // Filter Program
        if ($this->request->filled('program_id')) {

            $participantQuery->whereHas(
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

            $participantQuery->whereHas(
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

            $participantQuery->where(
                'classroom_id',
                $this->request->classroom_id
            );
        }

        $participants = $participantQuery
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Sesi Nilai Sikap
        |--------------------------------------------------------------------------
        */

        $attitudeSessions = collect();

        if ($this->request->filled('classroom_id')) {

            $attitudeSessions = AttitudeSession::with([
                'sessionTypes.type',
                'scores',
            ])
                ->where(
                    'classroom_id',
                    $this->request->classroom_id
                )
                ->where('is_active', true)
                ->orderBy('week')
                ->orderBy('assessment_date')
                ->orderBy('id')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | Classroom
        |--------------------------------------------------------------------------
        */

        $classroom = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])->find(
            $this->request->classroom_id
        );


        /*
        |--------------------------------------------------------------------------
        | View Excel
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.academics.attitude-excel',
            [
                'participants' => $participants,
                'attitudeSessions' => $attitudeSessions,
                'classroom' => $classroom,
            ]
        );
    }
}