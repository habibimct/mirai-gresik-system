<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\WaveProgram;
use App\Models\ParticipantWaveProgram;
use App\Models\ParticipantClassroom;
use App\Models\ScoreType;
use App\Models\AttitudeType;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::with([
            'waveProgram.wave',
            'waveProgram.program',
        ])
            ->withCount('participantClassrooms')
            ->latest()
            ->paginate(10);

        return view(
            'classrooms.index',
            compact('classrooms')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wavePrograms = WaveProgram::with([
            'wave',
            'program'
        ])
            ->where('is_active', true)
            ->orderBy('wave_id')
            ->get();

        return view(
            'classrooms.create',
            compact('wavePrograms')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'wave_program_id' => 'required|exists:wave_programs,id',

            'code' => 'required|max:20|unique:classrooms',

            'name' => 'required|max:100',

            'capacity' => 'required|integer|min:1',

            'room' => 'nullable|max:100',

            'description' => 'nullable',

            'is_active' => 'required|boolean',

        ]);

        Classroom::create($request->all());

        return redirect()
            ->route('classrooms.index')
            ->with(
                'success',
                'Kelas berhasil ditambahkan.'
            );
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
            'participantClassrooms.scores',
            'participantClassrooms.attendances',
            'attendanceSessions.schedule',
            'attendanceSessions.attendances.participantClassroom.participantWaveProgram.participant.user',
            'scoreSessions.sessionTypes.type',
            'schedules.attendanceSessions',
            'attitudeSessions.sessionTypes.type',
            'attitudeSessions.scores',

        ]);

        // Ambil jadwal sekaligus jumlah penggunaan attendance
        $classroom->load([
            'schedules' => function ($query) {
                $query->withCount('attendanceSessions');
            },
        ]);

        $participants = ParticipantWaveProgram::with([
            'participant.user',
        ])
            ->where('wave_program_id', $classroom->wave_program_id)
            ->doesntHave('participantClassroom')
            ->orderBy('id')
            ->get();

        // ScoreType hanya milik WaveProgram kelas ini
        $scoreTypes = ScoreType::where('wave_program_id', $classroom->wave_program_id)
            ->orderBy('name')
            ->get();


        // AttitudeType hanya milik WaveProgram kelas ini
        $attitudeTypes = AttitudeType::where(
            'wave_program_id',
            $classroom->wave_program_id
        )
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return view(
            'classrooms.show',
            compact(
                'classroom',
                'participants',
                'scoreTypes',
                'attitudeTypes'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $wavePrograms = WaveProgram::with([
            'wave',
            'program',
        ])
            ->where('is_active', true)
            ->get();

        return view(
            'classrooms.edit',
            compact(
                'classroom',
                'wavePrograms'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'wave_program_id' => 'required|exists:wave_programs,id',
            'code' => 'required|max:20|unique:classrooms,code,' . $classroom->id,
            'name' => 'required|max:100',
            'capacity' => 'required|integer|min:1',
            'room' => 'nullable|max:100',
            'description' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        $classroom->update($request->all());

        return redirect()
            ->route('classrooms.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        // Kelas yang sudah memiliki peserta tidak boleh dihapus
        if ($classroom->participantClassrooms()->exists()) {

            return redirect()
                ->route('classrooms.index')
                ->with(
                    'error',
                    'Kelas tidak dapat dihapus karena sudah memiliki peserta.'
                );
        }

        // Kelas belum memiliki peserta → boleh dihapus
        $classroom->delete();

        return redirect()
            ->route('classrooms.index')
            ->with(
                'success',
                'Kelas berhasil dihapus.'
            );
    }

    /**
     * assignParticipants.
     */
    public function assignParticipants(
        Request $request,
        Classroom $classroom
    ) {
        $request->validate([

            'participants' => 'required|array',

        ]);

        foreach ($request->participants as $participant) {

            ParticipantClassroom::create([

                'participant_wave_program_id' => $participant,

                'classroom_id' => $classroom->id,

                'joined_at' => now(),

                'status' => 'Aktif',

            ]);
        }

        return back()->with(
            'success',
            'Peserta berhasil ditambahkan ke kelas.'
        );
    }

    /**
     * removeParticipant.
     */
    public function removeParticipant(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        // Pastikan peserta memang berasal dari kelas ini
        if ($participantClassroom->classroom_id != $classroom->id) {
            abort(404);
        }

        // Peserta yang sudah memiliki data attendance tidak boleh dikeluarkan
        if ($participantClassroom->attendances()->exists()) {

            return back()->with(
                'error',
                'Peserta tidak dapat dikeluarkan karena sudah memiliki data attendance.'
            );
        }

        // Belum memiliki attendance → boleh dikeluarkan
        $participantClassroom->delete();

        return back()->with(
            'success',
            'Peserta berhasil dikeluarkan dari kelas.'
        );
    }
}
