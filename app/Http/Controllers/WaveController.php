<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Wave;
use Illuminate\Http\Request;

class WaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $waves = Wave::withCount([
            'wavePrograms as classrooms_count' => function ($query) {
                $query->whereHas('classrooms');
            }
        ])
            ->latest()
            ->paginate(10);

        return view('waves.index', compact('waves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('waves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'code'               => 'required|max:20|unique:waves,code',
            'name'               => 'required|max:100',
            'year'               => 'required|digits:4',
            'registration_start' => 'nullable|date',
            'registration_end'   => 'nullable|date',
            'training_start'     => 'nullable|date',
            'training_end'       => 'nullable|date',
            'is_active'          => 'required|boolean',
            'description'        => 'nullable',
        ]);

        Wave::create($request->all());

        return redirect()
            ->route('waves.index')
            ->with('success', 'Gelombang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wave $wave)
    {
        return view('waves.show', compact('wave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wave $wave)
    {
        return view('waves.edit', compact('wave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wave $wave)
    {
        $request->validate([
            'code'               => 'required|max:20|unique:waves,code,' . $wave->id,
            'name'               => 'required|max:100',
            'year'               => 'required|digits:4',
            'registration_start' => 'nullable|date',
            'registration_end'   => 'nullable|date',
            'training_start'     => 'nullable|date',
            'training_end'       => 'nullable|date',
            'is_active'          => 'required|boolean',
            'description'        => 'nullable',
        ]);

        $wave->update($request->all());

        return redirect()
            ->route('waves.index')
            ->with('success', 'Gelombang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wave $wave)
    {
        // Cek apakah gelombang sudah memiliki kelas
        $sudahAdaKelas = $wave->wavePrograms()
            ->whereHas('classrooms')
            ->exists();

        // Jika sudah ada kelas, penghapusan ditolak
        if ($sudahAdaKelas) {

            return redirect()
                ->route('waves.index')
                ->with(
                    'error',
                    'Gelombang tidak dapat dihapus karena sudah memiliki kelas.'
                );
        }

        // Jika belum ada kelas, gelombang boleh dihapus
        $wave->delete();

        return redirect()
            ->route('waves.index')
            ->with(
                'success',
                'Gelombang berhasil dihapus.'
            );
    }
}
