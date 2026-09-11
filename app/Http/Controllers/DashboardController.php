<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Participant;
use App\Models\Classroom;
use App\Models\Program;
use App\Models\Wave;
use App\Models\ParticipantInvoice;
use App\Models\Payment;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA
        |--------------------------------------------------------------------------
        */

        $participantCount = Participant::count();

        $instructorCount = User::role('Instruktur')->count();

        $programCount = Program::count();

        $waveCount = Wave::count();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK TAMBAHAN
        |--------------------------------------------------------------------------
        */

        $classroomCount = Classroom::count();

        $invoiceCount = ParticipantInvoice::count();

        $paymentCount = Payment::count();


        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $recentActivities = Activity::with('causer')
            ->latest()
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', compact(
            'participantCount',
            'instructorCount',
            'programCount',
            'waveCount',
            'classroomCount',
            'invoiceCount',
            'paymentCount',
            'recentActivities'
        ));
    }
}