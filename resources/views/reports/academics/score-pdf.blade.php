<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Penilaian
    </title>

    <style>
        @page {
            margin: 25px 30px 35px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
            line-height: 1.35;
        }

        /* =========================================
           HALAMAN
        ========================================= */

        .page {
            page-break-after: auto;
        }

        .page+.page {
            page-break-before: always;
        }

        /* =========================================
           HEADER
        ========================================= */

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header h4 {
            margin: 5px 0 0;
            font-size: 9px;
            font-weight: normal;
        }

        .header-line {
            border-bottom: 2px solid #000;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        /* =========================================
           INFORMASI
        ========================================= */

        .info {
            width: 100%;
            margin-bottom: 8px;
        }

        .info td {
            border: none;
            padding: 2px 3px;
            vertical-align: top;
        }

        .info .label {
            width: 110px;
            font-weight: bold;
        }

        .info .separator {
            width: 10px;
            /* text-align: center; */
        }

        /* =========================================
           INFO HALAMAN
        ========================================= */

        .page-info {
            text-align: right;
            font-size: 8px;
            margin-bottom: 5px;
            color: #555;
        }

        /* =========================================
           TABEL
        ========================================= */

        .data {
            width: 100%;
            border-collapse: collapse;
            /* table-layout: fixed; */
        }

        .data th,
        .data td {
            border: 1px solid #000;
            padding: 5px 4px;
            vertical-align: middle;
        }

        .data th {
            background: #eeeeee;
            text-align: center;
            font-weight: bold;
        }

        .data td {
            text-align: center;
        }

        .data .text-left {
            text-align: left !important;
        }

        /* Header tabel harus tetap bersama */
        .data thead {
            display: table-header-group;
        }

        /* Baris penilaian tidak dipotong */
        .data tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* =========================================
           NAMA PESERTA
        ========================================= */

        .col-week {
            width: 6%;
        }

        .col-date {
            width: 9%;
        }

        .col-assessment {
            width: 14%;
        }

        .col-participant {
            width: auto;
        }

        .participant-name {
            font-size: 8px;
            line-height: 1.2;
            word-wrap: break-word;
        }

        /* =========================================
           BLOK TANDA TANGAN
        ========================================= */

        .signature-area {
            width: 100%;
            margin-top: 10px;

            /*
             * Jangan biarkan blok tanda tangan
             * terpotong menjadi dua halaman.
             */
            /* page-break-inside: avoid;
            break-inside: avoid; */
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-space {
            width: 70%;
        }

        .signature {
            width: 250px;
            text-align: center;
            margin-left: auto;

            /* page-break-inside: avoid;
            break-inside: avoid; */
        }

        .signature-date {
            margin-bottom: 3px;
        }

        .signature-title {
            margin-bottom: 3px;
        }

        .signature-space-height {
            height: 45px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* =========================================
           FOOTER
        ========================================= */

        .footer {
            position: fixed;
            bottom: -8mm;
            left: 0;
            right: 0;

            text-align: center;
            font-size: 7px;
            color: #777;
        }
    </style>

</head>


<body>

    @php
        /*
         * Nomor laporan dibuat SEKALI.
         * Tidak berubah meskipun dokumen memiliki
         * beberapa halaman.
         */

        $reportNumber =
            'LP/PEN/' .
            $classroom->waveProgram->wave->code .
            '/' .
            $classroom->waveProgram->program->code .
            '/' .
            now()->format('Ymd-His') .
            '/' .
            str_pad($participants->count(), 4, '0', STR_PAD_LEFT);

        $participantGroups = $participants->chunk(8);
        $totalPages = $participantGroups->count();

    @endphp


    @foreach ($participants->chunk(8) as $participantChunk)
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
                            LAPORAN PENILAIAN PESERTA
                        </div>

                        <div style="font-size: 10px; margin-top: 4px;">
                            Nomor:{{ $reportNumber }}
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

            <div class="header-line"></div>


            {{-- =========================================
             INFORMASI LAPORAN
            ========================================= --}}

            <table class="info">

                <tr>

                    <td class="label">
                        Program
                    </td>

                    <td class="separator">
                        :
                    </td>

                    <td>
                        {{ $classroom?->waveProgram?->program?->name ?? 'Semua Program' }}
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
                        {{ $classroom?->waveProgram?->wave?->name ?? 'Semua Gelombang' }}
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
                        {{ $classroom?->name ?? 'Semua Kelas' }}
                    </td>

                </tr>


                <tr>

                    <td class="label">
                        Tanggal Cetak
                    </td>

                    <td class="separator">
                        :
                    </td>

                    <td>
                        {{ now()->format('d-m-Y H:i') }} WIB
                    </td>

                </tr>

            </table>


            {{-- =========================================
             INFORMASI HALAMAN
        ========================================= --}}

            <div class="page-info">

                Peserta
                {{ $loop->index * 8 + 1 }}

                -

                {{ min(($loop->index + 1) * 8, $participants->count()) }}

                dari

                {{ $participants->count() }}

            </div>


            {{-- =========================================
             TABEL PENILAIAN
        ========================================= --}}

            <table class="data">

                <colgroup>

                    <col class="col-week">

                    <col class="col-date">

                    <col class="col-assessment">

                    @foreach ($participantChunk as $participant)
                        <col class="col-participant">
                    @endforeach

                </colgroup>

                <thead>

                    <tr>

                        <th rowspan="2" class="col-week">
                            Minggu
                        </th>

                        <th rowspan="2" class="col-date">
                            Tanggal
                        </th>

                        <th rowspan="2" class="col-assessment">
                            Penilaian
                        </th>

                        <th colspan="{{ $participantChunk->count() }}">
                            Peserta
                        </th>

                    </tr>

                    <tr>

                        @foreach ($participantChunk as $participant)
                            <th class="col-participant">
                                <div class="participant-name">
                                    {{ $participant->participantWaveProgram->participant->user->name }}
                                </div>
                            </th>
                        @endforeach

                    </tr>

                </thead>


                <tbody>

                    @forelse ($scoreSessions as $session)
                        @foreach ($session->sessionTypes as $sessionType)
                            <tr>

                                {{-- Minggu --}}

                                <td>
                                    {{ $session->week }}
                                </td>


                                {{-- Tanggal --}}

                                <td>

                                    {{ $session->assessment_date ? $session->assessment_date->format('d/m/Y') : '-' }}

                                </td>


                                {{-- Penilaian --}}

                                <td class="text-left">

                                    <strong>
                                        {{ $session->title }}
                                    </strong>

                                    <br>

                                    <small>
                                        {{ $sessionType->type->name ?? '-' }}
                                    </small>

                                </td>


                                {{-- Nilai peserta --}}

                                @foreach ($participantChunk as $participant)
                                    @php

                                        $score = $session->scores
                                            ->where('participant_classroom_id', $participant->id)
                                            ->where('score_type_id', $sessionType->score_type_id)
                                            ->first();

                                    @endphp


                                    <td>

                                        @if ($score)
                                            {{ number_format($score->score, 2) }}
                                        @else
                                            <span>
                                                -
                                            </span>
                                        @endif

                                    </td>
                                @endforeach

                            </tr>
                        @endforeach


                    @empty

                        <tr>

                            <td colspan="{{ $participantChunk->count() + 3 }}">

                                Belum ada data penilaian.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>


            {{-- =========================================
             TANDA TANGAN
            ========================================= --}}

            <div class="signature-area">

                <table class="signature-table">

                    <tr>

                        <td class="signature-space">
                            &nbsp;
                        </td>

                        <td>

                            <div class="signature">

                                <div class="signature-date">
                                    Gresik,
                                    {{ now()->translatedFormat('d F Y') }}
                                </div>

                                <div class="signature-title">
                                    Mengetahui,
                                </div>

                                <div class="signature-space-height">
                                    &nbsp;
                                </div>

                                <div class="signature-name">
                                    Pimpinan LPK Mirai Gresik
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>


        </div>
    @endforeach


    {{-- =========================================
        FOOTER
    ========================================= --}}

    <div class="footer">

        LPK Mirai Gresik
        &nbsp;|&nbsp;
        Laporan Penilaian Peserta
        &nbsp;|&nbsp;
        Dicetak {{ now()->format('d-m-Y H:i') }} WIB

    </div>


</body>

</html>
