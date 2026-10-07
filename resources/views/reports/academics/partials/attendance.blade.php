{{-- ========================================= --}}
{{-- TAB KEHADIRAN --}}
{{-- ========================================= --}}

<div class="d-flex justify-content-between align-items-center mb-3">

<h5 class="mb-0">
    <i class="fas fa-calendar-check text-info mr-1"></i>
    Laporan Kehadiran Harian
</h5>


<div>

    <a href="{{ route('reports.academics.attendance.export-excel', request()->query()) }}"
        class="btn btn-success">

        <i class="fas fa-file-excel"></i>

        Excel

    </a>


    <a href="{{ route('reports.academics.attendance.export-pdf', request()->query()) }}"
        class="btn btn-danger">

        <i class="fas fa-file-pdf"></i>
        PDF

    </a>

</div>

</div>


@if (!request()->filled('classroom_id'))

<div class="alert alert-info">

    <i class="fas fa-info-circle mr-1"></i>

    Silakan pilih <strong>Kelas</strong> terlebih dahulu
    untuk menampilkan laporan kehadiran harian.

</div>
@else
<div class="attendance-table-wrapper table-responsive">

    <table class="table table-bordered table-hover table-sm attendance-table mb-0">

        <thead class="text-center">

            <tr>

                {{-- TANGGAL --}}
                <th rowspan="2" class="sticky-date" style="vertical-align: middle;">

                    Tanggal

                </th>


                {{-- MATERI --}}
                <th rowspan="2" class="sticky-material" style="vertical-align: middle;">

                    Materi

                </th>


                {{-- PESERTA --}}
                <th colspan="{{ $participants->count() }}">

                    Peserta

                </th>

            </tr>


            <tr>

                @foreach ($participants as $participant)
                    <th class="participant-column">

                        {{ $participant->participantWaveProgram->participant->user->name }}

                    </th>
                @endforeach

            </tr>

        </thead>


        <tbody>

            @forelse ($attendanceSessions as $session)
                <tr>

                    {{-- TANGGAL --}}
                    <td class="text-center sticky-date">

                        {{ $session->attendance_date->format('d/m/Y') }}

                    </td>


                    {{-- MATERI --}}
                    <td class="sticky-material">

                        {{ $session->schedule->subject ?? '-' }}

                    </td>


                    {{-- KEHADIRAN PESERTA --}}
                    @foreach ($participants as $participant)
                        @php

                            $attendance = $session->attendances->firstWhere(
                                'participant_classroom_id',
                                $participant->id,
                            );

                        @endphp


                        <td class="text-center participant-column">

                            @if ($attendance)
                                @switch($attendance->status)
                                    @case('Hadir')
                                        <span class="badge badge-success">
                                            H
                                        </span>
                                    @break

                                    @case('Izin')
                                        <span class="badge badge-warning">
                                            I
                                        </span>
                                    @break

                                    @case('Sakit')
                                        <span class="badge badge-info">
                                            S
                                        </span>
                                    @break

                                    @case('Alpha')
                                        <span class="badge badge-danger">
                                            A
                                        </span>
                                    @break

                                    @default
                                        -
                                @endswitch
                            @else
                                <span class="text-muted">
                                    -
                                </span>
                            @endif

                        </td>
                    @endforeach

                </tr>

                @empty

                    <tr>

                        <td colspan="{{ $participants->count() + 3 }}" class="text-center text-muted py-4">

                            Belum ada data kehadiran.

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>


    {{-- KETERANGAN --}}

    <div class="mt-3">

        <span class="badge badge-success mr-2">
            H = Hadir
        </span>

        <span class="badge badge-warning mr-2">
            I = Izin
        </span>

        <span class="badge badge-info mr-2">
            S = Sakit
        </span>

        <span class="badge badge-danger">
            A = Alpha
        </span>

    </div>
@endif
