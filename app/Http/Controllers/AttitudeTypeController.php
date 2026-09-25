<?php

namespace App\Http\Controllers;

use App\Models\AttitudeType;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AttitudeTypeController extends Controller
{
    /**
     * Menyimpan komponen sikap baru.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        AttitudeType::create([
            'wave_program_id' => $classroom->wave_program_id,
            'name' => $request->name,
            'is_active' => true,
        ]);

        return back()->with(
            'success',
            'Komponen sikap berhasil ditambahkan.'
        );
    }

    /**
     * Memperbarui komponen sikap.
     */
    public function update(
        Request $request,
        Classroom $classroom,
        AttitudeType $attitudeType
    ) {
        // Pastikan komponen memang milik program kelas ini
        if (
            $attitudeType->wave_program_id
            != $classroom->wave_program_id
        ) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attitudeType->update([
            'name' => $request->name,
        ]);

        return back()->with(
            'success',
            'Komponen sikap berhasil diperbarui.'
        );
    }

    /**
     * Menghapus komponen sikap.
     */
    public function destroy(
        Classroom $classroom,
        AttitudeType $attitudeType
    ) {
        // Pastikan komponen memang milik program kelas ini
        if (
            $attitudeType->wave_program_id
            != $classroom->wave_program_id
        ) {
            abort(404);
        }

        // Jangan hapus jika sudah digunakan dalam penilaian
        if ($attitudeType->scores()->exists()) {
            return back()->with(
                'error',
                'Komponen sikap tidak dapat dihapus karena sudah digunakan dalam penilaian.'
            );
        }

        $attitudeType->delete();

        return back()->with(
            'success',
            'Komponen sikap berhasil dihapus.'
        );
    }
}