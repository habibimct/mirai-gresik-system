<?php

namespace App\Exports;

use App\Models\AttendanceSession;
use App\Models\Classroom;
use App\Models\ParticipantClassroom;
use App\Models\Program;
use App\Models\Wave;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class AcademicAttendanceExport implements FromView
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
        | Sesi Kehadiran
        |--------------------------------------------------------------------------
        */

        $attendanceSessions = collect();

        if ($this->request->filled('classroom_id')) {

            $attendanceSessions = AttendanceSession::with([
                'schedule',
                'attendances',
            ])
                ->where(
                    'classroom_id',
                    $this->request->classroom_id
                )
                ->orderBy('attendance_date')
                ->orderBy('schedule_id')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | View Excel
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.academics.attendance-excel',
            [
                'participants' => $participants,

                'attendanceSessions' => $attendanceSessions,

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