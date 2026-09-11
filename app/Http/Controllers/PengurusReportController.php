<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParticipantClassroom;
use App\Models\Program;
use App\Models\Score;
use App\Models\Attendance;
use App\Models\Wave;
use App\Models\Classroom;
use App\Models\ParticipantInvoice;

class PengurusReportController extends Controller
{
    public function participants(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

        $programId = $request->program_id;
        $waveId = $request->wave_id;
        $classroomId = $request->classroom_id;


        /*
    |--------------------------------------------------------------------------
    | PROGRAM
    |--------------------------------------------------------------------------
    */

        $programs = Program::orderBy('name')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | GELOMBANG
    |--------------------------------------------------------------------------
    */

        $waves = Wave::orderBy('name')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */

        $classroomsQuery = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])
            ->orderBy('name');


        if ($programId) {

            $classroomsQuery->whereHas(
                'waveProgram',
                function ($query) use ($programId) {

                    $query->where('program_id', $programId);
                }
            );
        }


        if ($waveId) {

            $classroomsQuery->whereHas(
                'waveProgram',
                function ($query) use ($waveId) {

                    $query->where('wave_id', $waveId);
                }
            );
        }


        $classrooms = $classroomsQuery->get();


        /*
    |--------------------------------------------------------------------------
    | PESERTA
    |--------------------------------------------------------------------------
    |
    | ParticipantClassroom
    |     └── ParticipantWaveProgram
    |             └── Participant
    |                     └── User
    |
    */

        $participantsQuery = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'participantWaveProgram.waveProgram.wave',
            'classroom.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);


        /*
    |--------------------------------------------------------------------------
    | FILTER PROGRAM
    |--------------------------------------------------------------------------
    */

        if ($programId) {

            $participantsQuery->whereHas(
                'classroom.waveProgram',
                function ($query) use ($programId) {

                    $query->where('program_id', $programId);
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTER GELOMBANG
    |--------------------------------------------------------------------------
    */

        if ($waveId) {

            $participantsQuery->whereHas(
                'classroom.waveProgram',
                function ($query) use ($waveId) {

                    $query->where('wave_id', $waveId);
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTER KELAS
    |--------------------------------------------------------------------------
    */

        if ($classroomId) {

            $participantsQuery->where(
                'classroom_id',
                $classroomId
            );
        }


        /*
    |--------------------------------------------------------------------------
    | HASIL PESERTA
    |--------------------------------------------------------------------------
    */

        $participants = $participantsQuery
            ->orderBy('id')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

        $totalParticipants = $participants->count();


        $activeParticipants = $participants
            ->filter(function ($participant) {

                return $participant
                    ->participantWaveProgram
                    ->participant
                    ->status === 'Aktif';
            })
            ->count();


        $graduatedParticipants = $participants
            ->filter(function ($participant) {

                return $participant
                    ->participantWaveProgram
                    ->participant
                    ->status === 'Lulus';
            })
            ->count();


        /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

        return view(
            'pengurus.reports.participants',
            compact(
                'programs',
                'waves',
                'classrooms',
                'participants',
                'totalParticipants',
                'activeParticipants',
                'graduatedParticipants'
            )
        );
    }

    public function participantsPrint(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

        $programId = $request->program_id;
        $waveId = $request->wave_id;
        $classroomId = $request->classroom_id;


        /*
    |--------------------------------------------------------------------------
    | DATA PROGRAM
    |--------------------------------------------------------------------------
    */

        $program = $programId
            ? Program::find($programId)
            : null;


        /*
    |--------------------------------------------------------------------------
    | DATA GELOMBANG
    |--------------------------------------------------------------------------
    */

        $wave = $waveId
            ? Wave::find($waveId)
            : null;


        /*
    |--------------------------------------------------------------------------
    | DATA KELAS
    |--------------------------------------------------------------------------
    */

        $classroom = $classroomId
            ? Classroom::with([
                'waveProgram.program',
                'waveProgram.wave',
            ])->find($classroomId)
            : null;


        /*
    |--------------------------------------------------------------------------
    | PESERTA
    |--------------------------------------------------------------------------
    */

        $participantsQuery = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);


        if ($programId) {

            $participantsQuery->whereHas(
                'participantWaveProgram.waveProgram',
                function ($query) use ($programId) {

                    $query->where('program_id', $programId);
                }
            );
        }


        if ($waveId) {

            $participantsQuery->whereHas(
                'classroom.waveProgram',
                function ($query) use ($waveId) {

                    $query->where('wave_id', $waveId);
                }
            );
        }


        if ($classroomId) {

            $participantsQuery->where(
                'classroom_id',
                $classroomId
            );
        }


        $participants = $participantsQuery->get();


        /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

        $totalParticipants = $participants->count();


        $activeParticipants = $participants
            ->filter(function ($participant) {

                return $participant
                    ->participantWaveProgram
                    ->participant
                    ->status === 'Aktif';
            })
            ->count();


        $graduatedParticipants = $participants
            ->filter(function ($participant) {

                return $participant
                    ->participantWaveProgram
                    ->participant
                    ->status === 'Lulus';
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | NOMOR LAPORAN
        |--------------------------------------------------------------------------
        */

        $reportNumber =
            'LP/PES/' .
            ($wave?->code ?? 'ALL') .
            '/' .
            ($program?->code ?? 'ALL') .
            '/' .
            now()->format('Ymd-His') .
            '/' .
            str_pad($participants->count(), 4, '0', STR_PAD_LEFT);


        /*
    |--------------------------------------------------------------------------
    | CETAK
    |--------------------------------------------------------------------------
    */

        return view(
            'pengurus.reports.participants-print',
            compact(
                'program',
                'wave',
                'classroom',
                'participants',
                'totalParticipants',
                'activeParticipants',
                'graduatedParticipants',
                'reportNumber'
            )
        );
    }

    public function academic(Request $request)
    {
        $programId   = $request->program_id;
        $waveId      = $request->wave_id;
        $classroomId = $request->classroom_id;

        /*
    |--------------------------------------------------------------------------
    | Data Filter
    |--------------------------------------------------------------------------
    */

        $programs = Program::orderBy('name')->get();

        $waves = Wave::orderBy('name')->get();

        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])
            ->orderBy('name')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Query Peserta
    |--------------------------------------------------------------------------
    */

        $participantsQuery = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);

        if ($programId) {

            $participantsQuery->whereHas(
                'participantWaveProgram.waveProgram',
                function ($query) use ($programId) {

                    $query->where('program_id', $programId);
                }
            );
        }

        if ($waveId) {

            $participantsQuery->whereHas(
                'classroom.waveProgram',
                function ($query) use ($waveId) {

                    $query->where('wave_id', $waveId);
                }
            );
        }

        if ($classroomId) {

            $participantsQuery->where(
                'classroom_id',
                $classroomId
            );
        }

        $participantClassrooms = $participantsQuery
            ->get()
            ->sortBy(function ($participantClassroom) {

                return optional(
                    optional(
                        $participantClassroom->participantWaveProgram
                    )->participant
                )->user->name ?? '';
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Data Akademik
        |--------------------------------------------------------------------------
        */

        $academicData = $participantClassrooms->map(
            function ($participantClassroom) {

                $participant =
                    $participantClassroom
                    ->participantWaveProgram
                    ?->participant;

                $user =
                    $participant?->user;

                /*
        |--------------------------------------------------------------------------
        | Classroom
        |--------------------------------------------------------------------------
        */

                $classroom =
                    $participantClassroom->classroom;


                /*
        |--------------------------------------------------------------------------
        | Attendance
        |--------------------------------------------------------------------------
        */

                $attendances = Attendance::where(
                    'participant_classroom_id',
                    $participantClassroom->id
                )->get();

                $totalAttendance = $attendances->count();

                $present = $attendances
                    ->where('status', 'Hadir')
                    ->count();

                $permission = $attendances
                    ->where('status', 'Izin')
                    ->count();

                $sick = $attendances
                    ->where('status', 'Sakit')
                    ->count();

                $absent = $attendances
                    ->whereIn('status', ['Alpa', 'Alpha'])
                    ->count();

                $attendancePercentage = $totalAttendance > 0
                    ? round(
                        ($present / $totalAttendance) * 100,
                        2
                    )
                    : 0;


                /*
        |--------------------------------------------------------------------------
        | Score
        |--------------------------------------------------------------------------
        */

                $scores = Score::where(
                    'participant_classroom_id',
                    $participantClassroom->id
                )->get();

                $averageScore = $scores->count() > 0
                    ? round($scores->avg('score'), 2)
                    : null;


                /*
        |--------------------------------------------------------------------------
        | Keterangan
        |--------------------------------------------------------------------------
        |
        | Mengikuti pengaturan kelulusan dari Classroom.
        | Tidak ada nilai minimum yang di-hard-code.
        |
        */

                if ($averageScore === null) {

                    $description = 'Belum Dinilai';
                } elseif (
                    $averageScore < $classroom?->minimum_score &&
                    $attendancePercentage < $classroom?->minimum_attendance
                ) {

                    $description = 'Tidak Lulus (Nilai & Kehadiran)';
                } elseif (
                    $averageScore < $classroom?->minimum_score
                ) {

                    $description = 'Tidak Lulus (Nilai)';
                } elseif (
                    $attendancePercentage < $classroom?->minimum_attendance
                ) {

                    $description = 'Tidak Lulus (Kehadiran)';
                } else {

                    $description = 'Lulus';
                }


                /*
        |--------------------------------------------------------------------------
        | Return Data
        |--------------------------------------------------------------------------
        */

                return [

                    'participant_classroom_id'
                    => $participantClassroom->id,

                    'name'
                    => $user?->name ?? '-',

                    'classroom'
                    => $classroom?->name ?? '-',

                    'total_attendance'
                    => $totalAttendance,

                    'present'
                    => $present,

                    'permission'
                    => $permission,

                    'sick'
                    => $sick,

                    'absent'
                    => $absent,

                    'attendance_percentage'
                    => $attendancePercentage,

                    'average_score'
                    => $averageScore,

                    'description'
                    => $description,
                ];
            }
        );


        /*
    |--------------------------------------------------------------------------
    | Statistik
    |--------------------------------------------------------------------------
    */

        $totalParticipants = $academicData->count();

        $participantsWithScore = $academicData
            ->whereNotNull('average_score')
            ->count();

        $participantsWithoutScore = $academicData
            ->whereNull('average_score')
            ->count();

        $averageAttendance = $academicData->count() > 0
            ? round(
                $academicData->avg('attendance_percentage'),
                2
            )
            : 0;

        $averageScore = $academicData
            ->whereNotNull('average_score')
            ->avg('average_score');

        $averageScore = $averageScore !== null
            ? round($averageScore, 2)
            : 0;


        /*
    |--------------------------------------------------------------------------
    | Filter Terpilih
    |--------------------------------------------------------------------------
    */

        $program = $programId
            ? Program::find($programId)
            : null;

        $wave = $waveId
            ? Wave::find($waveId)
            : null;

        $classroom = $classroomId
            ? Classroom::with(
                'waveProgram.wave'
            )->find($classroomId)
            : null;


        /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

        return view(
            'pengurus.reports.academic',
            compact(
                'academicData',
                'totalParticipants',
                'participantsWithScore',
                'participantsWithoutScore',
                'averageAttendance',
                'averageScore',

                'program',
                'wave',
                'classroom',

                'programs',
                'waves',
                'classrooms'
            )
        );
    }

    public function academicPrint(Request $request)
    {
        $programId   = $request->program_id;
        $waveId      = $request->wave_id;
        $classroomId = $request->classroom_id;


        /*
    |--------------------------------------------------------------------------
    | Query Peserta
    |--------------------------------------------------------------------------
    */

        $participantsQuery = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'classroom.waveProgram.wave',
        ]);


        // Filter Program
        if ($programId) {

            $participantsQuery->whereHas(
                'participantWaveProgram.waveProgram',
                function ($query) use ($programId) {

                    $query->where('program_id', $programId);
                }
            );
        }


        // Filter Gelombang
        if ($waveId) {

            $participantsQuery->whereHas(
                'classroom.waveProgram',
                function ($query) use ($waveId) {

                    $query->where('wave_id', $waveId);
                }
            );
        }


        // Filter Kelas
        if ($classroomId) {

            $participantsQuery->where(
                'classroom_id',
                $classroomId
            );
        }


        $participantClassrooms = $participantsQuery
            ->get()
            ->sortBy(function ($participantClassroom) {

                return optional(
                    optional(
                        $participantClassroom->participantWaveProgram
                    )->participant
                )->user->name ?? '';
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Data Akademik
        |--------------------------------------------------------------------------
        */

        $academicData = $participantClassrooms->map(
            function ($participantClassroom) {

                $participant =
                    $participantClassroom
                    ->participantWaveProgram
                    ?->participant;

                $user =
                    $participant?->user;


                /*
        |--------------------------------------------------------------------------
        | Classroom
        |--------------------------------------------------------------------------
        */

                $classroom =
                    $participantClassroom->classroom;


                /*
        |--------------------------------------------------------------------------
        | Attendance
        |--------------------------------------------------------------------------
        */

                $attendances = Attendance::where(
                    'participant_classroom_id',
                    $participantClassroom->id
                )->get();

                $totalAttendance = $attendances->count();

                $present = $attendances
                    ->where('status', 'Hadir')
                    ->count();

                $permission = $attendances
                    ->where('status', 'Izin')
                    ->count();

                $sick = $attendances
                    ->where('status', 'Sakit')
                    ->count();

                $absent = $attendances
                    ->whereIn('status', ['Alpa', 'Alpha'])
                    ->count();

                $attendancePercentage = $totalAttendance > 0
                    ? round(
                        ($present / $totalAttendance) * 100,
                        2
                    )
                    : 0;


                /*
        |--------------------------------------------------------------------------
        | Score
        |--------------------------------------------------------------------------
        */

                $scores = Score::where(
                    'participant_classroom_id',
                    $participantClassroom->id
                )->get();

                $averageScore = $scores->count() > 0
                    ? round($scores->avg('score'), 2)
                    : null;


                /*
        |--------------------------------------------------------------------------
        | Keterangan
        |--------------------------------------------------------------------------
        |
        | Mengikuti pengaturan kelulusan pada Classroom.
        |
        */

                if ($averageScore === null) {

                    $description = 'Belum Dinilai';
                } elseif (
                    $averageScore < $classroom?->minimum_score &&
                    $attendancePercentage < $classroom?->minimum_attendance
                ) {

                    $description = 'Tidak Lulus (Nilai & Kehadiran)';
                } elseif (
                    $averageScore < $classroom?->minimum_score
                ) {

                    $description = 'Tidak Lulus (Nilai)';
                } elseif (
                    $attendancePercentage < $classroom?->minimum_attendance
                ) {

                    $description = 'Tidak Lulus (Kehadiran)';
                } else {

                    $description = 'Lulus';
                }


                /*
        |--------------------------------------------------------------------------
        | Return Data
        |--------------------------------------------------------------------------
        */

                return [

                    'participant_classroom_id'
                    => $participantClassroom->id,

                    'name'
                    => $user?->name ?? '-',

                    'classroom'
                    => $classroom?->name ?? '-',

                    'total_attendance'
                    => $totalAttendance,

                    'present'
                    => $present,

                    'permission'
                    => $permission,

                    'sick'
                    => $sick,

                    'absent'
                    => $absent,

                    'attendance_percentage'
                    => $attendancePercentage,

                    'average_score'
                    => $averageScore,

                    'description'
                    => $description,

                ];
            }
        );


        /*
    |--------------------------------------------------------------------------
    | Statistik
    |--------------------------------------------------------------------------
    */

        $totalParticipants = $academicData->count();

        $participantsWithScore = $academicData
            ->whereNotNull('average_score')
            ->count();

        $participantsWithoutScore = $academicData
            ->whereNull('average_score')
            ->count();

        $averageAttendance = $academicData->count() > 0
            ? round(
                $academicData->avg('attendance_percentage'),
                2
            )
            : 0;

        $averageScore = $academicData
            ->whereNotNull('average_score')
            ->avg('average_score');

        $averageScore = $averageScore !== null
            ? round($averageScore, 2)
            : 0;


        /*
    |--------------------------------------------------------------------------
    | Filter Terpilih
    |--------------------------------------------------------------------------
    */

        $program = $programId
            ? Program::find($programId)
            : null;

        $wave = $waveId
            ? Wave::find($waveId)
            : null;

        $classroom = $classroomId
            ? Classroom::with(
                'waveProgram.wave'
            )->find($classroomId)
            : null;


        return view(
            'pengurus.reports.academic-print',
            compact(
                'academicData',
                'totalParticipants',
                'participantsWithScore',
                'participantsWithoutScore',
                'averageAttendance',
                'averageScore',
                'program',
                'wave',
                'classroom'
            )
        );
    }



    public function finance(Request $request)
    {
        $programId   = $request->program_id;
        $waveId      = $request->wave_id;
        $classroomId = $request->classroom_id;


        /*
    |--------------------------------------------------------------------------
    | FILTER DATA
    |--------------------------------------------------------------------------
    */

        $programs = Program::orderBy('name')->get();

        $waves = Wave::orderBy('name')->get();

        $classrooms = Classroom::with([
            'waveProgram.program',
            'waveProgram.wave',
        ])
            ->orderBy('name')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | QUERY INVOICE FINAL
    |--------------------------------------------------------------------------
    */

        $invoiceQuery = ParticipantInvoice::with([
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
        ])
            ->where('is_final', true);


        /*
    |--------------------------------------------------------------------------
    | FILTER PROGRAM
    |--------------------------------------------------------------------------
    */

        if ($programId) {

            $invoiceQuery->whereHas(
                'participantClassroom.participantWaveProgram.waveProgram',
                function ($query) use ($programId) {

                    $query->where(
                        'program_id',
                        $programId
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTER GELOMBANG
    |--------------------------------------------------------------------------
    */

        if ($waveId) {

            $invoiceQuery->whereHas(
                'participantClassroom.classroom.waveProgram',
                function ($query) use ($waveId) {

                    $query->where(
                        'wave_id',
                        $waveId
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTER KELAS
    |--------------------------------------------------------------------------
    */

        if ($classroomId) {

            $invoiceQuery->whereHas(
                'participantClassroom',
                function ($query) use ($classroomId) {

                    $query->where(
                        'classroom_id',
                        $classroomId
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | AMBIL DATA
    |--------------------------------------------------------------------------
    */

        $invoices = $invoiceQuery
            ->get();


        /*
    |--------------------------------------------------------------------------
    | GROUP PER PESERTA + PROGRAM
    |--------------------------------------------------------------------------
    |
    | Jangan hanya group berdasarkan participant_classroom_id.
    | Karena satu peserta bisa memiliki invoice dari beberapa program.
    |
    */

        $financeData = $invoices
            ->groupBy(function ($invoice) {

                $participantClassroomId =
                    $invoice->participant_classroom_id;

                $programId =
                    $invoice
                    ->participantClassroom
                    ?->participantWaveProgram
                    ?->waveProgram
                    ?->program_id;

                return $participantClassroomId
                    . '-' .
                    $programId;
            })
            ->map(function ($invoiceGroup) {

                $firstInvoice = $invoiceGroup->first();

                $participantClassroom =
                    $firstInvoice->participantClassroom;

                $participant =
                    $participantClassroom
                    ?->participantWaveProgram
                    ?->participant;

                $user =
                    $participant?->user;


                /*
            |--------------------------------------------------------------------------
            | TOTAL
            |--------------------------------------------------------------------------
            */

                $totalAmount = $invoiceGroup->sum(
                    'total_amount'
                );

                $paidAmount = $invoiceGroup->sum(
                    'paid_amount'
                );

                $remaining = max(
                    0,
                    (float) $totalAmount
                        -
                        (float) $paidAmount
                );


                /*
            |--------------------------------------------------------------------------
            | STATUS PEMBAYARAN
            |--------------------------------------------------------------------------
            */

                if ($remaining <= 0) {

                    $status = 'LUNAS';
                } elseif ($paidAmount > 0) {

                    $status = 'SEBAGIAN';
                } else {

                    $status = 'BELUM BAYAR';
                }


                return [

                    'participant_classroom_id'
                    => $participantClassroom?->id,

                    'program_id'
                    => $participantClassroom
                        ?->participantWaveProgram
                        ?->waveProgram
                        ?->program_id,

                    'name'
                    => $user?->name ?? '-',

                    'program'
                    => $participantClassroom
                        ?->participantWaveProgram
                        ?->waveProgram
                        ?->program
                        ?->name ?? '-',

                    'wave'
                    => $participantClassroom
                        ?->classroom
                        ?->waveProgram
                        ?->wave
                        ?->name ?? '-',

                    'classroom'
                    => $participantClassroom
                        ?->classroom
                        ?->name ?? '-',

                    'total_amount'
                    => $totalAmount,

                    'paid_amount'
                    => $paidAmount,

                    'remaining'
                    => $remaining,

                    'status'
                    => $status,

                ];
            })
            ->sortBy('name')
            ->values();


        /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

        $totalParticipants = $financeData->count();

        $totalAmount = $financeData->sum(
            'total_amount'
        );

        $totalPaid = $financeData->sum(
            'paid_amount'
        );

        $totalOutstanding = $financeData->sum(
            'remaining'
        );

        $paidParticipants = $financeData
            ->where('status', 'LUNAS')
            ->count();

        $partialParticipants = $financeData
            ->where('status', 'SEBAGIAN')
            ->count();

        $unpaidParticipants = $financeData
            ->where('status', 'BELUM BAYAR')
            ->count();


        /*
    |--------------------------------------------------------------------------
    | FILTER TERPILIH
    |--------------------------------------------------------------------------
    */

        $program = $programId
            ? Program::find($programId)
            : null;

        $wave = $waveId
            ? Wave::find($waveId)
            : null;

        $classroom = $classroomId
            ? Classroom::with([
                'waveProgram.program',
                'waveProgram.wave',
            ])->find($classroomId)
            : null;


        /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

        return view(
            'pengurus.reports.finance',
            compact(
                'financeData',

                'totalParticipants',
                'totalAmount',
                'totalPaid',
                'totalOutstanding',

                'paidParticipants',
                'partialParticipants',
                'unpaidParticipants',

                'program',
                'wave',
                'classroom',

                'programs',
                'waves',
                'classrooms'
            )
        );
    }

    public function financePrint(Request $request)
    {
        $programId   = $request->program_id;
        $waveId      = $request->wave_id;
        $classroomId = $request->classroom_id;


        /*
    |--------------------------------------------------------------------------
    | QUERY INVOICE FINAL
    |--------------------------------------------------------------------------
    */

        $invoiceQuery = ParticipantInvoice::with([
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
        ])
            ->where('is_final', true);


        /*
    |--------------------------------------------------------------------------
    | FILTER PROGRAM
    |--------------------------------------------------------------------------
    */

        if ($programId) {

            $invoiceQuery->whereHas(
                'participantClassroom.participantWaveProgram.waveProgram',
                function ($query) use ($programId) {

                    $query->where(
                        'program_id',
                        $programId
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTER GELOMBANG
    |--------------------------------------------------------------------------
    */

        if ($waveId) {

            $invoiceQuery->whereHas(
                'participantClassroom.classroom.waveProgram',
                function ($query) use ($waveId) {

                    $query->where(
                        'wave_id',
                        $waveId
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTER KELAS
    |--------------------------------------------------------------------------
    */

        if ($classroomId) {

            $invoiceQuery->whereHas(
                'participantClassroom',
                function ($query) use ($classroomId) {

                    $query->where(
                        'classroom_id',
                        $classroomId
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | DATA INVOICE
    |--------------------------------------------------------------------------
    */

        $invoices = $invoiceQuery
            ->get();


        /*
    |--------------------------------------------------------------------------
    | GROUP PESERTA + PROGRAM
    |--------------------------------------------------------------------------
    */

        $financeData = $invoices
            ->groupBy(function ($invoice) {

                $participantClassroomId =
                    $invoice->participant_classroom_id;

                $programId =
                    $invoice
                    ->participantClassroom
                    ?->participantWaveProgram
                    ?->waveProgram
                    ?->program_id;

                return $participantClassroomId
                    . '-' .
                    $programId;
            })
            ->map(function ($invoiceGroup) {

                $firstInvoice =
                    $invoiceGroup->first();

                $participantClassroom =
                    $firstInvoice->participantClassroom;

                $participant =
                    $participantClassroom
                    ?->participantWaveProgram
                    ?->participant;

                $user =
                    $participant?->user;


                /*
            |--------------------------------------------------------------------------
            | TOTAL
            |--------------------------------------------------------------------------
            */

                $totalAmount = $invoiceGroup->sum(
                    'total_amount'
                );

                $paidAmount = $invoiceGroup->sum(
                    'paid_amount'
                );

                $remaining = max(
                    0,
                    (float) $totalAmount
                        -
                        (float) $paidAmount
                );


                /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

                if ($remaining <= 0) {

                    $status = 'LUNAS';
                } elseif ($paidAmount > 0) {

                    $status = 'SEBAGIAN';
                } else {

                    $status = 'BELUM BAYAR';
                }


                return [

                    'name'
                    => $user?->name ?? '-',

                    'program'
                    => $participantClassroom
                        ?->participantWaveProgram
                        ?->waveProgram
                        ?->program
                        ?->name ?? '-',

                    'wave'
                    => $participantClassroom
                        ?->classroom
                        ?->waveProgram
                        ?->wave
                        ?->name ?? '-',

                    'classroom'
                    => $participantClassroom
                        ?->classroom
                        ?->name ?? '-',

                    'total_amount'
                    => $totalAmount,

                    'paid_amount'
                    => $paidAmount,

                    'remaining'
                    => $remaining,

                    'status'
                    => $status,

                ];
            })
            ->sortBy('name')
            ->values();


        /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

        $totalParticipants =
            $financeData->count();

        $totalAmount =
            $financeData->sum('total_amount');

        $totalPaid =
            $financeData->sum('paid_amount');

        $totalOutstanding =
            $financeData->sum('remaining');

        $paidParticipants =
            $financeData
            ->where('status', 'LUNAS')
            ->count();

        $partialParticipants =
            $financeData
            ->where('status', 'SEBAGIAN')
            ->count();

        $unpaidParticipants =
            $financeData
            ->where('status', 'BELUM BAYAR')
            ->count();


        /*
    |--------------------------------------------------------------------------
    | INFORMASI FILTER
    |--------------------------------------------------------------------------
    */

        $program = $programId
            ? Program::find($programId)
            : null;

        $wave = $waveId
            ? Wave::find($waveId)
            : null;

        $classroom = $classroomId
            ? Classroom::with([
                'waveProgram.program',
                'waveProgram.wave',
            ])->find($classroomId)
            : null;


        return view(
            'pengurus.reports.finance-print',
            compact(
                'financeData',

                'totalParticipants',
                'totalAmount',
                'totalPaid',
                'totalOutstanding',

                'paidParticipants',
                'partialParticipants',
                'unpaidParticipants',

                'program',
                'wave',
                'classroom'
            )
        );
    }
}
