<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Classroom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with([
            'classroom.waveProgram.wave',
            'classroom.waveProgram.program',
        ])
            ->withCount('attendanceSessions')
            ->latest()
            ->paginate(10);

        return view(
            'schedules.index',
            compact('schedules')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Classroom $classroom)
    {
        return view(
            'classrooms.schedule.create',
            compact('classroom')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'schedule_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'is_active' => 'required|boolean',
        ]);

        /* 
        |-------------------------------------------------------------------------- 
        | Tentukan Hari dari Tanggal 
        |-------------------------------------------------------------------------- 
        */

        $date = Carbon::parse($request->schedule_date);
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $day = $days[$date->format('l')];
        /* 
        |-------------------------------------------------------------------------- 
        | Simpan Jadwal 
        |-------------------------------------------------------------------------- 
        */
        $classroom->schedules()->create(['subject' => $request->subject, 'schedule_date' => $request->schedule_date, 'day' => $day, 'start_time' => $request->start_time, 'end_time' => $request->end_time, 'is_active' => $request->is_active,]);
        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        $classroom->load([

            'waveProgram.wave',

            'waveProgram.program',

            'participantClassrooms.participantWaveProgram.participant.user',

            'schedules',

        ]);

        return view(
            'classrooms.show',
            compact('classroom')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $classrooms = Classroom::with([
            'waveProgram.wave',
            'waveProgram.program'
        ])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'schedules.edit',
            compact(
                'schedule',
                'classrooms'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Classroom $classroom,
        Schedule $schedule
    ) {
        $request->validate([

            'subject' => 'required|string|max:255',

            'schedule_date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required',

            'is_active' => 'required|boolean',

        ]);


        /*
    |--------------------------------------------------------------------------
    | Tentukan Hari dari Tanggal
    |--------------------------------------------------------------------------
    */

        $date = Carbon::parse(
            $request->schedule_date
        );

        $days = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $day = $days[$date->format('l')];


        /*
    |--------------------------------------------------------------------------
    | Update Jadwal
    |--------------------------------------------------------------------------
    */

        $schedule->update([

            'subject' => $request->subject,

            'schedule_date' => $request->schedule_date,

            'day' => $day,

            'start_time' => $request->start_time,

            'end_time' => $request->end_time,

            'is_active' => $request->is_active,

        ]);


        return back()
            ->with(
                'success',
                'Jadwal berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Classroom $classroom,
        Schedule $schedule
    ) {
        // Pastikan jadwal memang milik kelas ini
        if ($schedule->classroom_id != $classroom->id) {
            abort(404);
        }

        // Jadwal yang sudah digunakan attendance tidak boleh dihapus
        if ($schedule->attendanceSessions()->exists()) {

            return back()
                ->with(
                    'error',
                    'Jadwal tidak dapat dihapus karena sudah digunakan untuk attendance.'
                );
        }

        $schedule->delete();

        return back()
            ->with(
                'success',
                'Jadwal berhasil dihapus.'
            );
    }
}
