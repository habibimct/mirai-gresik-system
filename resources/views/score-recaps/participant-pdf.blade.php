<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Hasil Belajar Peserta</title>

    <style>
        /* =========================================================
           HALAMAN
        ========================================================= */

        @page {
            size: A4 portrait;
            margin: 18mm 15mm 20mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }


        /* =========================================================
           HEADER DOKUMEN
        ========================================================= */

        .document-header {
            width: 100%;
            margin-bottom: 18px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
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

        .header-title .institution {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .header-title .document-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 2px;
        }

        .header-title .subtitle {
            font-size: 9px;
            margin-top: 2px;
        }

        .document-number {
            width: 15%;
            font-size: 8px;
            line-height: 1.5;
            text-align: right;
        }


        /* =========================================================
           GARIS PEMBATAS HEADER
        ========================================================= */

        .header-line {
            border-top: 2px solid #000;
            margin-top: 5px;
        }

        .header-line-thin {
            border-top: 1px solid #000;
            margin-top: 2px;
        }


        /* =========================================================
           JUDUL BAGIAN
        ========================================================= */

        .section {
            margin-top: 18px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 7px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #000;
        }


        /* =========================================================
           IDENTITAS PESERTA
        ========================================================= */

        .identity {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .identity td {
            border: none;
            padding: 3px 2px;
            vertical-align: top;
        }

        .identity .label {
            width: 145px;
            font-weight: bold;
        }

        .identity .separator {
            width: 12px;
            text-align: center;
        }


        /* =========================================================
           TABEL AKADEMIK
        ========================================================= */

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        table.data th {
            background-color: #eeeeee;
            font-weight: bold;
            text-align: center;
        }

        table.data td {
            background-color: #fff;
        }


        /* =========================================================
           RINGKASAN AKADEMIK
        ========================================================= */

        .summary {
            width: 100%;
            border-collapse: collapse;
        }

        .summary th,
        .summary td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .summary th {
            background-color: #eeeeee;
            font-weight: bold;
        }

        .summary .value {
            font-size: 13px;
            font-weight: bold;
        }


        /* =========================================================
           STATUS
        ========================================================= */

        .status {
            font-weight: bold;
            font-size: 11px;
        }


        /* =========================================================
           TABEL NILAI MINGGUAN
        ========================================================= */

        .score-table {
            width: 100%;
            border-collapse: collapse;
        }

        .score-table th,
        .score-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .score-table th {
            background-color: #eeeeee;
            font-weight: bold;
        }

        .score-table td:first-child {
            text-align: left;
            font-weight: bold;
        }

        .score-table .average {
            font-weight: bold;
        }


        /* =========================================================
           TANDA TANGAN
        ========================================================= */

        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 50%;
            border: none !important;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }

        .signature-space {
            height: 65px;
        }

        .signature-line {
            width: 190px;
            margin: 0 auto;
            border-top: 1px solid #000;
            padding-top: 4px;
            font-weight: bold;
        }


        /* =========================================================
           HALAMAN GRAFIK
        ========================================================= */

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
            width: 100%;
            max-width: 100%;
        }


        /* =========================================================
           UTILITAS
        ========================================================= */

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .no-border {
            border: none !important;
        }

        .no-border td {
            border: none !important;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>

</head>


<body>


    {{-- =========================================================
         HEADER DOKUMEN
    ========================================================== --}}

    <div class="document-header">

        <table class="header-table">

            <tr>

                {{-- LOGO --}}
                <td class="header-logo">

                    <img src="{{ public_path('images/mgs-logo3.png') }}" style="width: 70px; height: auto;">

                </td>
                <td class="header-title">

                    <div class="institution">
                        LPK MIRAI GRESIK
                    </div>

                    <div class="document-title">
                        HASIL BELAJAR PESERTA
                    </div>

                    <div class="subtitle">
                        Laporan Hasil Belajar dan Evaluasi Akademik
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



    {{-- =========================================================
         IDENTITAS PESERTA
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            I. IDENTITAS PESERTA
        </div>


        <table class="identity">

            <tr>

                <td class="label">
                    Nama Peserta
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $participantClassroom->participantWaveProgram->participant->user->name }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Program
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $classroom->waveProgram->program->name ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Gelombang
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $classroom->waveProgram->wave->name ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Kelas
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $classroom->name }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Nilai Minimal
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $classroom->minimum_score }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Minimal Kehadiran
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $classroom->minimum_attendance }}%
                </td>

            </tr>

        </table>

    </div>



    {{-- =========================================================
         RINGKASAN AKADEMIK
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            II. RINGKASAN AKADEMIK
        </div>


        <table class="summary">

            <thead>

                <tr>

                    <th>
                        Nilai Akhir
                    </th>

                    <th>
                        Kehadiran
                    </th>

                    <th>
                        Status Kelulusan
                    </th>

                </tr>

            </thead>


            <tbody>

                <tr>

                    <td class="value">
                        {{ $finalScore }}
                    </td>

                    <td class="value">
                        {{ $attendancePercent }}%
                    </td>

                    <td class="status">
                        {{ $status }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>



    {{-- =========================================================
         REKAP KEHADIRAN
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            III. REKAPITULASI KEHADIRAN
        </div>


        <table class="data">

            <thead>

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

            </thead>


            <tbody>

                <tr>

                    <td class="text-center">
                        {{ $hadir }}
                    </td>

                    <td class="text-center">
                        {{ $izin }}
                    </td>

                    <td class="text-center">
                        {{ $sakit }}
                    </td>

                    <td class="text-center">
                        {{ $alpha }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>



    {{-- =========================================================
         NILAI PER MINGGU
    ========================================================== --}}

    <div class="section">

        <div class="section-title">
            IV. REKAPITULASI NILAI PER MINGGU
        </div>


        <table class="score-table">

            <thead>

                <tr>

                    <th width="80">
                        Minggu
                    </th>

                    @foreach ($scoreTypes as $type)
                        <th>
                            {{ $type->name }}
                        </th>
                    @endforeach

                    <th width="80">
                        Rata-rata
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($scoreTable as $row)

                    <tr>

                        <td>
                            Minggu {{ $row['week'] }}
                        </td>


                        @foreach ($scoreTypes as $type)
                            <td>

                                {{ $row['scores'][$type->id] ?? '-' }}

                            </td>
                        @endforeach


                        <td class="average">

                            {{ $row['average'] ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="{{ $scoreTypes->count() + 2 }}" class="text-center">

                            Belum ada data penilaian.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



    {{-- =========================================================
         TANDA TANGAN
    ========================================================== --}}

    <div class="signature-section">

        <table class="signature-table">

            <tr>

                <td>

                    Instruktur

                    <div class="signature-space"></div>

                    <div class="signature-line">
                        Nama & Tanda Tangan
                    </div>

                </td>


                <td>

                    Pimpinan LPK Mirai Gresik

                    <div class="signature-space"></div>

                    <div class="signature-line">
                        Nama & Tanda Tangan
                    </div>

                </td>

            </tr>

        </table>

    </div>



    {{-- =========================================================
         HALAMAN GRAFIK
    ========================================================== --}}

    <div class="chart-page">


        <div class="section">

            <div class="section-title">
                V. GRAFIK HASIL BELAJAR
            </div>


            <div class="chart-section">

                <div class="chart-title">
                    A. Grafik Nilai Per Komponen
                </div>

                <img src="{{ $componentChartUrl }}" class="chart">

            </div>


            <div class="chart-section">

                <div class="chart-title">
                    B. Grafik Rata-rata Nilai
                </div>

                <img src="{{ $averageChartUrl }}" class="chart">

            </div>

        </div>

    </div>


</body>

</html>
