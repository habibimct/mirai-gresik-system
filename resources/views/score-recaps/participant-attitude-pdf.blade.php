<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Sikap Peserta</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h2,
        h3,
        p {
            margin: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 16px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 10px;
        }

        .title {
            text-align: center;
            margin: 15px 0;
        }

        .title h3 {
            font-size: 13px;
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 6px;
            vertical-align: middle;
        }

        th {
            background: #e9ecef;
            text-align: center;
            font-weight: bold;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .section {
            margin-top: 20px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin: 15px 0 7px;
        }

        .final-score {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border: 1px solid #555;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }

        .signature {
            display: inline-block;
            width: 180px;
            text-align: center;
        }

        .signature-space {
            height: 55px;
        }



        .chart-page {
            page-break-before: always;
        }

        .chart-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .chart-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #000;
        }

        .chart {
            display: block;
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>LPK MIRAI GRESIK</h2>
        <p>REKAPITULASI PENILAIAN SIKAP PESERTA</p>
    </div>

    <div class="title">
        <h3>REKAP NILAI SIKAP</h3>
        <p>
            {{ $classroom->name ?? 'Kelas' }}
        </p>
    </div>

    <div class="section-title">A. IDENTITAS PESERTA</div>

    <table>
        <tr>
            <td class="label">Nama Peserta</td>
            <td>
                {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td>{{ $classroom->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Program / Gelombang</td>
            <td>
                {{ $participantClassroom->participantWaveProgram->waveProgram->name ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="section-title">B. RATA-RATA NILAI PER KOMPONEN</div>

    <table>
        <thead>
            <tr>
                <th width="8%">No.</th>
                <th>Komponen Penilaian</th>
                <th width="25%">Nilai Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attitudeTypes as $index => $type)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $type->name }}</td>
                    <td class="center">
                        {{ $componentAverages[$type->id] !== null ? number_format($componentAverages[$type->id], 2, ',', '.') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="center">
                        Belum ada data penilaian.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="final-score">
        NILAI AKHIR:
        {{ $finalScore !== null ? number_format($finalScore, 2, ',', '.') : '-' }}
    </div>

    <div class="section-title">C. DETAIL PENILAIAN PER MINGGU</div>

    <table>
        <thead>
            <tr>
                <th width="8%">Minggu</th>
                <th width="18%">Tanggal</th>
                @foreach ($attitudeTypes as $type)
                    <th>{{ $type->name }}</th>
                @endforeach
                <th width="15%">Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attitudeTable as $row)
                <tr>
                    <td class="center">{{ $row['week'] }}</td>
                    <td class="center">
                        {{ $row['date'] ? \Carbon\Carbon::parse($row['date'])->format('d/m/Y') : '-' }}
                    </td>

                    @foreach ($attitudeTypes as $type)
                        <td class="center">
                            {{ $row['scores'][$type->id] !== null ? number_format($row['scores'][$type->id], 2, ',', '.') : '-' }}
                        </td>
                    @endforeach

                    <td class="center">
                        {{ $row['average'] !== null ? number_format($row['average'], 2, ',', '.') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $attitudeTypes->count() + 3 }}" class="center">
                        Belum ada sesi penilaian.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- HALAMAN GRAFIK NILAI SIKAP --}}
    <div class="chart-page">
        <div class="section">
            <div class="section-title">
                D. GRAFIK HASIL PENILAIAN SIKAP
            </div>

            <div class="section">
                <h3>Grafik Per Komponen</h3>
                <div style="height:260px;">
                    <canvas id="componentChart"></canvas>
                </div>
            </div>

            <div class="section">
                <h3>Grafik Rata-rata</h3>
                <div style="height:260px;">
                    <canvas id="printChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Gresik, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Direktur Utama</p>
            <div class="signature-space"></div>
            <p><strong>LPK MIRAI GRESIK</strong></p>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const attitudeChartData = @json($attitudeChart);

        const componentDatasets = [];

        attitudeChartData.datasets.forEach(function(item) {
            componentDatasets.push({
                label: item.label,
                data: item.data,
                borderWidth: 2,
                fill: false,
                tension: 0.3,
                spanGaps: true
            });
        });

        const componentChart = new Chart(
            document.getElementById('componentChart'), {
                type: 'line',
                data: {
                    labels: attitudeChartData.labels,
                    datasets: componentDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 0,
                            max: 100
                        }
                    }
                }
            }
        );

        const averageChartData = @json($averageChart);

        const averageChart = new Chart(
            document.getElementById('printChart'), {
                type: 'line',
                data: {
                    labels: averageChartData.labels,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: averageChartData.data,
                        borderWidth: 3,
                        fill: false,
                        tension: 0.3,
                        spanGaps: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 0,
                            max: 100
                        }
                    }
                }
            }
        );
    </script>


</body>

</html>
