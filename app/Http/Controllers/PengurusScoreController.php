<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;

class PengurusScoreController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])
            ->withCount('participantClassrooms')
            ->orderBy('id', 'desc')
            ->get();

        return view('pengurus.scores.index', compact('classrooms'));
    }

    public function show(Classroom $classroom)
    {
        $classroom->load([
            'waveProgram.program',
            'waveProgram.wave',

            'participantClassrooms.participantWaveProgram.participant.user',

            'participantClassrooms.scores.type',
            'participantClassrooms.scores.session',
        ]);

        $scoreSessions = $classroom->scoreSessions()
            ->with([
                'sessionTypes.type',
                'scores.type',
            ])
            ->orderByDesc('assessment_date')
            ->orderByDesc('week')
            ->get();

        return view('pengurus.scores.show', compact(
            'classroom',
            'scoreSessions'
        ));
    }
}
