<?php

namespace App\Exports;

use App\Models\Classroom;
use App\Models\ParticipantClassroom;
use App\Models\Program;
use App\Models\Wave;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class AcademicReportExport implements FromView
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
            'attendances',
            'scores',
        ]);

        if ($this->request->filled('program_id')) {
            $query->whereHas('participantWaveProgram.waveProgram', function ($q) {
                $q->where('program_id', $this->request->program_id);
            });
        }

        if ($this->request->filled('wave_id')) {
            $query->whereHas('classroom.waveProgram', function ($q) {
                $q->where('wave_id', $this->request->wave_id);
            });
        }

        if ($this->request->filled('classroom_id')) {
            $query->where('classroom_id', $this->request->classroom_id);
        }

        return view('reports.academics.excel', [
            'participants' => $query->get(),
            'program'      => Program::find($this->request->program_id),
            'wave'         => Wave::find($this->request->wave_id),
            'classroom'    => Classroom::find($this->request->classroom_id),
        ]);
    }
}