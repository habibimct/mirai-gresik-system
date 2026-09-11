<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Peserta - Mirai Gresik System
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 20px;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header h2 {
            margin: 4px 0 0;
            font-size: 14px;
        }

        .header p {
            margin: 4px 0 0;
            color: #444;
            font-size: 10px;
        }

        .header-line {
            border-bottom: 2px solid #000;
            margin-bottom: 12px;
        }

        .page-number {
            font-size: 9px;
            margin-top: 3px;
        }

        /* =========================================================
           FILTER
        ========================================================= */

        .filter-table {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
        }

        .filter-table td {
            padding: 2px 0;
        }

        .filter-label {
            width: 80px;
            font-weight: bold;
        }


        /* =========================================================
           STATISTIK
        ========================================================= */

        .statistics {
            width: 100%;
            margin-bottom: 15px;
        }

        .statistics-table {
            width: 100%;
            border-collapse: collapse;
        }

        .statistics-table td {
            width: 33.33%;
            padding: 0 4px;
        }

        .statistics-table td:first-child {
            padding-left: 0;
        }

        .statistics-table td:last-child {
            padding-right: 0;
        }

        .stat-box {
            border: 1px solid #999;
            padding: 7px;
            text-align: center;
        }

        .stat-title {
            font-size: 9px;
            color: #555;
        }

        .stat-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 3px;
        }



        /* =========================================================
           DATA PESERTA
        ========================================================= */

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .header-line {
            border-bottom: 2px solid #000;
            margin-bottom: 12px;
        }

        .page-number {
            font-size: 9px;
            margin-top: 3px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #777;
            padding: 5px;
            vertical-align: top;
        }

        table.data-table th {
            text-align: center;
            background: #eee;
            font-size: 9px;
        }

        table.data-table td {
            font-size: 9px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .nowrap {
            white-space: nowrap;
        }

        .wrap {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 9px;
        }


        /* =========================================================
           PRINT
        ========================================================= */

        @media print {

            body {
                margin: 10mm;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4 landscape;
                margin: 8mm;
            }

        }
    </style>

</head>

@php
    $participantGroups = $participants->chunk(15);
    $totalPages = $participantGroups->count();
@endphp

<body>
    @foreach ($participantGroups as $pageNumber => $pageParticipants)
        <div class="page">
            {{-- =========================================================
    HEADER
    ========================================================== --}}

            <table style="width: 100%; border: none; margin-bottom: 8px;">

                <tr>

                    {{-- LOGO --}}
                    <td
                        style="
                    width: 90px;
                    border: none;
                    text-align: left;
                    vertical-align: middle;
                ">

                        <img src="{{ asset('images/mgs-logo3.png') }}" style="width: 70px; height: auto;">

                    </td>


                    {{-- IDENTITAS LPK --}}
                    <td
                        style="
                    border: none;
                    text-align: center;
                    vertical-align: middle;
                ">

                        <div
                            style="
                        font-size: 16px;
                        font-weight: bold;
                    ">
                            LPK MIRAI GRESIK
                        </div>


                        <div
                            style="
                        font-size: 12px;
                        font-weight: bold;
                        margin-top: 2px;
                    ">
                            LAPORAN DATA PESERTA
                        </div>


                        <div
                            style="
                        font-size: 10px;
                        margin-top: 4px;
                    ">
                            Nomor: {{ $reportNumber }}
                        </div>


                        <div class="page-number">

                            Halaman
                            {{ $loop->iteration }}
                            dari
                            {{ $totalPages }}

                        </div>

                    </td>


                    {{-- RUANG KOSONG AGAR TENGAH SEIMBANG --}}
                    <td style="
                    width: 90px;
                    border: none;
                ">
                    </td>

                </tr>

            </table>


            <div class="header-line"></div>


            {{-- =========================================================
       FILTER
    ========================================================== --}}

            <table class="filter-table">

                @if ($program)
                    <tr>

                        <td class="filter-label">
                            Program
                        </td>

                        <td>
                            : {{ $program->name }}
                        </td>

                    </tr>
                @endif


                @if ($wave)
                    <tr>

                        <td class="filter-label">
                            Gelombang
                        </td>

                        <td>
                            : {{ $wave->name }}
                        </td>

                    </tr>
                @endif


                @if ($classroom)
                    <tr>

                        <td class="filter-label">
                            Kelas
                        </td>

                        <td>
                            : {{ $classroom->name }}
                        </td>

                    </tr>
                @endif

            </table>


            {{-- =========================================================
       STATISTIK
    ========================================================== --}}

            <div class="statistics">

                <table class="statistics-table">

                    <tr>

                        <td>

                            <div class="stat-box">

                                <div class="stat-title">
                                    TOTAL PESERTA
                                </div>

                                <div class="stat-value">
                                    {{ $totalParticipants }}
                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="stat-box">

                                <div class="stat-title">
                                    PESERTA AKTIF
                                </div>

                                <div class="stat-value">
                                    {{ $activeParticipants }}
                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="stat-box">

                                <div class="stat-title">
                                    PESERTA LULUS
                                </div>

                                <div class="stat-value">
                                    {{ $graduatedParticipants }}
                                </div>

                            </div>

                        </td>

                    </tr>

                </table>

            </div>


            {{-- =========================================================
       DATA PESERTA
    ========================================================== --}}

            <table class="data-table">

                <thead>

                    <tr>

                        {{-- NO --}}
                        <th style="width: 3%;">
                            No
                        </th>


                        {{-- NAMA --}}
                        <th style="width: 10%;">
                            Nama Peserta
                        </th>


                        {{-- NIK --}}
                        <th style="width: 9%;">
                            NIK
                        </th>


                        {{-- TEMPAT LAHIR --}}
                        <th style="width: 7%;">
                            Tempat Lahir
                        </th>


                        {{-- TANGGAL LAHIR --}}
                        <th style="width: 7%;">
                            Tanggal Lahir
                        </th>


                        {{-- JK --}}
                        <th style="width: 3%;">
                            JK
                        </th>


                        {{-- ALAMAT --}}
                        <th style="width: 14%;">
                            Alamat
                        </th>


                        {{-- PENDIDIKAN --}}
                        <th style="width: 7%;">
                            Pendidikan
                        </th>


                        {{-- PEKERJAAN --}}
                        <th style="width: 7%;">
                            Pekerjaan
                        </th>


                        {{-- EMAIL --}}
                        <th style="width: 11%;">
                            Email
                        </th>


                        {{-- PHONE --}}
                        <th style="width: 8%;">
                            No. HP
                        </th>


                        {{-- PROGRAM --}}
                        <th style="width: 7%;">
                            Program
                        </th>


                        {{-- GELOMBANG --}}
                        <th style="width: 7%;">
                            Gelombang
                        </th>


                        {{-- KELAS --}}
                        <th style="width: 7%;">
                            Kelas
                        </th>


                        {{-- STATUS --}}
                        <th style="width: 5%;">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($participants as $participant)
                        @php

                            $data = $participant->participantWaveProgram->participant;

                            $user = $data->user;

                            $waveProgram = $participant->classroom->waveProgram;

                        @endphp


                        <tr>

                            {{-- NO --}}
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>


                            {{-- NAMA --}}
                            <td class="wrap">
                                {{ $user->name ?? '-' }}
                            </td>


                            {{-- NIK --}}
                            <td class="nowrap">
                                {{ $data->nik ?? '-' }}
                            </td>


                            {{-- TEMPAT LAHIR --}}
                            <td class="wrap">
                                {{ $data->birth_place ?? '-' }}
                            </td>


                            {{-- TANGGAL LAHIR --}}
                            <td class="text-center nowrap">

                                @if ($data->birth_date)
                                    {{ \Carbon\Carbon::parse($data->birth_date)->format('d-m-Y') }}
                                @else
                                    -
                                @endif

                            </td>


                            {{-- JK --}}
                            <td class="text-center">
                                {{ $data->gender ?? '-' }}
                            </td>


                            {{-- ALAMAT --}}
                            <td class="wrap">
                                {{ $data->address ?? '-' }}
                            </td>


                            {{-- PENDIDIKAN --}}
                            <td class="wrap">
                                {{ $data->education ?? '-' }}
                            </td>


                            {{-- PEKERJAAN --}}
                            <td class="wrap">
                                {{ $data->job ?? '-' }}
                            </td>


                            {{-- EMAIL --}}
                            <td class="wrap">
                                {{ $user->email ?? '-' }}
                            </td>


                            {{-- PHONE --}}
                            <td class="nowrap">
                                {{ $user->phone ?? '-' }}
                            </td>


                            {{-- PROGRAM --}}
                            <td class="wrap">
                                {{ $waveProgram->program->name ?? '-' }}
                            </td>


                            {{-- GELOMBANG --}}
                            <td class="wrap">
                                {{ $waveProgram->wave->name ?? '-' }}
                            </td>


                            {{-- KELAS --}}
                            <td class="wrap">
                                {{ $participant->classroom->name ?? '-' }}
                            </td>


                            {{-- STATUS --}}
                            <td class="text-center">
                                {{ $data->status ?? '-' }}
                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="15" class="text-center">

                                Tidak ada data peserta.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>


            {{-- =========================================================
       FOOTER
    ========================================================== --}}

            <div class="footer">

                Dicetak pada:
                {{ now()->format('d-m-Y H:i') }}

            </div>
        </div>
    @endforeach

    {{-- =========================================================
       AUTO PRINT
    ========================================================== --}}

    <script>
        window.onload = function() {

            window.print();

        };
    </script>


</body>

</html>
