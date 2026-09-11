<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Laporan Akademik</title>

    <style>

        @page {
            margin: 35px 40px 45px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h2 {
            margin: 0;
            font-size: 17px;
        }

        .header h3 {
            margin: 3px 0;
            font-size: 13px;
        }

        .header h4 {
            margin: 6px 0 0;
            font-size: 10px;
            font-weight: normal;
        }

        .header-line {
            border-bottom: 2px solid #000;
            margin-top: 8px;
        }

        /* =========================
           INFORMASI LAPORAN
        ========================= */

        .info {
            width: 100%;
            margin-bottom: 18px;
        }

        .info td {
            border: none;
            padding: 3px 4px;
            vertical-align: top;
        }

        .info .label {
            width: 110px;
            font-weight: bold;
        }

        .info .separator {
            width: 10px;
        }

        /* =========================
           JUDUL BAGIAN
        ========================= */

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 7px;
        }

        /* =========================
           TABEL DATA
        ========================= */

        .data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .data th,
        .data td {
            border: 1px solid #000;
            padding: 5px 4px;
            vertical-align: middle;
        }

        .data th {
            background-color: #eeeeee;
            text-align: center;
            font-weight: bold;
        }

        .data thead {
            display: table-header-group;
        }

        .data tr {
            page-break-inside: avoid;
        }

        .data td {
            text-align: center;
        }

        .data .left {
            text-align: left;
        }

        .data .right {
            text-align: right;
        }

        /* =========================
           RINGKASAN
        ========================= */

        .summary-wrapper {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .summary {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #000;
            padding: 5px;
        }

        .summary .label {
            font-weight: bold;
        }

        .summary .value {
            text-align: center;
        }

        /* =========================
           TANDA TANGAN
        ========================= */

        .signature-wrapper {
            margin-top: 25px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .signature {
            width: 250px;
            margin-left: auto;
            text-align: center;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .signature .space {
            height: 65px;
        }

        .signature .name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            position: fixed;
            bottom: -25px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

    </style>

</head>

<body>

    {{-- =========================
         HEADER
    ========================= --}}

    <div class="header">

        <h2>LAPORAN AKADEMIK PESERTA</h2>

        <h2>LPK MIRAI GRESIK</h2>

        <h4>
            Nomor :
            LP/PEN/{{ now()->format('Ym') }}/{{ str_pad($participants->count(), 4, '0', STR_PAD_LEFT) }}
        </h4>

        <div class="header-line"></div>

    </div>


    {{-- =========================
         INFORMASI LAPORAN
    ========================= --}}

    <table class="info">

        <tr>
            <td class="label">
                Program
            </td>

            <td class="separator">
                :
            </td>

            <td>
                {{ $program?->name ?? 'Semua Program' }}
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
                {{ $wave?->name ?? 'Semua Gelombang' }}
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


    {{-- =========================
         JUDUL TABEL
    ========================= --}}

    <div class="section-title">
        A. REKAPITULASI AKADEMIK PESERTA
    </div>


    {{-- =========================
         TABEL PESERTA
    ========================= --}}

    <table class="data">

        <thead>

            <tr>

                <th width="30">
                    No
                </th>

                <th width="150">
                    Nama Peserta
                </th>

                <th>
                    Program
                </th>

                <th>
                    Gelombang
                </th>

                <th>
                    Kelas
                </th>

                <th width="42">
                    Hadir
                </th>

                <th width="42">
                    Izin
                </th>

                <th width="42">
                    Sakit
                </th>

                <th width="42">
                    Alpha
                </th>

                <th width="55">
                    Nilai
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($participants as $participant)

                @php

                    $hadir = $participant->attendances
                        ->where('status', 'Hadir')
                        ->count();

                    $izin = $participant->attendances
                        ->where('status', 'Izin')
                        ->count();

                    $sakit = $participant->attendances
                        ->where('status', 'Sakit')
                        ->count();

                    $alpha = $participant->attendances
                        ->where('status', 'Alpha')
                        ->count();

                    $nilai = round(
                        $participant->scores->avg('score') ?? 0,
                        2
                    );

                @endphp


                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td class="left">

                        {{ $participant
                            ->participantWaveProgram
                            ->participant
                            ->user
                            ->name }}

                    </td>


                    <td>

                        {{ optional(
                            $participant
                                ->participantWaveProgram
                                ->waveProgram
                                ->program
                        )->name }}

                    </td>


                    <td>

                        {{ optional(
                            $participant
                                ->classroom
                                ->waveProgram
                                ->wave
                        )->name }}

                    </td>


                    <td>

                        {{ optional(
                            $participant->classroom
                        )->name }}

                    </td>


                    <td>
                        {{ $hadir }}
                    </td>


                    <td>
                        {{ $izin }}
                    </td>


                    <td>
                        {{ $sakit }}
                    </td>


                    <td>
                        {{ $alpha }}
                    </td>


                    <td>
                        {{ number_format($nilai, 2) }}
                    </td>

                </tr>


            @empty

                <tr>

                    <td colspan="10">
                        Tidak ada data peserta.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================
         RINGKASAN
    ========================= --}}

    <div class="summary-wrapper">

        <div class="section-title">
            B. RINGKASAN
        </div>

        <table class="summary">

            <tr>

                <td class="label">
                    Total Peserta
                </td>

                <td class="value">
                    {{ $participants->count() }}
                </td>

            </tr>

            <tr>

                <td class="label">
                    Total Hadir
                </td>

                <td class="value">

                    {{ $participants->sum(function ($participant) {
                        return $participant->attendances
                            ->where('status', 'Hadir')
                            ->count();
                    }) }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    Total Izin
                </td>

                <td class="value">

                    {{ $participants->sum(function ($participant) {
                        return $participant->attendances
                            ->where('status', 'Izin')
                            ->count();
                    }) }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    Total Sakit
                </td>

                <td class="value">

                    {{ $participants->sum(function ($participant) {
                        return $participant->attendances
                            ->where('status', 'Sakit')
                            ->count();
                    }) }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    Total Alpha
                </td>

                <td class="value">

                    {{ $participants->sum(function ($participant) {
                        return $participant->attendances
                            ->where('status', 'Alpha')
                            ->count();
                    }) }}

                </td>

            </tr>

        </table>

    </div>


    {{-- =========================
         TANDA TANGAN
    ========================= --}}

    <div class="signature-wrapper">

        <div class="signature">

            Gresik,
            {{ now()->translatedFormat('d F Y') }}

            <br>

            Mengetahui,

            <div class="space"></div>

            <div class="name">
                Pimpinan LPK Mirai Gresik
            </div>

        </div>

    </div>


    {{-- =========================
         FOOTER
    ========================= --}}

    <div class="footer">

        LPK Mirai Gresik &nbsp;|&nbsp;
        Laporan Akademik Peserta &nbsp;|&nbsp;
        Dicetak {{ now()->format('d-m-Y H:i') }} WIB

    </div>

</body>

</html>