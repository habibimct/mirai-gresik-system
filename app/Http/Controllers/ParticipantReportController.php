<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ParticipantClassroom;
use App\Models\Program;
use App\Models\Wave;
use App\Models\Classroom;
use App\Exports\ParticipantReportExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ParticipantReportController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::orderBy('name')->get();
        $waves = Wave::orderBy('name')->get(); 
        
        /* 
        |-------------------------------------------------------------------------- 
        | CLASSROOM 
        |-------------------------------------------------------------------------- 
        | Filter berdasarkan gelombang SEBELUM get() 
        |-------------------------------------------------------------------------- 
        */

        $classroomQuery = Classroom::with(['waveProgram.wave', 'waveProgram.program',]);
        if ($request->filled('wave_id')) {
            $classroomQuery->whereHas('waveProgram', function ($q) use ($request) {
                $q->where('wave_id', $request->wave_id);
            });
        }

        if ($request->filled('program_id')) {
            $classroomQuery->whereHas('waveProgram', function ($q) use ($request) {
                $q->where('program_id', $request->program_id);
            });
        }

        $classrooms = $classroomQuery->orderBy('name')->get(); 
        
        /* 
        |-------------------------------------------------------------------------- 
        | PARTICIPANTS 
        |-------------------------------------------------------------------------- 
        */

        $participants = ParticipantClassroom::with(['participantWaveProgram.participant.user', 'participantWaveProgram.waveProgram.program', 'classroom.waveProgram.wave',]); /* |-------------------------------------------------------------------------- | FILTER PROGRAM |-------------------------------------------------------------------------- */
        if ($request->filled('program_id')) {
            $participants->whereHas('participantWaveProgram.waveProgram', function ($q) use ($request) {
                $q->where('program_id', $request->program_id);
            });
        } 
        
        /* 
        |-------------------------------------------------------------------------- 
        | FILTER GELOMBANG 
        |-------------------------------------------------------------------------- 
        */

        if ($request->filled('wave_id')) {
            $participants->whereHas('classroom.waveProgram', function ($q) use ($request) {
                $q->where('wave_id', $request->wave_id);
            });
        } 
        
        /* 
        |-------------------------------------------------------------------------- 
        | FILTER KELAS 
        |-------------------------------------------------------------------------- 
        */

        if ($request->filled('classroom_id')) {
            $participants->where('classroom_id', $request->classroom_id);
        } 
        
        /* 
        |-------------------------------------------------------------------------- 
        | FILTER STATUS 
        |-------------------------------------------------------------------------- 
        */

        if ($request->filled('status')) {
            $participants->whereHas('participantWaveProgram', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        } 
        
        /* 
        |-------------------------------------------------------------------------- 
        | GET PARTICIPANTS 
        |-------------------------------------------------------------------------- 
        */

        $participants = $participants->orderBy('id')->get(); 
        
        /* 
        |-------------------------------------------------------------------------- 
        | STATISTICS 
        |-------------------------------------------------------------------------- 
        */

        $totalParticipant = $participants->count();
        $totalActive = $participants->filter(function ($item) {
            return optional($item->participantWaveProgram)->status == 'Aktif';
        })->count();
        $totalGraduate = $participants->filter(function ($item) {
            return optional($item->participantWaveProgram)->status == 'Lulus';
        })->count();
        $totalInactive = $participants->filter(function ($item) {
            return optional($item->participantWaveProgram)->status == 'Nonaktif';
        })->count(); 
        
        /* 
        |-------------------------------------------------------------------------- 
        | VIEW 
        |-------------------------------------------------------------------------- 
        */

        return view('reports.participants.index', 
        compact('programs', 'waves', 'classrooms', 'participants', 'totalParticipant', 'totalActive', 'totalGraduate', 'totalInactive'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new ParticipantReportExport($request),
            'Laporan Peserta.xlsx'
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
