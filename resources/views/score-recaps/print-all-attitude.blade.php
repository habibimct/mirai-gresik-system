<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Nilai Sikap Semua Peserta</title>

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
           NILAI AKHIR
        ====================================================== */

        .final-score {
            border: 2px solid #176b55;
            padding: 8px;
            margin-top: 10px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
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

        .chart-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
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

            .no-print {
                display: none !important;
            }
        }

        @media screen {

            body {
                background: #e9ecef;
            }

            .no-print {
                margin: 15px;
            }

            .participant-page,
            .chart-page {
                background: #fff;
                margin-bottom: 30px;
                padding: 10px;
            }
        }

    </style>

</head>

<body>

<div class="no-print" style="text-align: right;">
    <button type="button"
            onclick="window.print()"
            style="padding: 7px 14px;">
        Cetak
    </button>
</div>

@foreach ($participantRecaps as $index => $recap)

    @php

        $participantClassroom =
            $recap['participantClassroom'];

        $componentAverages =
            $recap['componentAverages'];

        $attitudeTable =
            $recap['attitudeTable'];

        $finalScore =
            $recap['finalScore'];

        $attitudeChart =
            $recap['attitudeChart'];

        $averageChart =
            $recap['averageChart'];

        $participant =
            $participantClassroom
                ->participantWaveProgram
                ->participant
                ->user
                ->name
                ?? '-';

        $program =
            $participantClassroom
                ->participantWaveProgram
                ->waveProgram
                ->program
                ->name
                ?? '-';

        $wave =
            $participantClassroom
                ->participantWaveProgram
                ->waveProgram
                ->wave
                ->name
                ?? '-';

        $componentChartId =
            'componentChart_' . $index;

        $averageChartId =
            'averageChart_' . $index;

    @endphp

    {{-- =====================================================
         HALAMAN UTAMA PESERTA
    ====================================================== --}}

    <div class="participant-page">

        <div class="header">

            <table class="header-table">

                <tr>

                    <td class="header-logo">

                        <img
                            src="{{ asset('images/mgs-logo3.png') }}"
                            alt="Logo LPK Mirai Gresik"
                            style="width: 65px;">

                    </td>

                    <td class="header-title">

                        <div class="brand">
                            LPK MIRAI GRESIK
                        </div>

                        <div class="document-title">
                            REKAP NILAI SIKAP PESERTA
                        </div>

                        <div class="document-subtitle">
                            Laporan hasil penilaian sikap peserta pelatihan
                        </div>

                    </td>

                    <td class="document-number">

                        <strong>No. Dokumen</strong>

                        <br>

                        HNS/{{ date('Y') }}/{{ str_pad(
                            $participantClassroom->id,
                            5,
                            '0',
                            STR_PAD_LEFT
                        ) }}

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
             IDENTITAS PESERTA
        ====================================================== --}}

        <div class="section">

            <h3>
                A. IDENTITAS PESERTA
            </h3>

            <table class="no-border">

                <tr>

                    <td style="width: 25%;">
                        <strong>Nama Peserta</strong>
                    </td>

                    <td style="width: 3%;">
                        :
                    </td>

                    <td>
                        {{ $participant }}
                    </td>

                </tr>

                <tr>

                    <td>
                        <strong>Kelas</strong>
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $classroom->name ?? '-' }}
                    </td>

                </tr>

                <tr>

                    <td>
                        <strong>Program</strong>
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $program }}
                    </td>

                </tr>

                <tr>

                    <td>
                        <strong>Gelombang</strong>
                    </td>

                    <td>
                        :
                    </td>

                    <td>
                        {{ $wave }}
                    </td>

                </tr>

            </table>

        </div>


        {{-- =====================================================
             RATA-RATA KOMPONEN
        ====================================================== --}}

        <div class="section">

            <h3>
                B. RATA-RATA NILAI PER KOMPONEN
            </h3>

            <table>

                <thead>

                    <tr>

                        <th style="width: 10%;">
                            No.
                        </th>

                        <th>
                            Komponen Penilaian
                        </th>

                        <th style="width: 25%;">
                            Nilai Rata-rata
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($attitudeTypes as $type)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $type->name }}
                            </td>

                            <td class="text-center">

                                @if (
                                    !is_null(
                                        $componentAverages[$type->id] ?? null
                                    )
                                )

                                    {{ number_format(
                                        $componentAverages[$type->id],
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="text-center">

                                Belum ada data penilaian.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             NILAI AKHIR
        ====================================================== --}}

        <div class="final-score">

            NILAI AKHIR:

            {{ $finalScore !== null
                ? number_format(
                    $finalScore,
                    2,
                    ',',
                    '.'
                )
                : '-'
            }}

        </div>


        {{-- =====================================================
             DETAIL PER MINGGU
        ====================================================== --}}

        <div class="section">

            <h3>
                C. DETAIL PENILAIAN PER MINGGU
            </h3>

            <table>

                <thead>

                    <tr>

                        <th style="width: 10%;">
                            Minggu
                        </th>

                        <th style="width: 18%;">
                            Tanggal
                        </th>

                        @foreach ($attitudeTypes as $type)

                            <th>
                                {{ $type->name }}
                            </th>

                        @endforeach

                        <th style="width: 15%;">
                            Rata-rata
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($attitudeTable as $row)

                        <tr>

                            <td class="text-center">
                                {{ $row['week'] }}
                            </td>

                            <td class="text-center">

                                {{
                                    $row['date']
                                        ? \Carbon\Carbon::parse(
                                            $row['date']
                                        )->format('d/m/Y')
                                        : '-'
                                }}

                            </td>

                            @foreach ($attitudeTypes as $type)

                                <td class="text-center">

                                    @if (
                                        !is_null(
                                            $row['scores'][$type->id] ?? null
                                        )
                                    )

                                        {{ number_format(
                                            $row['scores'][$type->id],
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    @else

                                        -

                                    @endif

                                </td>

                            @endforeach

                            <td class="text-center">

                                {{
                                    $row['average'] !== null
                                        ? number_format(
                                            $row['average'],
                                            2,
                                            ',',
                                            '.'
                                        )
                                        : '-'
                                }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ $attitudeTypes->count() + 3 }}"
                                class="text-center">

                                Belum ada sesi penilaian.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         HALAMAN GRAFIK PESERTA
    ====================================================== --}}

    <div class="chart-page">

        <div class="section">

            <h3>
                D. GRAFIK HASIL PENILAIAN SIKAP
            </h3>

            <div class="chart-title">
                Grafik Per Komponen
            </div>

            <div class="chart-container">

                <canvas id="{{ $componentChartId }}"></canvas>

            </div>

        </div>


        <div class="section">

            <div class="chart-title">
                Grafik Rata-rata
            </div>

            <div class="chart-container">

                <canvas id="{{ $averageChartId }}"></canvas>

            </div>

        </div>

    </div>


@endforeach


{{-- =========================================================
     CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        @foreach ($participantRecaps as $index => $recap)

            const attitudeChartData{{ $index }} =
                @json($recap['attitudeChart']);

            const averageChartData{{ $index }} =
                @json($recap['averageChart']);


            /* =================================================
               GRAFIK PER KOMPONEN
            ================================================= */

            const componentCanvas{{ $index }} =
                document.getElementById(
                    'componentChart_{{ $index }}'
                );

            if (componentCanvas{{ $index }}) {

                const componentDatasets{{ $index }} =
                    attitudeChartData{{ $index }}.datasets.map(
                        function (item) {

                            return {

                                label: item.label,

                                data: item.data,

                                borderWidth: 2,

                                fill: false,

                                tension: 0.3,

                                spanGaps: true

                            };

                        }
                    );


                new Chart(
                    componentCanvas{{ $index }},
                    {

                        type: 'line',

                        data: {

                            labels:
                                attitudeChartData{{ $index }}
                                    .labels,

                            datasets:
                                componentDatasets{{ $index }}

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

                    }
                );

            }


            /* =================================================
               GRAFIK RATA-RATA
            ================================================= */

            const averageCanvas{{ $index }} =
                document.getElementById(
                    'averageChart_{{ $index }}'
                );

            if (averageCanvas{{ $index }}) {

                new Chart(
                    averageCanvas{{ $index }},
                    {

                        type: 'line',

                        data: {

                            labels:
                                averageChartData{{ $index }}
                                    .labels,

                            datasets: [

                                {

                                    label:
                                        'Rata-rata Nilai',

                                    data:
                                        averageChartData{{ $index }}
                                            .data,

                                    borderWidth: 3,

                                    fill: false,

                                    tension: 0.3,

                                    spanGaps: true

                                }

                            ]

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

                    }
                );

            }

        @endforeach

    }
);

</script>

</body>

</html>