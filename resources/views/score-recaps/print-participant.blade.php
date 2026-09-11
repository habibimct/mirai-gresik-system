<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Hasil Belajar Peserta</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {

            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.4;

        }

        h2 {

            margin: 0;
            text-align: center;
            font-size: 20px;

        }

        h3 {

            margin: 18px 0 8px;
            font-size: 14px;

        }

        table {

            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;

        }

        table th,
        table td {

            border: 1px solid #000;
            padding: 5px;

        }

        table th {

            background: #f2f2f2;
            text-align: center;

        }

        .no-border,
        .no-border td {

            border: none !important;

        }

        .text-center {

            text-align: center;

        }

        .text-right {

            text-align: right;

        }

        .section {

            margin-top: 20px;

        }

        tr {

            page-break-inside: avoid;

        }
    </style>

</head>

<body>

    <h2 style="text-align:center;margin-bottom:5px;">
        HASIL BELAJAR PESERTA
    </h2>

    <p style="text-align:center;margin-bottom:20px;">
        {{ $classroom->name }}
    </p>

    <div class="section">

        <h3>

            Identitas Peserta

        </h3>

        <table class="no-border">

            <tr>

                <td width="180">

                    Nama

                </td>

                <td width="10">

                    :

                </td>

                <td>

                    {{ $participantClassroom->participantWaveProgram->participant->user->name }}

                </td>

            </tr>

            <tr>

                <td>

                    Kelas

                </td>

                <td>

                    :

                </td>

                <td>

                    {{ $classroom->name }}

                </td>

            </tr>

            <tr>

                <td>

                    Nilai Minimal

                </td>

                <td>

                    :

                </td>

                <td>

                    {{ $classroom->minimum_score }}

                </td>

            </tr>

            <tr>

                <td>

                    Minimal Kehadiran

                </td>

                <td>

                    :

                </td>

                <td>

                    {{ $classroom->minimum_attendance }}%

                </td>

            </tr>

        </table>

    </div>

    <div class="section">

        <h3>

            Ringkasan Akademik

        </h3>

        <table>

            <tr>

                <th>

                    Nilai Akhir

                </th>

                <th>

                    Kehadiran

                </th>

                <th>

                    Status

                </th>

            </tr>

            <tr>

                <td class="text-center">

                    {{ $finalScore }}

                </td>

                <td class="text-center">

                    {{ $attendancePercent }}%

                </td>

                <td class="text-center">

                    <strong>{{ $status }}</strong>

                </td>

            </tr>

        </table>

    </div>

    <h3>Rekap Kehadiran</h3>

    <table>

        <tr>

            <th>Hadir</th>

            <th>Izin</th>

            <th>Sakit</th>

            <th>Alpha</th>

        </tr>

        <tr>

            <td align="center">{{ $hadir }}</td>

            <td align="center">{{ $izin }}</td>

            <td align="center">{{ $sakit }}</td>

            <td align="center">{{ $alpha }}</td>

        </tr>

    </table>

    <h3>Nilai Per Minggu</h3>

    <table>

        <thead>

            <tr>

                <th>Minggu</th>

                @foreach ($scoreTypes as $type)
                    <th>

                        {{ $type->name }}

                    </th>
                @endforeach

                <th>Rata-rata</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($scoreTable as $row)
                <tr>

                    <td>

                        Minggu {{ $row['week'] }}

                    </td>

                    @foreach ($scoreTypes as $type)
                        <td align="center">

                            {{ $row['scores'][$type->id] ?? '-' }}

                        </td>
                    @endforeach

                    <td align="center">

                        {{ $row['average'] ?? '-' }}

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

    <div class="section">
        <h3>
            Grafik Per Komponen
        </h3>
        <div style="height:260px;">
            <canvas id="componentChart"></canvas>
        </div>
    </div>
    <div class="section">
        <h3>
            Grafik Rata-rata
        </h3>
        <div style="height:260px;">
            <canvas id="printChart"></canvas>
        </div>
    </div>

    <img id="componentChartImage" style="display:none;width:100%;">
    <img id="chartImage" style="display:none;width:100%;">

    <br><br>

    <div class="section">

        <table class="no-border">

            <tr>

                <td class="text-center">

                    Instruktur

                    <br><br><br><br><br>

                    (__________________)

                </td>

                <td class="text-center">

                    Pimpinan

                    <br><br><br><br><br>

                    (__________________)

                </td>

            </tr>

        </table>

    </div>

    {{-- ---------------------------------------------------- --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const componentDatasets = [];

        const chartData = @json($componentChart);

        chartData.forEach(function(item) {

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

            document.getElementById('componentChart'),

            {

                type: 'line',

                data: {

                    labels: @json($weeks),

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
        setTimeout(function() {

            document.getElementById('componentChartImage').src =
                componentChart.toBase64Image();

        }, 800);
    </script>

    <script>
        const weeks = @json(collect($weeklyAverage)->pluck('week'));

        const averages = @json(collect($weeklyAverage)->pluck('average'));

        const chart = new Chart(

            document.getElementById('printChart'),

            {

                type: 'line',

                data: {

                    labels: weeks,

                    datasets: [{

                        label: 'Rata-rata Nilai',

                        data: averages,

                        borderWidth: 3,

                        fill: false,

                        tension: 0.3

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

        setTimeout(function() {

            document.getElementById('chartImage').src =
                chart.toBase64Image();

        }, 800);
    </script>
</body>

</html>
