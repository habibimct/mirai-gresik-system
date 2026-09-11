<?php

namespace App\Http\Controllers;

use App\Models\ParticipantClassroom;
use Illuminate\Http\Request;

class ParticipantProgramController extends Controller
{
    public function index(Request $request)
    {
        $participant = auth()->user()->participant;

        if (!$participant) {
            abort(
                403,
                'Akun ini belum terhubung dengan data peserta.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Semua kelas/program yang diikuti peserta
        |--------------------------------------------------------------------------
        */

        $programs = ParticipantClassroom::with([
            'participantWaveProgram.waveProgram.program',
            'participantWaveProgram.waveProgram.wave',
            'classroom',
        ])
            ->whereHas(
                'participantWaveProgram',
                function ($query) use ($participant) {

                    $query->where(
                        'participant_id',
                        $participant->id
                    );
                }
            )
            ->orderBy('id')
            ->get();

        if ($programs->isEmpty()) {
            abort(
                404,
                'Data program peserta belum ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Program yang dipilih
        |--------------------------------------------------------------------------
        */

        $participantClassroom = null;

        if ($request->filled('participant_classroom')) {

            $participantClassroom = $programs
                ->firstWhere(
                    'id',
                    $request->participant_classroom
                );

            if (!$participantClassroom) {
                abort(404, 'Program peserta tidak ditemukan.');
            }

        } else {

            /*
            | Default:
            | gunakan program pertama agar tampilan lama tetap berjalan.
            */

            $participantClassroom = $programs->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Load detail program yang dipilih
        |--------------------------------------------------------------------------
        */

        $participantClassroom->load([
            'participantWaveProgram.waveProgram.program',
            'participantWaveProgram.waveProgram.wave',
            'classroom',
            'attendances.session.schedule',
            'scores.session',
            'scores.type',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Absensi
        |--------------------------------------------------------------------------
        */

        $attendances = $participantClassroom
            ->attendances
            ->sortByDesc(function ($attendance) {
                return $attendance->session->attendance_date;
            });

        $totalAttendance = $attendances->count();

        $hadir = $attendances
            ->where('status', 'Hadir')
            ->count();

        $izin = $attendances
            ->where('status', 'Izin')
            ->count();

        $sakit = $attendances
            ->where('status', 'Sakit')
            ->count();

        $alpha = $attendances
            ->where('status', 'Alpha')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Nilai
        |--------------------------------------------------------------------------
        */

        $scores = $participantClassroom
            ->scores
            ->sortByDesc(function ($score) {
                return $score->session->week;
            });

        $averageScore = $scores->count()
            ? $scores->avg('score')
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Persentase Kehadiran
        |--------------------------------------------------------------------------
        */

        $attendancePercentage = $totalAttendance > 0
            ? ($hadir / $totalAttendance) * 100
            : 0;

        $minimumAttendance = $participantClassroom
            ->classroom
            ->minimum_attendance;

        $attendancePassed =
            $attendancePercentage >= $minimumAttendance;

        if ($attendancePassed) {

            $attendanceStatus = 'Memenuhi';
            $attendanceStatusClass = 'text-green-600';

        } else {

            $attendanceStatus = 'Perlu perhatian';
            $attendanceStatusClass = 'text-red-600';
        }

        return view(
            'participants.program.index',
            compact(
                'programs',
                'participantClassroom',
                'attendances',
                'scores',
                'totalAttendance',
                'hadir',
                'izin',
                'sakit',
                'alpha',
                'averageScore',
                'attendancePercentage',
                'minimumAttendance',
                'attendancePassed',
                'attendanceStatus',
                'attendanceStatusClass'
            )
        );
    }
}