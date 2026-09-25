<?php

namespace App\Http\Controllers;

use App\Models\AttitudeScore;
use App\Models\AttitudeSession;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AttitudeScoreController extends Controller
{
    public function store(Request $request, Classroom $classroom, AttitudeSession $attitudeSession)
    {
        // Pastikan sesi penilaian memang milik kelas ini
        if ($attitudeSession->classroom_id != $classroom->id) {
            abort(404);
        }

        $request->validate([
            'scores' => 'required|array',
            'scores.*.participant_classroom_id' => 'required|integer|exists:participant_classrooms,id',
            'scores.*.attitude_type_id' => 'required|integer|exists:attitude_types,id',
            'scores.*.score' => 'nullable|numeric|min:0|max:100',
            'scores.*.notes' => 'nullable|string',
        ]);

        foreach ($request->scores as $scoreData) {

            // Lewati jika nilai kosong
            if (
                !isset($scoreData['score']) ||
                $scoreData['score'] === ''
            ) {
                continue;
            }

            $participantClassroomId = $scoreData['participant_classroom_id'];

            AttitudeScore::updateOrCreate(
                [
                    'attitude_session_id' => $attitudeSession->id,
                    'participant_classroom_id' => $participantClassroomId,
                    'attitude_type_id' => $scoreData['attitude_type_id'],
                ],
                [
                    'score' => $scoreData['score'],
                    'notes' => $request->input(
                        'participant_notes.' . $participantClassroomId
                    ),
                ]
            );
        }

        return back()->with(
            'success',
            'Nilai sikap berhasil disimpan.'
        );
    }
}
