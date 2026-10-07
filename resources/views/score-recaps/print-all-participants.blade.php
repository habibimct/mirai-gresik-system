<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Hasil Belajar Semua Peserta</title>

    <style>

        @page {
            size: A4 portrait;
            margin: 15mm 16mm 15mm 16mm;
        }

        @page chartLandscape {
            size: A4 landscape;
            margin: 12mm 15mm 12mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* =====================================================
           HALAMAN PESERTA
        ====================================================== */

        .participant-page {
            page-break-before: always;
            page-break-after: always;
            width: 100%;
        }

        .participant-page:first-child {
            page-break-before: auto;
        }

        /* =====================================================
           HEADER
        ====================================================== */

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

        /* =====================================================
           TYPOGRAPHY
        ====================================================== */

        h2 {
            margin: 0;
            text-align: center;
            font-size: 20px;
        }

        h3 {
            margin: 18px 0 8px;
            font-size: 14px;
        }

        /* =====================================================
           TABLE
        ====================================================== */

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

        /* =====================================================
           SIGNATURE
        ====================================================== */

        .signature-section {
            page-break-inside: avoid;
            margin-top: 20px;
        }

        /* =====================================================
           HALAMAN GRAFIK
        ====================================================== */

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
            aspect-ratio: 2.4 / 1;
        }

        .chart-container canvas {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
        }

        .chart-page canvas {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        @media print {

            .participant-page {
                page-break-before: always;
                page-break-after: always;
            }

            .participant-page:first-child {
                page-break-before: auto;
            }

            .chart-page {
                page-break-before: always;
                page-break-after: always;
            }
        }

    </style>

</head>

<body>

@foreach ($participantRecaps as $index => $recap)

    @php

        $participantClassroom = $recap['participantClassroom'];

        $finalScore = $recap['finalScore'];

        $attendancePercent = $recap['attendancePercent'];

        $hadir = $recap['hadir'];

        $izin = $recap['izin'];

        $sakit = $recap['sakit'];

        $alpha = $recap['alpha'];

        $status = $recap['status'];

        $weeklyAverage = $recap['weeklyAverage'];

        $scoreTypes = $recap['scoreTypes'];

        $scoreTable = $recap['scoreTable'];

        $componentChart = $recap['componentChart'];

        $weeks = $recap['weeks'];

        /*
        |--------------------------------------------------------------------------
        | ID unik untuk setiap peserta
        |--------------------------------------------------------------------------
        */

        $chartSuffix = $participantClassroom->id;

    @endphp


    {{-- =========================================================
         HALAMAN UTAMA PESERTA
    ========================================================== --}}

    <div class="participant-page">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="header">

            <table class="header-table">

                <tr>

                    <td class="header-logo">

                        <img
                            src="/images/mgs-logo3.png"
                            style="width: 70px; height: auto; display: block;"
                            alt="Logo LPK Mirai Gresik"
                        >

                    </td>

                    <td class="header-title">

                        <div class="brand">
                            LPK MIRAI GRESIK
                        </div>

                        <div class="document-title">
                            HASIL BELAJAR PESERTA
                        </div>

                        <div class="document-subtitle">
                            Laporan hasil penilaian peserta pelatihan
                        </div>

                    </td>

                    <td class="document-number">

                        <strong>No. Dokumen</strong>
                        <br>

                        HBP/{{ date('Y') }}/{{ str_pad($participantClassroom->id, 5, '0', STR_PAD_LEFT) }}

                        <br><br>

                        <strong>Dicetak</strong>
                        <br>

                        {{ now()->format('d-m-Y H:i') }} WIB

                    </td>

                </tr>

            </table>

            <div class="header-line"></div>

            <div class="header-line-thin"></div>

        </div>


        {{-- =====================================================
             A. IDENTITAS PESERTA
        ====================================================== --}}

        <div class="section">

            <h3>
                A. IDENTITAS PESERTA
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
                        Program / Gelombang
                    </td>

                    <td>
                        :
                    </td>

                    <td>

                        {{ $participantClassroom->participantWaveProgram->waveProgram->program->name ?? '-' }}

                        /

                        {{ $participantClassroom->participantWaveProgram->waveProgram->wave->name ?? '-' }}

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


        {{-- =====================================================
             B. RINGKASAN AKADEMIK
        ====================================================== --}}

        <div class="section">

            <h3>
                B. RINGKASAN AKADEMIK
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

                        <strong>
                            {{ $status }}
                        </strong>

                    </td>

                </tr>

            </table>

        </div>


        {{-- =====================================================
             C. REKAP KEHADIRAN
        ====================================================== --}}

        <h3>
            C. REKAP KEHADIRAN
        </h3>

        <table>

            <tr>

                <th>
                    Hadir
                </th>

                <th>
                    Izin
                </th>

                <th>
                    Sakit
                </th>

                <th>
                    Alpha
                </th>

            </tr>

            <tr>

                <td align="center">
                    {{ $hadir }}
                </td>

                <td align="center">
                    {{ $izin }}
                </td>

                <td align="center">
                    {{ $sakit }}
                </td>

                <td align="center">
                    {{ $alpha }}
                </td>

            </tr>

        </table>


        {{-- =====================================================
             D. NILAI PER MINGGU
        ====================================================== --}}

        <h3>
            D. NILAI PER MINGGU
        </h3>

        <table>

            <thead>

                <tr>

                    <th>
                        Minggu
                    </th>

                    @foreach ($scoreTypes as $type)

                        <th>
                            {{ $type->name }}
                        </th>

                    @endforeach

                    <th>
                        Rata-rata
                    </th>

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


        {{-- =====================================================
             SIGNATURE
        ====================================================== --}}

        <div class="section signature-section">

            <table class="no-border">

                <tr>

                    <td class="text-center">

                        Instruktur

                        <br><br><br><br><br>

                        (______________________________)

                    </td>

                    <td class="text-center">

                        Pimpinan

                        <br><br><br><br><br>

                        (______________________________)

                    </td>

                </tr>

            </table>

        </div>

    </div>


    {{-- =========================================================
         HALAMAN GRAFIK PESERTA
    ========================================================== --}}

    <div class="chart-page">

        <h3>
            E. GRAFIK HASIL BELAJAR
        </h3>


        {{-- =====================================================
             GRAFIK PER KOMPONEN
        ====================================================== --}}

        <div class="section">

            <h3>
                Grafik Per Komponen
            </h3>

            <div class="chart-container">

                <canvas id="componentChart{{ $chartSuffix }}"></canvas>

            </div>

        </div>


        {{-- =====================================================
             GRAFIK RATA-RATA
        ====================================================== --}}

        <div class="section">

            <h3>
                Grafik Rata-rata
            </h3>

            <div class="chart-container">

                <canvas id="printChart{{ $chartSuffix }}"></canvas>

            </div>

        </div>

    </div>


    {{-- =========================================================
         CHART SCRIPT PESERTA
    ========================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | ID peserta
            |--------------------------------------------------------------------------
            */

            const participantId = @json($chartSuffix);


            /*
            |--------------------------------------------------------------------------
            | Grafik per komponen
            |--------------------------------------------------------------------------
            */

            const componentDatasets = [];

            const chartData = @json($componentChart);

            chartData.forEach(function (item) {

                componentDatasets.push({

                    label: item.label,

                    data: item.data,

                    borderWidth: 2,

                    fill: false,

                    tension: 0.3,

                    spanGaps: true

                });

            });


            const componentCanvas =
                document.getElementById(
                    'componentChart' + participantId
                );


            if (componentCanvas) {

                new Chart(

                    componentCanvas,

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

            }


            /*
            |--------------------------------------------------------------------------
            | Grafik rata-rata
            |--------------------------------------------------------------------------
            */

            const weeks = @json(
                collect($weeklyAverage)
                    ->pluck('week')
            );

            const averages = @json(
                collect($weeklyAverage)
                    ->pluck('average')
            );


            const printCanvas =
                document.getElementById(
                    'printChart' + participantId
                );


            if (printCanvas) {

                new Chart(

                    printCanvas,

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

            }

        });

    </script>


@endforeach

</body>

</html>