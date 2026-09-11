<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Classroom;
use App\Models\Participant;

class PengurusDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | PROGRAM
        |--------------------------------------------------------------------------
        */

        $totalPrograms = Program::count();


        /*
        |--------------------------------------------------------------------------
        | KELAS
        |--------------------------------------------------------------------------
        */

        $totalClassrooms = Classroom::count();


        /*
        |--------------------------------------------------------------------------
        | PESERTA AKTIF
        |--------------------------------------------------------------------------
        */

        $totalActiveParticipants = Participant::where(
            'status',
            'Aktif'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PESERTA LULUS
        |--------------------------------------------------------------------------
        */

        $totalGraduatedParticipants = Participant::where(
            'status',
            'Lulus'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('pengurus.dashboard', compact(
            'totalPrograms',
            'totalClassrooms',
            'totalActiveParticipants',
            'totalGraduatedParticipants'
        ));
    }
}