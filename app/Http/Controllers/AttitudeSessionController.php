<?php

namespace App\Http\Controllers;

use App\Models\AttitudeSession;
use App\Models\AttitudeType;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AttitudeSessionController extends Controller
{
    /**
     * Menyimpan penilaian sikap baru.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'week' => 'required|integer|min:1',
            'assessment_date' => 'required|date',
            'title' => 'required|string|max:255',
            'attitude_types' => 'required|array|min:1',
            'attitude_types.*' => 'integer|exists:attitude_types,id',
        ]);

        // Pastikan semua komponen sikap memang milik program kelas ini
        $attitudeTypes = AttitudeType::whereIn(
            'id',
            $request->attitude_types
        )
            ->where(
                'wave_program_id',
                $classroom->wave_program_id
            )
            ->where('is_active', true)
            ->get();

        if ($attitudeTypes->count() !== count($request->attitude_types)) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Komponen sikap yang dipilih tidak sesuai dengan program kelas.'
                );
        }

        $session = AttitudeSession::create([
            'classroom_id' => $classroom->id,
            'week' => $request->week,
            'assessment_date' => $request->assessment_date,
            'title' => $request->title,
            'is_active' => true,
        ]);

        foreach ($attitudeTypes as $attitudeType) {
            $session->sessionTypes()->create([
                'attitude_type_id' => $attitudeType->id,
            ]);
        }

        return back()->with(
            'success',
            'Penilaian sikap berhasil dibuat.'
        );
    }

    public function scores(
        Classroom $classroom,
        AttitudeSession $attitudeSession
    ) {
        // Pastikan sesi penilaian memang milik kelas ini
        if ($attitudeSession->classroom_id != $classroom->id) {
            abort(404);
        }

        $attitudeSession->load([
            'sessionTypes.type',
        ]);

        $classroom->load([
            'participantClassrooms.participantWaveProgram.participant.user',
        ]);

        return view(
            'classrooms.attitudes.scores',
            compact(
                'classroom',
                'attitudeSession'
            )
        );
    }

    public function destroy(
        Classroom $classroom,
        AttitudeSession $attitudeSession
    ) {
        // Pastikan sesi memang milik kelas ini
        if ($attitudeSession->classroom_id != $classroom->id) {
            abort(404);
        }

        // Sesi hanya boleh dihapus dalam waktu 6 jam
        if ($attitudeSession->created_at->lt(now()->subHours(6))) {
            return back()->with(
                'error',
                'Penilaian sikap hanya dapat dihapus dalam waktu 6 jam setelah dibuat.'
            );
        }

        $attitudeSession->delete();

        return back()->with(
            'success',
            'Penilaian sikap berhasil dihapus.'
        );
    }
}
