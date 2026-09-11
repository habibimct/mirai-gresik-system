<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ScoreType;
use App\Models\ParticipantClassroom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

        return view(
            'score-recaps.show',
            compact('classroom', 'scoreTypes', 'recaps')
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

        return $pdf->stream(
            'hasil-belajar-' . $participantClassroom->id . '.pdf'
        );
    }

    private function buildQuickChart(array $labels, array $datasets)
    {
        $config = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => $datasets,
            ],
            'options' => [
                'responsive' => true,
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

        return 'https://quickchart.io/chart?c=' . urlencode(json_encode($config));
    }
}
