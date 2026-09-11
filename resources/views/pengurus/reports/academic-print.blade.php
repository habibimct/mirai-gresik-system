<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Akademik - LPK Mirai Gresik</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            color: #111827;
            margin: 0;
            padding: 20px;
        }


        /* =========================================================
       PAGE
    ========================================================= */

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }


        /* =========================================================
       HEADER
    ========================================================= */

        .header-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header-table td {
            border: none;
            padding: 0;
        }

        .header-logo {
            width: 90px;
            text-align: left;
            vertical-align: middle;
        }

        .header-logo img {
            width: 70px;
            height: auto;
        }

        .header-title {
            text-align: center;
            vertical-align: middle;
        }

        .header-title .organization {
            font-size: 16px;
            font-weight: bold;
        }

        .header-title .title {
            font-size: 12px;
            font-weight: bold;
            margin-top: 2px;
        }

        .header-title .subtitle {
            font-size: 10px;
            margin-top: 3px;
        }

        .page-number {
            font-size: 9px;
            margin-top: 3px;
        }

        .header-space {
            width: 90px;
        }

        .header-line {
            border-bottom: 2px solid #111827;
            margin-bottom: 12px;
        }


        /* =========================================================
       FILTER
    ========================================================= */

        .filter-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .filter-table td {
            padding: 3px 0;
            border: none;
        }

        .filter-label {
            width: 100px;
            font-weight: bold;
        }


        /* =========================================================
       REPORT TABLE
    ========================================================= */

        .report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #9ca3af;
            padding: 5px 4px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .report-table th {
            background: #f3f4f6;
            text-align: center;
            font-weight: bold;
        }

        .report-table td {
            vertical-align: top;
        }

        .center {
            text-align: center;
        }


        /* =========================================================
       STATISTICS
    ========================================================= */

        .statistics {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
        }

        .statistics td {
            padding: 3px 0;
            border: none;
        }

        .stat-label {
            width: 180px;
            font-weight: bold;
        }


        /* =========================================================
       FOOTER
    ========================================================= */

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }

        .footer .date {
            margin-bottom: 45px;
        }


        /* =========================================================
       PRINT
    ========================================================= */

        @media print {

            body {
                padding: 0;
            }

            @page {
                size: A4 landscape;
                margin: 8mm;
            }

        }
    </style>

</head>

<body>

    @php

        /*
|--------------------------------------------------------------------------
| NOMOR LAPORAN
|--------------------------------------------------------------------------
*/

        $reportNumber =
            'LP/AKD/' .
            ($wave?->code ?? 'ALL') .
            '/' .
            ($program?->code ?? 'ALL') .
            '/' .
            now()->format('Ymd-His') .
            '/' .
            str_pad($academicData->count(), 4, '0', STR_PAD_LEFT);

        /*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
|
| Maksimal 20 peserta per halaman.
|
*/

        $pageSize = 20;

        $academicPages = collect($academicData)->chunk($pageSize);

        $totalPages = $academicPages->count();

        /*
|--------------------------------------------------------------------------
| JIKA DATA KOSONG
|--------------------------------------------------------------------------
*/

        if ($totalPages === 0) {
            $totalPages = 1;
            $academicPages = collect([collect()]);
        }
    @endphp

    {{-- =========================================================
HALAMAN
========================================================= --}}

    @foreach ($academicPages as $pageIndex => $pageData)
        @php
            $pageNumber = $pageIndex + 1;
        @endphp


        <div class="page">


            {{-- =====================================================
         HEADER
    ====================================================== --}}

            <table class="header-table">

                <tr>

                    {{-- LOGO --}}
                    <td class="header-logo">

                        <img src="{{ asset('images/mgs-logo3.png') }}" alt="MGS">

                    </td>


                    {{-- IDENTITAS LPK --}}
                    <td class="header-title">

                        <div class="organization">
                            LPK MIRAI GRESIK
                        </div>

                        <div class="title">
                            LAPORAN AKADEMIK
                        </div>

                        <div class="subtitle">
                            Laporan Kehadiran dan Nilai Peserta
                        </div>

                        <div class="subtitle">
                            Nomor: {{ $reportNumber }}
                        </div>

                        <div class="page-number">
                            Halaman {{ $pageNumber }}
                            dari {{ $totalPages }}
                        </div>

                    </td>


                    {{-- RUANG KOSONG AGAR TENGAH SEIMBANG --}}
                    <td class="header-space">
                    </td>

                </tr>

            </table>


            <div class="header-line"></div>


            {{-- =====================================================
         FILTER
         Hanya ditampilkan pada halaman pertama
    ====================================================== --}}

            @if ($pageNumber === 1)
                <table class="filter-table">

                    <tr>

                        <td class="filter-label">
                            Program
                        </td>

                        <td>
                            :
                            {{ $program?->name ?? 'Semua Program' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="filter-label">
                            Gelombang
                        </td>

                        <td>
                            :
                            {{ $wave?->name ?? 'Semua Gelombang' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="filter-label">
                            Kelas
                        </td>

                        <td>
                            :
                            {{ $classroom?->name ?? 'Semua Kelas' }}
                        </td>

                    </tr>

                </table>
            @endif


            {{-- =====================================================
         DATA AKADEMIK
    ====================================================== --}}

            <table class="report-table">

                <thead>

                    <tr>

                        <th style="width: 3%;">
                            No
                        </th>

                        <th style="width: 19%;">
                            Nama Peserta
                        </th>

                        <th style="width: 12%;">
                            Kelas
                        </th>

                        <th style="width: 6%;">
                            Hadir
                        </th>

                        <th style="width: 6%;">
                            Izin
                        </th>

                        <th style="width: 6%;">
                            Sakit
                        </th>

                        <th style="width: 6%;">
                            Alpa
                        </th>

                        <th style="width: 9%;">
                            Kehadiran
                        </th>

                        <th style="width: 8%;">
                            Nilai
                        </th>

                        <th style="width: 25%;">
                            Keterangan
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($pageData as $index => $data)
                        @php
                            $globalIndex = $pageIndex * $pageSize + $index + 1;
                        @endphp


                        <tr>

                            <td class="center">
                                {{ $globalIndex }}
                            </td>


                            <td>
                                {{ $data['name'] ?? '-' }}
                            </td>


                            <td>
                                {{ $data['classroom'] ?? '-' }}
                            </td>


                            <td class="center">
                                {{ $data['present'] ?? 0 }}
                            </td>


                            <td class="center">
                                {{ $data['permission'] ?? 0 }}
                            </td>


                            <td class="center">
                                {{ $data['sick'] ?? 0 }}
                            </td>


                            <td class="center">
                                {{ $data['absent'] ?? 0 }}
                            </td>


                            <td class="center">
                                {{ $data['attendance_percentage'] ?? 0 }}%
                            </td>


                            <td class="center">

                                {{ $data['average_score'] !== null ? $data['average_score'] : '-' }}

                            </td>


                            <td>
                                {{ $data['description'] ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10" class="center">

                                Tidak ada data akademik.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>


            {{-- =====================================================
         STATISTIK
         Hanya ditampilkan pada halaman terakhir
    ====================================================== --}}

            @if ($pageNumber === $totalPages)
                <table class="statistics">

                    <tr>

                        <td class="stat-label">
                            Total Peserta
                        </td>

                        <td>
                            : {{ $totalParticipants }}
                        </td>

                    </tr>


                    <tr>

                        <td class="stat-label">
                            Peserta Sudah Dinilai
                        </td>

                        <td>
                            : {{ $participantsWithScore }}
                        </td>

                    </tr>


                    <tr>

                        <td class="stat-label">
                            Belum Dinilai
                        </td>

                        <td>
                            : {{ $participantsWithoutScore }}
                        </td>

                    </tr>


                    <tr>

                        <td class="stat-label">
                            Rata-rata Kehadiran
                        </td>

                        <td>
                            : {{ $averageAttendance }}%
                        </td>

                    </tr>


                    <tr>

                        <td class="stat-label">
                            Rata-rata Nilai
                        </td>

                        <td>
                            : {{ $averageScore }}
                        </td>

                    </tr>

                </table>


                {{-- =================================================
             FOOTER
        ================================================== --}}

                <div class="footer">

                    <div class="date">

                        Gresik,
                        {{ now()->translatedFormat('d F Y') }}

                    </div>


                    <div>
                        Pengurus LPK Mirai Gresik
                    </div>

                </div>
            @endif
        </div>
    @endforeach

    <script>
        window.onload = function() {

            window.print();

        };
    </script>

</body>

</html>
