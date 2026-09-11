<?php

namespace App\Exports;

use App\Models\Classroom;
use App\Models\ParticipantClassroom;
use App\Models\Program;
use App\Models\ScoreSession;
use App\Models\Wave;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class AcademicScoreExport implements FromView
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
        | Sesi Penilaian
        |--------------------------------------------------------------------------
        */

        $scoreSessions = collect();

        if ($this->request->filled('classroom_id')) {

            $scoreSessions = ScoreSession::with([
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
        | View Excel
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.academics.score-excel',
            [
                'participants' => $participants,

                'scoreSessions' => $scoreSessions,

                'program' => Program::find(
                    $this->request->program_id
                ),

                'wave' => Wave::find(
                    $this->request->wave_id
                ),

                'classroom' => Classroom::find(
                    $this->request->classroom_id
                ),
            ]
        );
    }
}