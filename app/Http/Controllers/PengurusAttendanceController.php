<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Wave;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;

class PengurusAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $waves = Wave::orderBy('name')->get();

        $classrooms = collect();

        $sessions = collect();

        $selectedClassroom = null;

        if ($request->filled('wave_id')) {

            $classrooms = Classroom::with([
                'waveProgram.wave',
                'waveProgram.program',
            ])
                ->whereHas('waveProgram', function ($query) use ($request) {

                    $query->where('wave_id', $request->wave_id);

                })
                ->orderBy('name')
                ->get();
        }

        if ($request->filled('classroom_id')) {

            $selectedClassroom = Classroom::with([
                'waveProgram.wave',
                'waveProgram.program',
                'participantClassrooms.participantWaveProgram.participant.user',
            ])->findOrFail($request->classroom_id);


            $sessions = AttendanceSession::with([
                'schedule',
                'attendances.participantClassroom.participantWaveProgram.participant.user',
            ])
                ->where('classroom_id', $selectedClassroom->id)
                ->orderByDesc('attendance_date')
                ->get();
        }

        return view('pengurus.attendances.index', compact(
            'waves',
            'classrooms',
            'sessions',
            'selectedClassroom'
        ));
    }
}