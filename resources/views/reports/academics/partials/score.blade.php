{{-- ========================================= --}}
{{-- TAB PENILAIAN --}}
{{-- ========================================= --}}

<div class="d-flex justify-content-between align-items-center mb-3">

    <h5 class="mb-0">

        <i class="fas fa-chart-line text-warning mr-1"></i>

        Laporan Penilaian Peserta

    </h5>


    <div>

        <a href="{{ route('reports.academics.score.export-excel', request()->query()) }}"
            class="btn btn-success">

            <i class="fas fa-file-excel"></i>
            Excel

        </a>


        <a href="{{ route('reports.academics.score.export-pdf', request()->query()) }}"
            class="btn btn-danger">

            <i class="fas fa-file-pdf"></i>

            PDF

        </a>

    </div>

</div>


<div class="table-responsive">

    <table class="table table-bordered table-hover table-sm">

        <thead class="text-center">

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

                        {{ $participant->participantWaveProgram->participant->user->name }}

                    </th>
                @endforeach

            </tr>

        </thead>


        <tbody>

            @forelse ($scoreSessions as $session)

                {{-- Setiap jenis penilaian dalam session --}}

                @foreach ($session->sessionTypes as $sessionType)
                    <tr>

                        {{-- Minggu --}}

                        <td class="text-center">

                            {{ $session->week }}

                        </td>


                        {{-- Tanggal --}}

                        <td class="text-center">

                            {{ $session->assessment_date->format('d/m/Y') }}

                        </td>


                        {{-- Jenis Penilaian --}}

                        <td>

                            {{ $session->title }}

                            <br>

                            <small class="text-muted">

                                {{ $sessionType->type->name }}

                            </small>

                        </td>


                        {{-- Nilai masing-masing peserta --}}

                        @foreach ($participants as $participant)
                            @php

                                $score = $session->scores
                                    ->where('participant_classroom_id', $participant->id)
                                    ->where('score_type_id', $sessionType->score_type_id)
                                    ->first();

                            @endphp


                            <td class="text-center">

                                @if ($score)
                                    {{ number_format($score->score, 2) }}
                                @else
                                    <span class="text-muted">
                                        -
                                    </span>
                                @endif

                            </td>
                        @endforeach

                    </tr>
                @endforeach


            @empty

                <tr>

                    <td colspan="{{ $participants->count() + 3 }}"
                        class="text-center text-muted py-4">

                        Belum ada data penilaian.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

