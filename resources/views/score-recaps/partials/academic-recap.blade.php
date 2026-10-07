    {{-- =========================================================
        REKAP NILAI
    ========================================================== --}}

    <div class="card card-primary card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-table mr-1"></i>

                Rekap Nilai Peserta

            </h3>
            <div class="card-tools">

                {{-- Cetak Semua Hasil Belajar --}}
                <a href="{{ route('score-recaps.print-all', [
                    'classroom' => $classroom,
                ]) }}"
                    target="_blank" class="btn btn-secondary btn-sm mr-2" title="Cetak Semua Hasil Belajar">
                    <i class="fas fa-print mr-1"></i>
                    Cetak Semua Hasil Belajar
                </a>

                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#graduationSettingModal"
                    title="Pengaturan Kelulusan">

                    <i class="fas fa-cogs mr-1"></i>
                    Pengaturan Kelulusan

                </button>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-striped mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="55" class="text-center align-middle">

                                No

                            </th>


                            <th style="min-width: 220px;" class="align-middle">

                                Peserta

                            </th>


                            {{-- Komponen nilai --}}
                            @foreach ($scoreTypes as $type)
                                <th class="text-center align-middle" style="min-width: 110px;">

                                    {{ $type->name }}

                                </th>
                            @endforeach


                            <th width="110" class="text-center align-middle">

                                Nilai Akhir

                            </th>


                            <th width="120" class="text-center align-middle">

                                Kehadiran

                            </th>


                            <th width="120" class="text-center align-middle">

                                Status

                            </th>


                            <th width="130" class="text-center align-middle">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($recaps as $recap)

                            @php

                                $attendancePercent = $recap['attendance']['percent'] ?? 0;

                                $finalScore = $recap['final_score'] ?? null;

                                $minimumAttendance = $classroom->minimum_attendance ?? 0;

                                $minimumScore = $classroom->minimum_score ?? 0;

                            @endphp


                            <tr>


                                {{-- No --}}
                                <td class="text-center align-middle">

                                    {{ $loop->iteration }}

                                </td>



                                {{-- Nama --}}
                                <td class="align-middle">

                                    <strong>

                                        {{ $recap['participant']->participantWaveProgram->participant->user->name }}

                                    </strong>

                                </td>



                                {{-- Nilai setiap komponen --}}
                                @foreach ($scoreTypes as $type)
                                    <td class="text-center align-middle">

                                        @if (isset($recap['scores'][$type->id]))
                                            <span class="font-weight-bold">

                                                {{ number_format($recap['scores'][$type->id], 2) }}

                                            </span>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>
                                @endforeach



                                {{-- Nilai Akhir --}}
                                <td class="text-center align-middle">

                                    @if ($finalScore !== null)
                                        <span class="badge badge-primary px-3 py-2" style="font-size: 14px;">

                                            {{ number_format($finalScore, 2) }}

                                        </span>
                                    @else
                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endif

                                </td>



                                {{-- Kehadiran --}}
                                <td class="text-center align-middle">

                                    @if ($attendancePercent >= $minimumAttendance)
                                        <span class="badge badge-success px-3 py-2">

                                            <i class="fas fa-check mr-1"></i>

                                            {{ number_format($attendancePercent, 2) }}%

                                        </span>
                                    @else
                                        <span class="badge badge-danger px-3 py-2">

                                            <i class="fas fa-times mr-1"></i>

                                            {{ number_format($attendancePercent, 2) }}%

                                        </span>
                                    @endif

                                </td>

                                {{-- Status --}}
                                <td class="text-center align-middle">

                                    <span class="badge badge-{{ $recap['status_color'] }}"
                                        id="status{{ $recap['participant']->id }}" data-score="{{ $finalScore }}"
                                        data-attendance="{{ $attendancePercent }}">

                                        @if ($recap['status'] === 'Lulus')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @elseif ($recap['status'] === 'Tidak Lulus')
                                            <i class="fas fa-times-circle mr-1"></i>
                                        @endif

                                        {{ $recap['status'] }}

                                    </span>

                                </td>

                                {{-- Aksi --}}
                                <td class="text-center align-middle">

                                    {{-- Detail --}}
                                    <a href="{{ route('score-recaps.participant', [
                                        'classroom' => $classroom,
                                        'participantClassroom' => $recap['participant'],
                                    ]) }}"
                                        class="btn btn-info btn-sm" title="Lihat Detail Nilai">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    {{-- Cetak --}}
                                    <a href="{{ route('score-recaps.printParticipant', [
                                        'classroom' => $classroom,
                                        'participantClassroom' => $recap['participant'],
                                    ]) }}"
                                        target="_blank" class="btn btn-secondary btn-sm" title="Cetak">

                                        <i class="fas fa-print"></i>

                                    </a>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="{{ $scoreTypes->count() + 6 }}" class="text-center text-muted py-5">

                                    <i class="fas fa-chart-bar fa-2x mb-3 d-block">
                                    </i>

                                    <strong>
                                        Belum ada data nilai.
                                    </strong>

                                    <br>

                                    <small>
                                        Data nilai peserta akan muncul
                                        setelah penilaian dibuat.
                                    </small>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
            KETERANGAN
        ====================================================== --}}

        <div class="card-footer">

            <div class="row">

                <div class="col-md-6">

                    <small class="text-muted">

                        <i class="fas fa-info-circle mr-1"></i>

                        Nilai akhir digunakan sebagai salah satu
                        indikator kelulusan peserta.

                    </small>

                </div>


                <div class="col-md-6 text-md-right">

                    <small class="text-muted">

                        Minimal Nilai:

                        <strong>

                            {{ number_format($classroom->minimum_score ?? 0, 2) }}

                        </strong>

                        &nbsp; | &nbsp;

                        Minimal Kehadiran:

                        <strong>

                            {{ number_format($classroom->minimum_attendance ?? 0, 2) }}%

                        </strong>

                    </small>

                </div>

            </div>

        </div>

    </div>
