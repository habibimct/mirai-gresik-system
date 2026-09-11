<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::withCount([
            'wavePrograms as classrooms_count' => function ($query) {
                $query->whereHas('classrooms');
            }
        ])
            ->latest()
            ->paginate(10);

        return view('programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('programs.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|max:20|unique:programs,code',
            'name' => 'required|max:100',
            'description' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        Program::create($request->all());

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'code' => 'required|max:20|unique:programs,code,' . $program->id,
            'name' => 'required|max:100',
            'description' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        $program->update($request->all());

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        // Program tidak boleh dihapus jika sudah digunakan oleh kelas
        $sudahAdaKelas = $program->wavePrograms()
            ->whereHas('classrooms')
            ->exists();

        if ($sudahAdaKelas) {

            return redirect()
                ->route('programs.index')
                ->with(
                    'error',
                    'Program tidak dapat dihapus karena sudah memiliki kelas.'
                );
        }

        $program->delete();

        return redirect()
            ->route('programs.index')
            ->with(
                'success',
                'Program berhasil dihapus.'
            );
    }
}
