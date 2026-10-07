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

        .header {
            border-bottom: 3px solid #176b55;
            padding-bottom: 10px;
            margin-bottom: 3px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
            table-layout: fixed;
        }

        .header-table td {
            border: none !important;
            padding: 0;
            vertical-align: middle;
        }

        .header-logo {
            width: 15%;
            text-align: left;
        }

        .header-title {
            text-align: center;
            padding-top: 5px !important;
        }

        .document-number {
            width: 15%;
            font-size: 8px;
            line-height: 1.5;
            text-align: right;
        }

        .brand {
            color: #176b55;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: center;
        }

        .document-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 3px;
            color: #1e293b;
        }

        .document-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 8px;
            margin-top: 1px;
        }

        .header-line {
            height: 3px;
            background: #176b55;
            margin-top: 5px;
        }

        .header-line-thin {
            height: 1px;
            background: #b7d3c8;
            margin-top: 2px;
        }

        h2,
        h3,
        p {
            margin: 0;
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



        @page chartLandscape {
            size: A4 landscape;
            margin: 12mm 15mm 12mm 15mm;
        }

        .chart-page {
            page: chartLandscape;
            page-break-before: always;
            page-break-after: always;
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .chart-page .section {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto 20px auto;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .chart-container {
            position: relative;
            width: 100%;
            aspect-ratio: 2 / 1;
        }

        .chart-container canvas {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <img src="/images/mgs-logo3.png" style="width: 70px; height: auto; display: block;"
                        alt="Logo LPK Mirai Gresik">
                </td>

                <td class="header-title">
                    <div class="brand">
                        LPK MIRAI GRESIK
                    </div>

                    <div class="document-title">
                        REKAPITULASI NILAI SIKAP
                    </div>

                    <div class="document-subtitle">
                        Laporan hasil penilaian sikap peserta pelatihan
                    </div>
                </td>

                <td class="document-number">
                    <strong>No. Dokumen</strong><br>
                    HBP/{{ date('Y') }}/{{ str_pad($participantClassroom->id, 5, '0', STR_PAD_LEFT) }}

                    <br><br>

                    <strong>Dicetak</strong><br>
                    {{ now()->format('d-m-Y H:i') }} WIB
                </td>
            </tr>
        </table>

        <div class="header-line"></div>
        <div class="header-line-thin"></div>
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
                {{ $participantClassroom->participantWaveProgram->waveProgram->program->name ?? '-' }}
                /
                {{ $participantClassroom->participantWaveProgram->waveProgram->wave->name ?? '-' }}
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

    {{-- <div class="footer">
        <div class="signature">
            <p>Gresik, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Direktur Utama</p>
            <p>LPK MIRAI GRESIK</p>
            <div class="signature-space"></div>
            <p><strong>__________________</strong></p>
        </div>
    </div> --}}

    {{-- HALAMAN GRAFIK NILAI SIKAP --}}
    <div class="chart-page">
        <div class="section">
            <div class="section-title">
                D. GRAFIK HASIL PENILAIAN SIKAP
            </div>

            <div class="section">
                <h3>Grafik Per Komponen</h3>
                <div class="chart-container">
                    <canvas id="componentChart"></canvas>
                </div>
            </div>

            <div class="section">
                <h3>Grafik Rata-rata</h3>
                <div class="chart-container">
                    <canvas id="printChart"></canvas>
                </div>
            </div>
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
