<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\ParticipantClassroom;
use App\Models\Program;
use App\Models\Score;
use App\Models\ScoreSession;
use App\Models\Wave;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AcademicReportExport;
use App\Exports\AcademicAttendanceExport;
use App\Exports\AcademicScoreExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AcademicReportController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::orderBy('name')->get();
        $waves = Wave::orderBy('name')->get();
        $classrooms = Classroom::orderBy('name')->get();

        $query = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
            'attendances',
            'scores',
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

        $participants = $query
            ->orderBy('id')
            ->get();

        // Data sesi kehadiran
        $attendanceSessions = collect();

        if ($request->filled('classroom_id')) {

            $attendanceSessions = \App\Models\AttendanceSession::with([
                'schedule',
                'attendances',
            ])
                ->where('classroom_id', $request->classroom_id)
                ->orderBy('attendance_date')
                ->orderBy(
                    \App\Models\Schedule::select('start_time')
                        ->whereColumn(
                            'schedules.id',
                            'attendance_sessions.schedule_id'
                        )
                )
                ->get();
        }

        // Statistik sesuai hasil filter
        $totalParticipant = $participants->count();

        $totalMeeting = \App\Models\AttendanceSession::when(
            $request->filled('classroom_id'),
            function ($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id);
            }
        )->count();

        $averageScore = round(
            $participants->flatMap(function ($p) {
                return $p->scores->pluck('score');
            })->avg() ?? 0,
            2
        );

        $averageAttendance = $totalMeeting > 0
            ? round(
                (
                    $participants->sum(fn($p) => $p->attendances->where('status', 'Hadir')->count())
                    / ($totalParticipant * $totalMeeting)
                ) * 100,
                2
            )
            : 0;

        $scoreSessions = collect();

        if ($request->filled('classroom_id')) {

            $scoreSessions = ScoreSession::with([
                'sessionTypes.type',
                'scores',
            ])
                ->where('classroom_id', $request->classroom_id)
                ->where('is_active', true)
                ->orderBy('week')
                ->orderBy('assessment_date')
                ->get();
        }

        return view(
            'reports.academics.index',
            compact(
                'participants',
                'programs',
                'waves',
                'classrooms',
                'totalParticipant',
                'totalMeeting',
                'averageScore',
                'averageAttendance',
                'attendanceSessions',
                'scoreSessions'
            )
        );
    }

    public function exportExcel(Request $request)
    {
        if ($redirect = $this->validateReportFilter($request)) {
            return $redirect;
        }

        return Excel::download(
            new AcademicReportExport($request),
            'Laporan Akademik.xlsx'
        );
    }


    public function exportPdf(Request $request)
    {
        if ($redirect = $this->validateReportFilter($request)) {
            return $redirect;
        }

        $query = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'participantWaveProgram.waveProgram.wave',
            'classroom.waveProgram.program',
            'classroom.waveProgram.wave',
            'attendances',
            'scores',
        ]);

        if ($request->filled('program_id')) {
            $query->whereHas(
                'participantWaveProgram.waveProgram',
                function ($q) use ($request) {
                    $q->where('program_id', $request->program_id);
                }
            );
        }

        if ($request->filled('wave_id')) {
            $query->whereHas(
                'classroom.waveProgram',
                function ($q) use ($request) {
                    $q->where('wave_id', $request->wave_id);
                }
            );
        }

        if ($request->filled('classroom_id')) {
            $query->where(
                'classroom_id',
                $request->classroom_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Ambil data peserta
    |--------------------------------------------------------------------------
    */

        $participants = $query->get();


        /*
    |--------------------------------------------------------------------------
    | Identitas laporan
    |--------------------------------------------------------------------------
    |
    | Jika kelas dipilih, Program dan Gelombang
    | diambil langsung dari Classroom.
    |
    */

        $classroom = null;

        if ($request->filled('classroom_id')) {

            $classroom = Classroom::with([
                'waveProgram.program',
                'waveProgram.wave',
            ])->findOrFail($request->classroom_id);
        }


        /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

        $pdf = Pdf::loadView(
            'reports.academics.pdf',
            [
                'participants' => $participants,
                'classroom' => $classroom,
            ]
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download(
            'Laporan Akademik.pdf'
        );
    }

    public function exportAttendanceExcel(Request $request)
    {
        if ($redirect = $this->validateReportFilter($request)) {
            return $redirect;
        }

        return Excel::download(
            new AcademicAttendanceExport($request),
            'Laporan Kehadiran.xlsx'
        );
    }

    public function exportAttendancePdf(Request $request)
    {
        if ($redirect = $this->validateReportFilter($request)) {
            return $redirect;
        }

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
        if ($request->filled('program_id')) {

            $participantQuery->whereHas(
                'participantWaveProgram.waveProgram',
                function ($q) use ($request) {

                    $q->where(
                        'program_id',
                        $request->program_id
                    );
                }
            );
        }

        // Filter Gelombang
        if ($request->filled('wave_id')) {

            $participantQuery->whereHas(
                'classroom.waveProgram',
                function ($q) use ($request) {

                    $q->where(
                        'wave_id',
                        $request->wave_id
                    );
                }
            );
        }

        // Filter Kelas
        if ($request->filled('classroom_id')) {

            $participantQuery->where(
                'classroom_id',
                $request->classroom_id
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

        if ($request->filled('classroom_id')) {

            $attendanceSessions = \App\Models\AttendanceSession::with([
                'schedule',
                'attendances',
            ])
                ->where(
                    'classroom_id',
                    $request->classroom_id
                )
                ->orderBy('attendance_date')
                ->orderBy('schedule_id')
                ->get();
        }


        /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

        $pdf = Pdf::loadView(
            'reports.academics.attendance-pdf',
            [
                'participants' => $participants,

                'attendanceSessions' => $attendanceSessions,

                'program' => Program::find(
                    $request->program_id
                ),

                'wave' => Wave::find(
                    $request->wave_id
                ),

                'classroom' => Classroom::find(
                    $request->classroom_id
                ),
            ]
        );


        /*
    |--------------------------------------------------------------------------
    | Ukuran PDF
    |--------------------------------------------------------------------------
    */

        $pdf->setPaper('A4', 'landscape');


        return $pdf->download(
            'Laporan Kehadiran.pdf'
        );
    }

    public function exportScoreExcel(Request $request)
    {
        if ($redirect = $this->validateReportFilter($request)) {
            return $redirect;
        }

        return Excel::download(
            new AcademicScoreExport($request),
            'Laporan Penilaian.xlsx'
        );
    }

    public function exportScorePdf(Request $request)
    {
        if ($redirect = $this->validateReportFilter($request)) {
            return $redirect;
        }

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
        if ($request->filled('program_id')) {

            $participantQuery->whereHas(
                'participantWaveProgram.waveProgram',
                function ($q) use ($request) {

                    $q->where(
                        'program_id',
                        $request->program_id
                    );
                }
            );
        }

        // Filter Gelombang
        if ($request->filled('wave_id')) {

            $participantQuery->whereHas(
                'classroom.waveProgram',
                function ($q) use ($request) {

                    $q->where(
                        'wave_id',
                        $request->wave_id
                    );
                }
            );
        }

        // Filter Kelas
        if ($request->filled('classroom_id')) {

            $participantQuery->where(
                'classroom_id',
                $request->classroom_id
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

        if ($request->filled('classroom_id')) {

            $scoreSessions = ScoreSession::with([
                'sessionTypes.type',
                'scores',
            ])
                ->where(
                    'classroom_id',
                    $request->classroom_id
                )
                ->where('is_active', true)
                ->orderBy('week')
                ->orderBy('assessment_date')
                ->get();
        }


        /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

        $pdf = Pdf::loadView(
            'reports.academics.score-pdf',
            [
                'participants' => $participants,
                'scoreSessions' => $scoreSessions,

                'program' => Program::find(
                    $request->program_id
                ),

                'wave' => Wave::find(
                    $request->wave_id
                ),

                'classroom' => Classroom::find(
                    $request->classroom_id
                ),
            ]
        );


        /*
    |--------------------------------------------------------------------------
    | Landscape
    |--------------------------------------------------------------------------
    */

        $pdf->setPaper('A4', 'landscape');


        return $pdf->download(
            'Laporan Penilaian.pdf'
        );
    }

    private function validateReportFilter(Request $request)
    {
        if (
            // !$request->filled('program_id') ||
            // !$request->filled('wave_id') ||
            !$request->filled('classroom_id')
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Silakan pilih Program, Gelombang, dan Kelas, kemudian klik "Tampilkan" terlebih dahulu.'
                );
        }

        return null;
    }
}
