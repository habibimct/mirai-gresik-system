<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ScoreSession;
use App\Models\Score;
use App\Models\ScoreSessionType;
use Illuminate\Http\Request;

class ScoreSessionController extends Controller
{
    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'week' => 'required|integer|min:1',
            'assessment_date' => 'required|date',
            'title' => 'required|string|max:255',
            'score_types' => 'required|array|min:1',
            'score_types.*' => 'exists:score_types,id',
        ]);

        $session = ScoreSession::create([
            'classroom_id' => $classroom->id,
            'week' => $request->week,
            'assessment_date' => $request->assessment_date,
            'title' => $request->title,
            'is_active' => true,
        ]);

        foreach ($request->score_types as $type) {

            $session->sessionTypes()->create([
                'score_type_id' => $type,
            ]);
        }

        return back()->with('success', 'Sesi penilaian berhasil dibuat.');
    }

    public function saveScores(Request $request, ScoreSession $scoreSession)
    {
        $request->validate([
            'scores' => 'required|array',
        ]);

        foreach ($request->scores as $participantId => $types) {

            foreach ($types as $typeId => $value) {

                if ($value === null || $value === '') {
                    continue;
                }

                Score::updateOrCreate(

                    [
                        'score_session_id' => $scoreSession->id,
                        'participant_classroom_id' => $participantId,
                        'score_type_id' => $typeId,
                    ],

                    [
                        'score' => $value,
                    ]

                );
            }
        }

        return redirect()
            ->back()
            ->with('activeTab', 'scores')->with('success', 'Nilai berhasil disimpan.');
    }

    public function destroy(
        Classroom $classroom,
        ScoreSession $scoreSession
    ) {
        // Pastikan sesi penilaian memang milik kelas ini
        if ($scoreSession->classroom_id != $classroom->id) {
            abort(404);
        }

        // Penilaian tidak boleh dihapus setelah 12 jam
        if ($scoreSession->created_at->diffInHours(now()) >= 12) {

            return redirect()
                ->back()
                ->with('activeTab', 'scores')
                ->with(
                    'error',
                    'Penilaian tidak dapat dihapus karena sudah lebih dari 12 jam.'
                );
        }

        // Hapus nilai peserta
        Score::where(
            'score_session_id',
            $scoreSession->id
        )->delete();

        // Hapus jenis penilaian
        ScoreSessionType::where(
            'score_session_id',
            $scoreSession->id
        )->delete();

        // Hapus sesi penilaian
        $scoreSession->delete();

        return redirect()
            ->back()
            ->with('activeTab', 'scores')
            ->with(
                'success',
                'Penilaian berhasil dihapus.'
            );
    }
}
