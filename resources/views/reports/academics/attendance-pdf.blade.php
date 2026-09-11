<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Kehadiran Peserta
    </title>

    <style>
        @page {
            size: A4 landscape;
            margin: 14mm 15mm 15mm 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* =========================================================
           HALAMAN
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

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header .title {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.3px;
        }

        .header .institution {
            margin: 3px 0 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .header .document-number {
            margin: 0;
            font-size: 8.5px;
        }

        .header .page-number {
            margin-top: 3px;
            font-size: 8px;
        }


        /* =========================================================
           GARIS PEMISAH HEADER
        ========================================================= */

        .header-line {
            width: 100%;
            border-bottom: 1.5px solid #000;
            margin-top: 7px;
            margin-bottom: 11px;
        }


        /* =========================================================
           INFORMASI LAPORAN
        ========================================================= */

        .info-wrapper {
            width: 100%;
            margin-bottom: 12px;
        }

        .info {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
        }

        .info-label {
            width: 80px;
            font-weight: bold;
        }

        .info-separator {
            width: 10px;
            text-align: center;
        }


        /* =========================================================
           TABEL KEHADIRAN
        ========================================================= */
        /*
        .data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;

            page-break-inside: auto;
        } */

        .data {
            width: 100%;
            border-collapse: collapse;
            /* page-break-inside: auto; */
        }

        .data thead {
            display: table-header-group;
        }

        .data tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .data th,
        .data td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .data th {
            background-color: #eeeeee;
            font-weight: bold;
            text-align: center;
        }

        .data td {
            text-align: center;
        }

        .data .text-left {
            text-align: left;
        }


        /* =========================================================
           LEBAR KOLOM
        ========================================================= */
        
        .col-date {
            width: 9%;
        }

        .col-subject {
            width: 9%;
        }

        .col-participant {
            width: auto;
        }

        .participant-name {
            font-size: 8px;
            line-height: 1.2;
            word-wrap: break-word;
        }



        /* =========================================================
           KETERANGAN
        ========================================================= */

        .closing-section {
            page-break-inside: avoid;
            margin-top: 10px;
        }

        .legend {
            margin-top: 3px;
        }

        .legend-title {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .legend-item {
            margin-right: 18px;
        }


        /* =========================================================
           TANDA TANGAN
        ========================================================= */

        .signature-wrapper {
            width: 100%;
            margin-top: 15px;

            page-break-inside: avoid;
        }

        .signature {
            width: 230px;
            margin-left: auto;
            text-align: center;

            page-break-inside: avoid;
        }

        .signature-date {
            margin-bottom: 2px;
        }

        .signature-space {
            height: 50px;
        }

        .signature-name {
            font-weight: bold;
        }

        .signature-position {
            margin-top: 3px;
        }


        /* =========================================================
           DATA KOSONG
        ========================================================= */

        .empty {
            padding: 15px !important;
            text-align: center;
        }


        /* =========================================================
           UTILITAS
        ========================================================= */

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>

</head>


<body>

    @php

        /*
        |--------------------------------------------------------------------------
        | Membagi peserta maksimal 8 orang per halaman
        |--------------------------------------------------------------------------
        */

        $participantGroups = $participants->chunk(8);

        $totalPages = $participantGroups->count();

    @endphp


    @foreach ($participantGroups as $participantGroup)
        <div class="page">

            {{-- =====================================================
                 HEADER
            ====================================================== --}}
            <table style="width: 100%; border: none; margin-bottom: 8px;">

                <tr>

                    {{-- LOGO --}}
                    <td style="width: 90px; border: none; text-align: left; vertical-align: middle;">

                        <img src="{{ public_path('images/mgs-logo3.png') }}" style="width: 70px; height: auto;">

                    </td>


                    {{-- IDENTITAS LPK --}}
                    <td style="border: none; text-align: center; vertical-align: middle;">

                        <div style="font-size: 16px; font-weight: bold;">
                            LPK MIRAI GRESIK
                        </div>

                        <div style="font-size: 12px; font-weight: bold; margin-top: 2px;">
                            LAPORAN KEHADIRAN PESERTA
                        </div>

                        <div style="font-size: 10px; margin-top: 4px;">
                            Nomor:

                            LP/KEHADIRAN/
                            {{ $classroom->waveProgram->wave->code }}/
                            {{ $classroom->waveProgram->program->code }}/
                            {{ now()->format('Ymd-His') }}/
                            {{ str_pad($participants->count(), 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="page-number">

                            Halaman
                            {{ $loop->iteration }}
                            dari
                            {{ $totalPages }}

                        </div>
                    </td>


                    {{-- RUANG KOSONG AGAR TENGAH SEIMBANG --}}
                    <td style="width: 90px; border: none;">
                    </td>

                </tr>

            </table>

            {{-- GARIS HEADER --}}

            <div class="header-line"></div>


            {{-- =====================================================
                 INFORMASI LAPORAN
            ====================================================== --}}

            <div class="info-wrapper">

                <table class="info">

                    <tr>

                        <td class="info-label">
                            Program
                        </td>

                        <td class="info-separator">
                            :
                        </td>

                        <td>
                             {{ $classroom?->waveProgram?->program?->name ?? 'Semua Program' }}
                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">
                            Gelombang
                        </td>

                        <td class="info-separator">
                            :
                        </td>

                        <td>
                            {{ $classroom?->waveProgram?->wave?->name ?? 'Semua Gelombang' }}
                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">
                            Kelas
                        </td>

                        <td class="info-separator">
                            :
                        </td>

                        <td>
                            {{ $classroom?->name ?? 'Semua Kelas' }}
                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">
                            Tanggal Cetak
                        </td>

                        <td class="info-separator">
                            :
                        </td>

                        <td>
                            {{ now()->format('d-m-Y H:i') }} WIB
                        </td>

                    </tr>

                </table>

            </div>


            {{-- =====================================================
                 TABEL KEHADIRAN
            ====================================================== --}}

            <table class="data">

                <colgroup>

                    {{-- Tanggal --}}
                    <col class="col-date">

                    {{-- Materi --}}
                    <col class="col-subject">

                    {{-- Peserta --}}
                    @foreach ($participantGroup as $participant)
                        <col class="col-participant">
                    @endforeach

                </colgroup>
                <thead>

                    <tr>

                        <th rowspan="2" class="col-date">
                            Tanggal
                        </th>

                        <th rowspan="2" class="col-subject">
                            Materi
                        </th>

                        <th colspan="{{ $participantGroup->count() }}">
                            Peserta
                        </th>

                    </tr>
                    <tr>
                        @foreach ($participantGroup as $participant)
                            <th class="col-participant">
                                <div class="participant-name">
                                    {{ $participant->participantWaveProgram->participant->user->name }}

                                </div>
                            </th>
                        @endforeach
                    </tr>

                </thead>

                <tbody>

                    @forelse ($attendanceSessions as $session)
                        <tr>

                            {{-- TANGGAL --}}

                            <td>

                                {{ \Carbon\Carbon::parse($session->attendance_date)->format('d/m/Y') }}

                            </td>


                            {{-- MATERI --}}

                            <td class="text-left">

                                {{ $session->schedule->subject ?? '-' }}

                            </td>


                            {{-- PESERTA --}}

                            @foreach ($participantGroup as $participant)
                                @php

                                    $attendance = $session->attendances->firstWhere(
                                        'participant_classroom_id',
                                        $participant->id,
                                    );

                                @endphp


                                <td>

                                    @if ($attendance)
                                        @switch($attendance->status)
                                            @case('Hadir')
                                                H
                                            @break

                                            @case('Izin')
                                                I
                                            @break

                                            @case('Sakit')
                                                S
                                            @break

                                            @case('Alpha')
                                                A
                                            @break

                                            @default
                                                -
                                        @endswitch
                                    @else
                                        -
                                    @endif

                                </td>
                            @endforeach

                        </tr>


                        @empty

                            <tr>

                                <td colspan="{{ $participantGroup->count() + 2 }}" class="empty">

                                    Belum ada data kehadiran.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>


                {{-- =====================================================
                 BAGIAN PENUTUP
            ====================================================== --}}

                <div class="closing-section">


                    {{-- =================================================
                     KETERANGAN
                ================================================== --}}

                    <div class="legend">

                        <div class="legend-title">
                            Keterangan:
                        </div>

                        <span class="legend-item">
                            <strong>H</strong> = Hadir
                        </span>

                        <span class="legend-item">
                            <strong>I</strong> = Izin
                        </span>

                        <span class="legend-item">
                            <strong>S</strong> = Sakit
                        </span>

                        <span class="legend-item">
                            <strong>A</strong> = Alpha
                        </span>

                    </div>


                    {{-- =================================================
                     TANDA TANGAN
                ================================================== --}}

                    <div class="signature-wrapper">

                        <div class="signature">

                            <div class="signature-date">

                                Gresik,
                                {{ now()->translatedFormat('d F Y') }}

                            </div>

                            <div>
                                Mengetahui,
                            </div>


                            <div class="signature-space"></div>


                            <div class="signature-name">

                                (....................................)

                            </div>

                            <div class="signature-position">

                                Pimpinan LPK Mirai Gresik

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        @endforeach

    </body>

    </html>
