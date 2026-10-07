<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h5 class="mb-0">
            <i class="fas fa-user-check text-info mr-1"></i>
            Laporan Nilai Sikap
        </h5>

        <small class="text-muted">
            Rekap penilaian sikap peserta berdasarkan sesi penilaian.
        </small>
    </div>

    <div>

        <a href="{{ route(
            'reports.academics.attitude.export-excel',
            request()->query()
        ) }}"
            class="btn btn-success">

            <i class="fas fa-file-excel mr-1"></i>
            Excel

        </a>

        <a href="{{ route(
            'reports.academics.attitude.export-pdf',
            request()->query()
        ) }}"
            class="btn btn-danger">

            <i class="fas fa-file-pdf mr-1"></i>
            PDF

        </a>

    </div>

</div>


@if (!request()->filled('classroom_id'))

    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-1"></i>
        Silakan pilih Kelas terlebih dahulu untuk melihat laporan nilai sikap.
    </div>

@elseif ($attitudeSessions->isEmpty())

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle mr-1"></i>
        Belum ada data penilaian sikap untuk kelas ini.
    </div>

@else

    <div class="table-responsive">

        <table class="table table-bordered table-sm text-center">

            <thead>

                <tr>
                    <th rowspan="2" style="vertical-align: middle;">
                        Minggu
                    </th>

                    <th rowspan="2" style="vertical-align: middle;">
                        Tanggal
                    </th>

                    <th rowspan="2" style="vertical-align: middle;">
                        Penilaian
                    </th>

                    <th colspan="{{ $participants->count() }}">
                        Peserta
                    </th>
                </tr>

                <tr>

                    @foreach ($participants as $participant)

                        <th style="min-width: 120px;">
                            {{ optional($participant->participantWaveProgram->participant->user)->name ?? '-' }}
                        </th>

                    @endforeach

                </tr>

            </thead>

            <tbody>

                @foreach ($attitudeSessions as $session)

                    @foreach ($session->sessionTypes as $sessionType)

                        <tr>

                            <td>
                                {{ $session->week }}
                            </td>

                            <td>
                                {{ optional($session->assessment_date)->format('d/m/Y') ?? $session->assessment_date }}
                            </td>

                            <td class="text-left">
                                {{ optional($sessionType->type)->name ?? '-' }}
                            </td>


                            @foreach ($participants as $participant)

                                @php
                                    $score = $session->scores
                                        ->where(
                                            'participant_classroom_id',
                                            $participant->id
                                        )
                                        ->where(
                                            'attitude_type_id',
                                            $sessionType->attitude_type_id
                                        )
                                        ->first();
                                @endphp

                                <td>

                                    @if ($score)
                                        {{ number_format($score->score, 2) }}
                                    @else
                                        -
                                    @endif

                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- REKAP AKHIR --}}
    <div class="card mt-4">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line mr-1"></i>
                Rekap Nilai Sikap
            </h3>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-sm text-center">

                    <thead>

                        <tr>

                            <th>
                                No
                            </th>

                            <th class="text-left">
                                Peserta
                            </th>

                            @foreach ($attitudeTypes as $type)

                                <th>
                                    {{ $type->name }}
                                </th>

                            @endforeach

                            <th>
                                Nilai Akhir
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($attitudeRecaps as $index => $recap)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td class="text-left">

                                    {{ optional($recap['participant']->participantWaveProgram->participant->user)->name ?? '-' }}

                                </td>


                                @foreach ($attitudeTypes as $type)

                                    <td>

                                        @php
                                            $value = $recap['componentAverages'][$type->id] ?? null;
                                        @endphp

                                        {{ $value !== null ? number_format($value, 2) : '-' }}

                                    </td>

                                @endforeach


                                <td class="font-weight-bold">

                                    @if ($recap['finalScore'] !== null)
                                        {{ number_format($recap['finalScore'], 2) }}
                                    @else
                                        -
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endif