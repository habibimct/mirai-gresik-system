@extends('adminlte::page')

@section('title', 'Detail Rekap Nilai Sikap')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">
                <i class="fas fa-user-check text-success mr-2"></i>
                Detail Rekap Nilai Sikap
            </h1>
            <small class="text-muted">
                Hasil penilaian sikap peserta selama mengikuti pelatihan
            </small>
        </div>

        <a href="{{ route('score-recaps.show', $classroom) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>
    </div>
@stop

@section('content')

    {{-- PROFIL PESERTA --}}
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user mr-2"></i>
                Profil Peserta
            </h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th width="150">Nama</th>
                            <td>:
                                {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $classroom->name }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th width="150">Program</th>
                            <td>:
                                {{ $classroom->waveProgram->program->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Gelombang</th>
                            <td>:
                                {{ $classroom->waveProgram->wave->name ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('score-recaps.print-participant-attitude', [
                'classroom' => $classroom,
                'participantClassroom' => $participantClassroom,
            ]) }}"
                class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf mr-1"></i>
                Cetak PDF
            </a>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>
                        {{ $finalScore !== null ? number_format($finalScore, 2) : '-' }}
                    </h3>
                    <p>Nilai Akhir Sikap</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $attitudeTypes->count() }}</h3>
                    <p>Komponen Penilaian</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $classroom->attitudeSessions->count() }}</h3>
                    <p>Total Sesi Penilaian</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- RATA-RATA PER KOMPONEN --}}
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar mr-2"></i>
                Rata-rata Setiap Komponen Sikap
            </h3>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Komponen Penilaian</th>
                            <th width="150" class="text-center">Nilai Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attitudeTypes as $type)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $type->name }}</td>
                                <td class="text-center">
                                    @if (!is_null($componentAverages[$type->id] ?? null))
                                        <strong class="text-success">
                                            {{ number_format($componentAverages[$type->id], 2) }}
                                        </strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada komponen penilaian sikap.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- DETAIL NILAI PER MINGGU --}}
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-clipboard-list mr-2"></i>
                Detail Nilai Per Minggu
            </h3>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="90" class="text-center">Minggu</th>
                            <th width="120" class="text-center">Tanggal</th>
                            <th>Komponen Penilaian</th>
                            <th width="120" class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $hasScoreData = false;
                        @endphp

                        @foreach ($classroom->attitudeSessions as $session)
                            @foreach ($session->sessionTypes as $sessionType)
                                @php
                                    $hasScoreData = true;
                                    $type = $sessionType->type;
                                    $score = $session->scores
                                        ->where('participant_classroom_id', $participantClassroom->id)
                                        ->where('attitude_type_id', $sessionType->attitude_type_id)
                                        ->first();
                                @endphp

                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-secondary">
                                            Minggu {{ $session->week }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $session->assessment_date ? \Carbon\Carbon::parse($session->assessment_date)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $type->name ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($score)
                                            <strong class="text-success">
                                                {{ number_format($score->score, 2) }}
                                            </strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                        @if (!$hasScoreData)
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Belum ada data penilaian sikap.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- GRAFIK PERKEMBANGAN --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line mr-2"></i>
                Grafik Perkembangan Nilai Sikap
            </h3>
        </div>

        <div class="card-body">
            <div style="height: 350px;">
                <canvas id="attitudeChart"></canvas>
            </div>
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle mr-2"></i>
                Ringkasan Hasil
            </h3>
        </div>

        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-6">
                    <h5 class="text-muted">Nilai Akhir Sikap</h5>
                    <h3 class="text-success">
                        {{ $finalScore !== null ? number_format($finalScore, 2) : '-' }}
                    </h3>
                </div>

                <div class="col-md-6">
                    <h5 class="text-muted">Komponen Dinilai</h5>
                    <h3>
                        {{ collect($componentAverages)->filter(fn($value) => $value !== null)->count() }}
                        / {{ $attitudeTypes->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const attitudeWeeks = @json($weeklyAverage->pluck('week')->map(fn($week) => 'Minggu ' . $week));

        const attitudeAverages = @json($weeklyAverage->pluck('average'));

        const attitudeChartElement = document.getElementById('attitudeChart');

        if (attitudeChartElement && attitudeWeeks.length > 0) {
            new Chart(attitudeChartElement, {
                type: 'line',
                data: {
                    labels: attitudeWeeks,
                    datasets: [{
                        label: 'Rata-rata Nilai Sikap',
                        data: attitudeAverages,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40,167,69,0.15)',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        spanGaps: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
