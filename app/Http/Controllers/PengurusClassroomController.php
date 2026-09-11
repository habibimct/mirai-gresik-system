<?php

namespace App\Http\Controllers;

use App\Models\Classroom;

class PengurusClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
            'participantClassrooms.participantWaveProgram.participant',
        ])
            ->orderBy('name')
            ->get();

        return view(
            'pengurus.classrooms.index',
            compact('classrooms')
        );
    }

    public function show(Classroom $classroom)
    {
        $classroom->load([
            'waveProgram.program',
            'waveProgram.wave',
            'participantClassrooms.participantWaveProgram.participant.user',
        ]);

        return view(
            'pengurus.classrooms.show',
            compact('classroom')
        );
    }
}
