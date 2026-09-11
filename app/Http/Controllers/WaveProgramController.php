<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Wave;
use App\Models\WaveProgram;
use Illuminate\Http\Request;

class WaveProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Wave $wave)
    {
        $wavePrograms = WaveProgram::with('program')
            ->withCount('classrooms')
            ->where('wave_id', $wave->id)
            ->paginate(10);

        return view(
            'wave-programs.index',
            compact('wave', 'wavePrograms')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Wave $wave)
    {
        $usedProgramIds = $wave->wavePrograms()
            ->pluck('program_id');

        $programs = Program::whereNotIn('id', $usedProgramIds)
            ->orderBy('name')
            ->get();

        if ($programs->isEmpty()) {

            return redirect()
                ->route('waves.programs.index', $wave)
                ->with(
                    'warning',
                    'Semua program sudah ditambahkan ke gelombang ini.'
                );
        }

        return view(
            'wave-programs.create',
            compact('wave', 'programs')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Wave $wave)
    {
        $request->validate([

            'program_id' => [
                'required',
                'exists:programs,id',
            ],

            'quota' => 'required|integer|min:0',

            'is_active' => 'required|boolean',

        ]);

        $exists = WaveProgram::where('wave_id', $wave->id)
            ->where('program_id', $request->program_id)
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'program_id' => 'Program tersebut sudah ada pada gelombang ini.'
                ]);
        }

        WaveProgram::create([

            'wave_id' => $wave->id,

            'program_id' => $request->program_id,

            'quota' => $request->quota,

            'is_active' => $request->is_active,

        ]);

        return redirect()
            ->route('waves.programs.index', $wave)
            ->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wave $wave, WaveProgram $program)
    {
        return view(
            'wave-programs.show',
            compact('wave', 'program')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wave $wave, WaveProgram $program)
    {
        $programs = Program::orderBy('name')->get();

        return view(
            'wave-programs.edit',
            compact('wave', 'program', 'programs')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wave $wave, WaveProgram $program)
    {
        $request->validate([

            'program_id' => 'required|exists:programs,id',

            'quota' => 'required|integer|min:0',

            'is_active' => 'required|boolean',

        ]);

        $exists = WaveProgram::where('wave_id', $wave->id)
            ->where('program_id', $request->program_id)
            ->where('id', '!=', $program->id)
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'program_id' => 'Program tersebut sudah ada pada gelombang ini.'
                ]);
        }

        $program->update([

            'program_id' => $request->program_id,

            'quota' => $request->quota,

            'is_active' => $request->is_active,

        ]);

        return redirect()
            ->route('waves.programs.index', $wave)
            ->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wave $wave, WaveProgram $program)
    {
        // Cek apakah program gelombang sudah memiliki kelas
        $sudahAdaKelas = $program->classrooms()->exists();

        if ($sudahAdaKelas) {

            return redirect()
                ->route('waves.programs.index', $wave)
                ->with(
                    'error',
                    'Program gelombang tidak dapat dihapus karena sudah memiliki kelas.'
                );
        }

        $program->delete();

        return redirect()
            ->route('waves.programs.index', $wave)
            ->with(
                'success',
                'Program berhasil dihapus.'
            );
    }
}
