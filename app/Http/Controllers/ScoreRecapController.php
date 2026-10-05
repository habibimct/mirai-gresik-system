<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ScoreType;
use App\Models\ParticipantClassroom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScoreRecapController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
            'participantClassrooms',
        ])->get();

        return view(
            'score-recaps.index',
            compact('classrooms')
        );
    }

    public function show(Classroom $classroom)
    {
        $classroom->load([
            'participantClassrooms.participantWaveProgram.participant.user',
            'participantClassrooms.scores',
            'scoreSessions.sessionTypes.type',
            'attendanceSessions.attendances',

            // Rekap Nilai Sikap
            'attitudeSessions.sessionTypes.type',
            'attitudeSessions.scores',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Score Type sesuai Score Session Classroom
    |--------------------------------------------------------------------------
    */

        $scoreTypes = $classroom->scoreSessions
            ->flatMap(function ($session) {
                return $session->sessionTypes->pluck('type');
            })
            ->unique('id')
            ->sortBy('name')
            ->values();

        $recaps = [];

        foreach ($classroom->participantClassrooms as $participant) {

            $componentScores = [];

            $grandTotal = 0;
            $componentCount = 0;

            foreach ($scoreTypes as $type) {

                $scores = $participant->scores
                    ->where('score_type_id', $type->id);

                $average = $scores->count()
                    ? round($scores->avg('score'), 2)
                    : null;

                $componentScores[$type->id] = $average;

                if (!is_null($average)) {
                    $grandTotal += $average;
                    $componentCount++;
                }
            }

            $totalMeeting = $classroom->attendanceSessions->count();

            $hadir = 0;
            $izin = 0;
            $sakit = 0;
            $alpha = 0;

            foreach ($classroom->attendanceSessions as $attendanceSession) {

                $attendance = $attendanceSession->attendances
                    ->where('participant_classroom_id', $participant->id)
                    ->first();

                if (!$attendance) {
                    continue;
                }

                switch ($attendance->status) {

                    case 'Hadir':
                        $hadir++;
                        break;

                    case 'Izin':
                        $izin++;
                        break;

                    case 'Sakit':
                        $sakit++;
                        break;

                    case 'Alpha':
                        $alpha++;
                        break;
                }
            }

            $attendancePercent = $totalMeeting
                ? round(($hadir / $totalMeeting) * 100, 2)
                : 0;

            $finalScore = $componentCount
                ? round($grandTotal / $componentCount, 2)
                : 0;

            $status = 'Lulus';
            $statusColor = 'success';

            if (
                $finalScore < $classroom->minimum_score &&
                $attendancePercent < $classroom->minimum_attendance
            ) {

                $status = 'Tidak Lulus (Nilai & Kehadiran)';
                $statusColor = 'danger';
            } elseif ($finalScore < $classroom->minimum_score) {

                $status = 'Tidak Lulus (Nilai)';
                $statusColor = 'warning';
            } elseif ($attendancePercent < $classroom->minimum_attendance) {

                $status = 'Tidak Lulus (Kehadiran)';
                $statusColor = 'warning';
            }

            $recaps[] = [
                'participant' => $participant,
                'scores' => $componentScores,
                'final_score' => $finalScore,
                'attendance' => [
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpha' => $alpha,
                    'percent' => $attendancePercent,
                ],
                'status' => $status,
                'status_color' => $statusColor,
            ];
        }



        /*
        |--------------------------------------------------------------------------
        | Rekap Nilai Sikap
        |--------------------------------------------------------------------------
        */

        $attitudeTypes = $classroom->attitudeSessions
            ->flatMap(function ($session) {
                return $session->sessionTypes->pluck('type');
            })
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        $attitudeRecaps = [];

        foreach ($classroom->participantClassrooms as $participant) {
            $componentScores = [];
            $grandTotal = 0;
            $componentCount = 0;

            foreach ($attitudeTypes as $type) {
                $scores = $classroom->attitudeSessions
                    ->flatMap(function ($session) use ($participant, $type) {
                        return $session->scores
                            ->where('participant_classroom_id', $participant->id)
                            ->where('attitude_type_id', $type->id);
                    });

                $average = $scores->isNotEmpty()
                    ? round($scores->avg('score'), 2)
                    : null;

                $componentScores[$type->id] = $average;

                if ($average !== null) {
                    $grandTotal += $average;
                    $componentCount++;
                }
            }

            $finalScore = $componentCount > 0
                ? round($grandTotal / $componentCount, 2)
                : null;

            $attitudeRecaps[] = [
                'participant' => $participant,
                'scores' => $componentScores,
                'final_score' => $finalScore,
            ];
        }

        return view(
            'score-recaps.show',
            compact(
                'classroom',
                'scoreTypes',
                'recaps',
                'attitudeTypes',
                'attitudeRecaps'
            )
        );
    }

    public function updateGraduationSetting(
        Request $request,
        Classroom $classroom
    ) {
        $request->validate([

            'minimum_score' => 'required|numeric|min:0|max:100',

            'minimum_attendance' => 'required|numeric|min:0|max:100',

        ]);

        $classroom->update([

            'minimum_score' => $request->minimum_score,

            'minimum_attendance' => $request->minimum_attendance,

        ]);

        return back()->with(
            'success',
            'Pengaturan kelulusan berhasil diperbarui.'
        );
    }

    public function participant(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        $participantClassroom->load([
            'participantWaveProgram.participant.user',
            'scores.session',
            'scores.type',
        ]);

        $classroom->load([
            'scoreSessions.sessionTypes.type',
            'attendanceSessions.attendances',
        ]);

        $finalScore = round(
            $participantClassroom->scores->avg('score'),
            2
        );

        $totalMeeting = $classroom->attendanceSessions->count();

        $hadir = 0;

        foreach ($classroom->attendanceSessions as $attendanceSession) {

            $attendance = $attendanceSession->attendances
                ->where('participant_classroom_id', $participantClassroom->id)
                ->first();

            if ($attendance && $attendance->status == 'Hadir') {

                $hadir++;
            }
        }

        $attendancePercent = $totalMeeting
            ? round(($hadir / $totalMeeting) * 100, 2)
            : 0;

        $status = 'Lulus';
        $statusColor = 'success';

        if (
            $finalScore < $classroom->minimum_score &&
            $attendancePercent < $classroom->minimum_attendance
        ) {

            $status = 'Tidak Lulus (Nilai & Kehadiran)';
            $statusColor = 'danger';
        } elseif ($finalScore < $classroom->minimum_score) {

            $status = 'Tidak Lulus (Nilai)';
            $statusColor = 'warning';
        } elseif ($attendancePercent < $classroom->minimum_attendance) {

            $status = 'Tidak Lulus (Kehadiran)';
            $statusColor = 'warning';
        }

        $weeklyAverage = [];

        foreach ($classroom->scoreSessions as $session) {

            $scores = $participantClassroom->scores
                ->where('score_session_id', $session->id);

            $weeklyAverage[] = [

                'week' => $session->week,

                'average' => round(
                    $scores->avg('score') ?? 0,
                    2
                ),

            ];
        }

        return view(
            'score-recaps.participant',
            compact(
                'classroom',
                'participantClassroom',
                'finalScore',
                'attendancePercent',
                'status',
                'statusColor',
                'weeklyAverage'
            )
        );
    }


    public function participantAttitude(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        $participantClassroom->load([
            'participantWaveProgram.participant.user',
        ]);

        $classroom->load([
            'attitudeSessions.sessionTypes.type',
            'attitudeSessions.scores',
        ]);

        // Komponen sikap yang digunakan di kelas ini.
        $attitudeTypes = $classroom->attitudeSessions
            ->flatMap(function ($session) {
                return $session->sessionTypes->pluck('type');
            })
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        // Menghitung rata-rata setiap komponen sikap.
        $componentAverages = [];

        foreach ($attitudeTypes as $type) {
            $scores = $classroom->attitudeSessions
                ->flatMap(function ($session) use (
                    $participantClassroom,
                    $type
                ) {
                    return $session->scores
                        ->where(
                            'participant_classroom_id',
                            $participantClassroom->id
                        )
                        ->where('attitude_type_id', $type->id);
                });

            $componentAverages[$type->id] = $scores->isNotEmpty()
                ? round($scores->avg('score'), 2)
                : null;
        }

        // Nilai akhir adalah rata-rata komponen yang sudah dinilai.
        $validAverages = collect($componentAverages)
            ->filter(fn($value) => $value !== null);

        $finalScore = $validAverages->isNotEmpty()
            ? round($validAverages->avg(), 2)
            : null;

        // Detail nilai setiap sesi penilaian.
        $attitudeTable = [];

        foreach ($classroom->attitudeSessions as $session) {
            $row = [
                'week' => $session->week,
                'date' => $session->assessment_date,
                'scores' => [],
                'average' => null,
            ];

            foreach ($attitudeTypes as $type) {
                $score = $session->scores
                    ->where(
                        'participant_classroom_id',
                        $participantClassroom->id
                    )
                    ->where('attitude_type_id', $type->id)
                    ->first();

                $row['scores'][$type->id] = $score?->score;
            }

            $sessionScores = collect($row['scores'])
                ->filter(fn($value) => $value !== null);

            $row['average'] = $sessionScores->isNotEmpty()
                ? round($sessionScores->avg(), 2)
                : null;

            $attitudeTable[] = $row;
        }

        // Grafik perkembangan nilai sikap per minggu.
        $weeklyAverage = collect($attitudeTable)
            ->map(function ($row) {
                return [
                    'week' => $row['week'],
                    'average' => $row['average'],
                ];
            })
            ->values();

        return view(
            'score-recaps.participant-attitude',
            compact(
                'classroom',
                'participantClassroom',
                'attitudeTypes',
                'componentAverages',
                'attitudeTable',
                'finalScore',
                'weeklyAverage'
            )
        );
    }



    public function printParticipantAttitude(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        $participantClassroom->load([
            'participantWaveProgram.participant.user',
        ]);

        $classroom->load([
            'attitudeSessions.sessionTypes.type',
            'attitudeSessions.scores',
        ]);

        $attitudeTypes = $classroom->attitudeSessions
            ->flatMap(function ($session) {
                return $session->sessionTypes->pluck('type');
            })
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        $componentAverages = [];

        foreach ($attitudeTypes as $type) {
            $scores = $classroom->attitudeSessions
                ->flatMap(function ($session) use (
                    $participantClassroom,
                    $type
                ) {
                    return $session->scores
                        ->where(
                            'participant_classroom_id',
                            $participantClassroom->id
                        )
                        ->where('attitude_type_id', $type->id);
                });

            $componentAverages[$type->id] = $scores->isNotEmpty()
                ? round($scores->avg('score'), 2)
                : null;
        }

        $validAverages = collect($componentAverages)
            ->filter(fn($value) => $value !== null);

        $finalScore = $validAverages->isNotEmpty()
            ? round($validAverages->avg(), 2)
            : null;

        $attitudeTable = [];

        foreach ($classroom->attitudeSessions as $session) {
            $row = [
                'week' => $session->week,
                'date' => $session->assessment_date,
                'scores' => [],
                'average' => null,
            ];

            foreach ($attitudeTypes as $type) {
                $score = $session->scores
                    ->where(
                        'participant_classroom_id',
                        $participantClassroom->id
                    )
                    ->where('attitude_type_id', $type->id)
                    ->first();

                $row['scores'][$type->id] = $score?->score;
            }

            $sessionScores = collect($row['scores'])
                ->filter(fn($value) => $value !== null);

            $row['average'] = $sessionScores->isNotEmpty()
                ? round($sessionScores->avg(), 2)
                : null;

            $attitudeTable[] = $row;
        }

        // Data grafik perkembangan per komponen
        $attitudeChart = [
            'labels' => [],
            'datasets' => [],
        ];

        foreach ($attitudeTable as $row) {
            $attitudeChart['labels'][] = 'Minggu ' . $row['week'];
        }

        $chartColors = [
            '#28a745',
            '#007bff',
            '#ffc107',
            '#dc3545',
            '#6f42c1',
            '#17a2b8',
            '#fd7e14',
            '#20c997',
        ];

        foreach ($attitudeTypes as $index => $type) {
            $data = [];

            foreach ($attitudeTable as $row) {
                $data[] = $row['scores'][$type->id];
            }

            $attitudeChart['datasets'][] = [
                'label' => $type->name,
                'data' => $data,
                'color' => $chartColors[$index % count($chartColors)],
            ];
        }

        // Data grafik perkembangan nilai rata-rata
        $averageChart = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($attitudeTable as $row) {
            $averageChart['labels'][] = 'Minggu ' . $row['week'];
            $averageChart['data'][] = $row['average'];
        }


        $componentDatasets = [];

        foreach ($attitudeChart['datasets'] as $item) {
            $componentDatasets[] = [
                'label' => $item['label'],
                'data' => $item['data'],
                'fill' => false,
                'spanGaps' => true,
            ];
        }

        $componentChartUrl = $this->buildQuickChart(
            $attitudeChart['labels'],
            $componentDatasets,
            900,
            180
        );

        $averageChartUrl = $this->buildQuickChart(
            $averageChart['labels'],
            [[
                'label' => 'Rata-rata',
                'data' => $averageChart['data'],
                'fill' => false,
                'spanGaps' => true,
            ]],
            900,
            180
        );

        return view(
            'score-recaps.participant-attitude-pdf',
            compact(
                'classroom',
                'participantClassroom',
                'attitudeTypes',
                'componentAverages',
                'attitudeTable',
                'finalScore',
                'attitudeChart',
                'averageChart',
                'componentChartUrl',
                'averageChartUrl',
            )
        );
    }


    public function downloadParticipantAttitude(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        ini_set('memory_limit', '256M');

        $participantClassroom->load([
            'participantWaveProgram.participant.user',
        ]);

        $classroom->load([
            'waveProgram',
            'attitudeSessions.sessionTypes.type',
            'attitudeSessions.scores',
        ]);

        $attitudeTypes = $classroom->attitudeSessions
            ->flatMap(fn($session) => $session->sessionTypes->pluck('type'))
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        $componentAverages = [];

        foreach ($attitudeTypes as $type) {
            $scores = $classroom->attitudeSessions
                ->flatMap(function ($session) use (
                    $participantClassroom,
                    $type
                ) {
                    return $session->scores
                        ->where('participant_classroom_id', $participantClassroom->id)
                        ->where('attitude_type_id', $type->id);
                });

            $componentAverages[$type->id] = $scores->isNotEmpty()
                ? round($scores->avg('score'), 2)
                : null;
        }

        $validAverages = collect($componentAverages)
            ->filter(fn($value) => $value !== null);

        $finalScore = $validAverages->isNotEmpty()
            ? round($validAverages->avg(), 2)
            : null;

        $attitudeTable = [];

        foreach ($classroom->attitudeSessions as $session) {
            $row = [
                'week' => $session->week,
                'date' => $session->assessment_date,
                'scores' => [],
                'average' => null,
            ];

            foreach ($attitudeTypes as $type) {
                $score = $session->scores
                    ->where('participant_classroom_id', $participantClassroom->id)
                    ->where('attitude_type_id', $type->id)
                    ->first();

                $row['scores'][$type->id] = $score?->score;
            }

            $sessionScores = collect($row['scores'])
                ->filter(fn($value) => $value !== null);

            $row['average'] = $sessionScores->isNotEmpty()
                ? round($sessionScores->avg(), 2)
                : null;

            $attitudeTable[] = $row;
        }

        $attitudeChart = [
            'labels' => [],
            'datasets' => [],
        ];

        foreach ($attitudeTable as $row) {
            $attitudeChart['labels'][] = 'Minggu ' . $row['week'];
        }

        $chartColors = [
            '#28a745',
            '#007bff',
            '#ffc107',
            '#dc3545',
            '#6f42c1',
            '#17a2b8',
            '#fd7e14',
            '#20c997',
        ];

        foreach ($attitudeTypes as $index => $type) {
            $data = [];

            foreach ($attitudeTable as $row) {
                $data[] = $row['scores'][$type->id];
            }

            $attitudeChart['datasets'][] = [
                'label' => $type->name,
                'data' => $data,
                'borderColor' => $chartColors[$index % count($chartColors)],
                'backgroundColor' => $chartColors[$index % count($chartColors)],
                'borderWidth' => 2,
                'fill' => false,
                'tension' => 0.3,
                'spanGaps' => true,
            ];
        }

        $averageChart = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($attitudeTable as $row) {
            $averageChart['labels'][] = 'Minggu ' . $row['week'];
            $averageChart['data'][] = $row['average'];
        }

        $componentDatasets = [];

        foreach ($attitudeChart['datasets'] as $item) {
            $componentDatasets[] = [
                'label' => $item['label'],
                'data' => $item['data'],
                'fill' => false,
                'spanGaps' => true,
            ];
        }

        $componentChartUrl = $this->buildQuickChart(
            $attitudeChart['labels'],
            $componentDatasets
        );

        $averageChartUrl = $this->buildQuickChart(
            $averageChart['labels'],
            [[
                'label' => 'Rata-rata Nilai',
                'data' => $averageChart['data'],
                'fill' => false,
                'spanGaps' => true,
            ]]
        );

        $logoPath = public_path('images/mgs-logo3.png');

        $logoBase64 = 'data:image/png;base64,' . base64_encode(
            file_get_contents($logoPath)
        );

        $pdf = Pdf::loadView(
            'score-recaps.participant-attitude-download',
            compact(
                'classroom',
                'participantClassroom',
                'attitudeTypes',
                'componentAverages',
                'attitudeTable',
                'finalScore',
                'attitudeChart',
                'averageChart',
                'componentChartUrl',
                'averageChartUrl',
                'logoBase64',
            )
        );

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
        ]);

        $namaPeserta = $participantClassroom->participantWaveProgram
            ->participant->user->name ?? 'Peserta';

        return $pdf->download(
            'nilai-sikap-' . Str::slug($namaPeserta) . '.pdf'
        );
    }

    public function printParticipant(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        $participantClassroom->load([
            'participantWaveProgram.participant.user',
            'scores.session',
            'scores.type',
        ]);

        $classroom->load([
            'scoreSessions.sessionTypes.type',
            'attendanceSessions.attendances',
        ]);

        $finalScore = round(
            $participantClassroom->scores->avg('score'),
            2
        );

        $totalMeeting = $classroom->attendanceSessions->count();

        $hadir = 0;
        $izin = 0;
        $sakit = 0;
        $alpha = 0;

        foreach ($classroom->attendanceSessions as $attendanceSession) {

            $attendance = $attendanceSession->attendances
                ->where('participant_classroom_id', $participantClassroom->id)
                ->first();

            if (!$attendance) {
                continue;
            }

            switch ($attendance->status) {

                case 'Hadir':
                    $hadir++;
                    break;

                case 'Izin':
                    $izin++;
                    break;

                case 'Sakit':
                    $sakit++;
                    break;

                default:
                    $alpha++;
                    break;
            }
        }

        $attendancePercent = $totalMeeting
            ? round(($hadir / $totalMeeting) * 100, 2)
            : 0;

        $status = (
            $finalScore >= $classroom->minimum_score &&
            $attendancePercent >= $classroom->minimum_attendance
        )
            ? 'LULUS'
            : 'TIDAK LULUS';

        $weeklyAverage = [];

        foreach ($classroom->scoreSessions as $session) {

            $scores = $participantClassroom->scores
                ->where('score_session_id', $session->id);

            $weeklyAverage[] = [

                'week' => 'M-' . $session->week,

                'average' => round(
                    $scores->avg('score') ?? 0,
                    2
                ),

            ];
        }

        /*
    |--------------------------------------------------------------------------
    | Score Type sesuai Program + Gelombang / Classroom
    |--------------------------------------------------------------------------
    */

        $scoreTypes = $classroom->scoreSessions
            ->flatMap(function ($session) {
                return $session->sessionTypes->pluck('type');
            })
            ->unique('id')
            ->sortBy('name')
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Score Table
    |--------------------------------------------------------------------------
    */

        $scoreTable = [];

        foreach ($classroom->scoreSessions as $session) {

            $row = [

                'week' => $session->week,
                'date' => $session->assessment_date,

                'scores' => [],

                'average' => 0,

            ];

            foreach ($scoreTypes as $type) {

                $score = $participantClassroom->scores
                    ->where('score_session_id', $session->id)
                    ->where('score_type_id', $type->id)
                    ->first();

                $row['scores'][$type->id] = $score?->score;
            }

            $scores = collect($row['scores'])
                ->filter(fn($v) => $v !== null);

            $row['average'] = $scores->count()
                ? round($scores->avg(), 2)
                : null;

            $scoreTable[] = $row;
        }

        /*
    |--------------------------------------------------------------------------
    | Component Chart
    |--------------------------------------------------------------------------
    */

        $componentChart = [];

        foreach ($scoreTypes as $type) {

            $values = [];

            foreach ($classroom->scoreSessions as $session) {

                $score = $participantClassroom->scores
                    ->where('score_session_id', $session->id)
                    ->where('score_type_id', $type->id)
                    ->first();

                $values[] = $score?->score;
            }

            $componentChart[] = [

                'label' => $type->name,

                'data' => $values,

            ];
        }

        $weeks = $classroom->scoreSessions
            ->pluck('week')
            ->map(fn($week) => "Minggu {$week}")
            ->values();

        return view(
            'score-recaps.print-participant',
            compact(
                'classroom',
                'participantClassroom',
                'finalScore',
                'attendancePercent',
                'hadir',
                'izin',
                'sakit',
                'alpha',
                'status',
                'weeklyAverage',
                'scoreTypes',
                'scoreTable',
                'componentChart',
                'weeks'
            )
        );
    }

    public function exportParticipantPdf(
        Classroom $classroom,
        ParticipantClassroom $participantClassroom
    ) {
        $participantClassroom->load([
            'participantWaveProgram.participant.user',
            'scores.session',
            'scores.type',
        ]);

        $classroom->load([
            'scoreSessions.sessionTypes.type',
            'attendanceSessions.attendances',
        ]);

        $finalScore = round(
            $participantClassroom->scores->avg('score'),
            2
        );

        $totalMeeting = $classroom->attendanceSessions->count();

        $hadir = 0;
        $izin = 0;
        $sakit = 0;
        $alpha = 0;

        foreach ($classroom->attendanceSessions as $attendanceSession) {

            $attendance = $attendanceSession->attendances
                ->where('participant_classroom_id', $participantClassroom->id)
                ->first();

            if (!$attendance) {
                continue;
            }

            switch ($attendance->status) {

                case 'Hadir':
                    $hadir++;
                    break;

                case 'Izin':
                    $izin++;
                    break;

                case 'Sakit':
                    $sakit++;
                    break;

                default:
                    $alpha++;
                    break;
            }
        }

        $attendancePercent = $totalMeeting
            ? round(($hadir / $totalMeeting) * 100, 2)
            : 0;

        $status = (
            $finalScore >= $classroom->minimum_score &&
            $attendancePercent >= $classroom->minimum_attendance
        )
            ? 'LULUS'
            : 'TIDAK LULUS';


        $weeklyAverage = [];

        foreach ($classroom->scoreSessions as $session) {

            $scores = $participantClassroom->scores
                ->where('score_session_id', $session->id);

            $weeklyAverage[] = [

                'week' => 'M-' . $session->week,

                'average' => round(
                    $scores->avg('score') ?? 0,
                    2
                ),

            ];
        }

        /*
|--------------------------------------------------------------------------
| Score Type sesuai Program + Gelombang
|--------------------------------------------------------------------------
*/
        $scoreTypes = $classroom->scoreSessions
            ->flatMap(function ($session) {
                return $session->sessionTypes->pluck('type');
            })
            ->unique('id')
            ->sortBy('name')
            ->values();

        $scoreTable = [];

        foreach ($classroom->scoreSessions as $session) {

            $row = [

                'week' => $session->week,
                'date' => $session->assessment_date,

                'scores' => [],

                'average' => 0,

            ];

            foreach ($scoreTypes as $type) {

                $score = $participantClassroom->scores
                    ->where('score_session_id', $session->id)
                    ->where('score_type_id', $type->id)
                    ->first();

                $row['scores'][$type->id] = $score?->score;
            }

            $scores = collect($row['scores'])
                ->filter(fn($v) => $v !== null);

            $row['average'] = $scores->count()
                ? round($scores->avg(), 2)
                : null;

            $scoreTable[] = $row;
        }

        $componentChart = [];

        foreach ($scoreTypes as $type) {

            $values = [];

            foreach ($classroom->scoreSessions as $session) {

                $score = $participantClassroom->scores
                    ->where('score_session_id', $session->id)
                    ->where('score_type_id', $type->id)
                    ->first();

                $values[] = $score?->score;
            }

            $componentChart[] = [

                'label' => $type->name,

                'data' => $values,

            ];
        }
        $weeks = $classroom->scoreSessions
            ->pluck('week')
            ->map(fn($week) => "Minggu {$week}")
            ->values();

        $componentDatasets = [];
        foreach ($componentChart as $item) {
            $componentDatasets[] = [
                'label' => $item['label'],
                'data' => $item['data'],
                'fill' => false,
                'spanGaps' => true,
            ];
        }

        $componentChartUrl = $this->buildQuickChart(
            $weeks->toArray(),
            $componentDatasets
        );

        $averageChartUrl = $this->buildQuickChart(
            collect($weeklyAverage)->pluck('week')->toArray(),
            [[
                'label' => 'Rata-rata',
                'data' => collect($weeklyAverage)->pluck('average')->toArray(),
                'fill' => false,
                'spanGaps' => true,
            ]]
        );

        $pdf = Pdf::loadView(
            'score-recaps.participant-pdf',
            compact(
                'classroom',
                'participantClassroom',
                'scoreTable',
                'scoreTypes',
                'finalScore',
                'attendancePercent',
                'status',
                'hadir',
                'izin',
                'sakit',
                'alpha',
                'weeks',
                'componentChart',
                'weeklyAverage',
                'componentChartUrl',
                'averageChartUrl',
            )
        );

        $pdf->setPaper('a4', 'portrait');

        /*
|--------------------------------------------------------------------------
| Render PDF terlebih dahulu
|--------------------------------------------------------------------------
*/

        $pdf->render();

        $canvas = $pdf->getCanvas();

        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();

        $font = $fontMetrics->getFont('Helvetica', 'normal');

        /*
|--------------------------------------------------------------------------
| Footer
|--------------------------------------------------------------------------
*/

        $canvas->page_text(

            40,

            820,

            "LPK Mirai Gresik",

            $font,

            9,

            [0, 0, 0]

        );

        /*
|--------------------------------------------------------------------------
| Nomor halaman
|--------------------------------------------------------------------------
*/

        $canvas->page_text(

            500,

            820,

            "Halaman {PAGE_NUM} / {PAGE_COUNT}",

            $font,

            9,

            [0, 0, 0]

        );

        $namaPeserta = $participantClassroom->participantWaveProgram
            ->participant->user->name ?? 'Peserta';

        return $pdf->download(
            'hasil-belajar-' . Str::slug($namaPeserta) . '.pdf'
        );
    }


    private function buildQuickChart(
        array $labels,
        array $datasets,
        int $width = 500,
        int $height = 300
    ) {
        $config = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => $datasets,
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'legend' => [
                    'display' => true,
                ],
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ]],
                ],
            ],
        ];

        return 'https://quickchart.io/chart?w=900&h=400&devicePixelRatio=2&c='
            . urlencode(json_encode($config));
    }
}
