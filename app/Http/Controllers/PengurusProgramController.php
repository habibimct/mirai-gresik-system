<?php

namespace App\Http\Controllers;

use App\Models\Program;

class PengurusProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('name')
            ->get();

        return view(
            'pengurus.programs.index',
            compact('programs')
        );
    }
}