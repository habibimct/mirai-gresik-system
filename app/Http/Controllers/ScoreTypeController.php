<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\ScoreType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScoreTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'wave_program_id' => 'required|exists:wave_programs,id',

            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('score_types', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'wave_program_id',
                            $request->wave_program_id
                        );
                    }),
            ],
        ]);

        ScoreType::create([
            'wave_program_id' => $request->wave_program_id,
            'name' => $request->name,
            'is_active' => true,
        ]);

        return back()
            ->with('success', 'Komponen berhasil ditambahkan.')
            ->with('activeTab', 'scores');
    }

    public function update(Request $request, ScoreType $scoreType)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('score_types', 'name')
                    ->where(function ($query) use ($scoreType) {
                        return $query->where(
                            'wave_program_id',
                            $scoreType->wave_program_id
                        );
                    })
                    ->ignore($scoreType->id),
            ],
        ]);

        $scoreType->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);

        return back()
            ->with('success', 'Komponen berhasil diperbarui.')
            ->with('activeTab', 'scores');
    }

    public function destroy(ScoreType $scoreType)
    {
        if (Score::where('score_type_id', $scoreType->id)->exists()) {
            return back()->with(
                'error',
                'Komponen sudah digunakan dan tidak dapat dihapus.'
            );
        }

        $scoreType->delete();

        return back()
            ->with('success', 'Komponen berhasil dihapus.')
            ->with('activeTab', 'scores');
    }
}