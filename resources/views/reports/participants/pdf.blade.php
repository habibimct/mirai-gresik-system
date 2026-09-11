<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <title>Laporan Data Peserta</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 12mm 15mm 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8.5px;
            color: #222;
            line-height: 1.35;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header .title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .header .organization {
            font-size: 13px;
            font-weight: bold;
            margin: 2px 0 4px 0;
        }

        .header .report-number {
            font-size: 9px;
            margin: 0;
        }

        /* =====================================================
           GARIS HEADER
        ===================================================== */

        .header-line {
            border-top: 2px solid #222;
            border-bottom: 1px solid #222;
            height: 3px;
            margin-bottom: 12px;
        }

        /* =====================================================
           INFORMASI LAPORAN
        ===================================================== */

        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .info td {
            border: none;
            padding: 2px 3px;
            vertical-align: top;
        }

        .info .label {
            width: 75px;
            font-weight: bold;
        }

        .info .separator {
            width: 10px;
            text-align: center;
        }

        /* =====================================================
           RINGKASAN
        ===================================================== */

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .summary td {
            border: 1px solid #999;
            padding: 5px 7px;
        }

        .summary-label {
            font-weight: bold;
            background: #f2f2f2;
            width: 14%;
        }

        /* =====================================================
           TABEL DATA
        ===================================================== */

            .data {
                width: 100%;
                border-collapse: collapse;
                /* table-layout: fixed; */
            }

            .data thead {
                display: table-header-group;
            }

            .data tr {
                page-break-inside: avoid;
            }

            .data th,
            .data td {
                border: 1px solid #555;
                padding: 4px;
                vertical-align: middle;
            }

            .data th {
                background: #e9ecef;
                text-align: center;
                font-weight: bold;
                font-size: 8px;
            }

            .data td {
                font-size: 7.8px;
            }

            .text-center {
                text-align: center;
            }

            .text-left {
                text-align: left;
            }

            .text-right {
                text-align: right;
            }

        /* =====================================================
           STATUS
        ===================================================== */

        .status {
            font-weight: bold;
        }

        /* =====================================================
           FOOTER / TANDA TANGAN
        ===================================================== */

        .signature-wrapper {
            page-break-inside: avoid;
            margin-top: 20px;
        }

        .signature {
            width: 220px;
            float: right;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature-space {
            height: 55px;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            margin-top: 15px;
            font-size: 7.5px;
            color: #666;
            border-top: 1px solid #aaa;
            padding-top: 4px;
        }

        .clearfix {
            clear: both;
        }
    </style>

</head>


<body>


    {{-- =====================================================
         HEADER LAPORAN
    ===================================================== --}}
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
                    LAPORAN DATA PESERTA
                </div>

                <div style="font-size: 10px; margin-top: 4px;">
                    Nomor :
                    LP/DATA/{{ now()->format('Ym') }}/{{ str_pad($participants->count(), 4, '0', STR_PAD_LEFT) }}
                </div>

            </td>


            {{-- RUANG KOSONG AGAR TENGAH SEIMBANG --}}
            <td style="width: 90px; border: none;">
            </td>

        </tr>

    </table>

    <div class="header-line"></div>


    {{-- =====================================================
         INFORMASI LAPORAN
    ===================================================== --}}

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


    {{-- =====================================================
         RINGKASAN
    ===================================================== --}}

    <table class="summary">

        <tr>

            <td class="summary-label">
                Total Peserta
            </td>

            <td>
                {{ $participants->count() }} peserta
            </td>

            <td class="summary-label">
                Status
            </td>

            <td>
                {{ request('status') ?: 'Semua Status' }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         TABEL PESERTA
    ===================================================== --}}

    <table class="data">

    <colgroup>

        <col style="width: 3%;">
        <col style="width: 15%;">
        <col style="width: 9%;">
        <col style="width: 4%;">
        <col style="width: 12%;">
        <col style="width: 8%;">
        <col style="width: 8%;">
        <col style="width: 9%;">
        <col style="width: 10%;">
        <col style="width: 9%;">
        <col style="width: 7%;">
        <col style="width: 6%;">

    </colgroup>

        <thead>

            <tr>

                <th class="col-no">
                    No
                </th>

                <th class="col-name">
                    Nama Peserta
                </th>

                <th class="col-nik">
                    NIK
                </th>

                <th class="col-gender">
                    JK
                </th>

                <th class="col-birth">
                    Tempat / Tanggal Lahir
                </th>

                <th class="col-education">
                    Pendidikan
                </th>

                <th class="col-job">
                    Pekerjaan
                </th>

                <th class="col-phone">
                    No. HP
                </th>

                <th class="col-program">
                    Program
                </th>

                <th class="col-wave">
                    Gelombang
                </th>

                <th class="col-class">
                    Kelas
                </th>

                <th class="col-status">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse ($participants as $p)
                @php

                    $participant = $p->participantWaveProgram->participant;

                    $user = $participant->user;

                @endphp


                <tr>

                    {{-- No --}}

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>


                    {{-- Nama --}}

                    <td class="text-left">
                        {{ $user->name }}
                    </td>


                    {{-- NIK --}}

                    <td class="text-center">
                        {{ $participant->nik ?: '-' }}
                    </td>


                    {{-- Jenis Kelamin --}}

                    <td class="text-center">
                        {{ $participant->gender_label ?: '-' }}
                    </td>


                    {{-- TTL --}}

                    <td class="text-left">

                        {{ $participant->birth_place ?: '-' }}

                        @if ($participant->birth_date)
                            ,
                            {{ \Carbon\Carbon::parse($participant->birth_date)->format('d-m-Y') }}
                        @endif

                    </td>


                    {{-- Pendidikan --}}

                    <td class="text-left">
                        {{ $participant->education ?: '-' }}
                    </td>


                    {{-- Pekerjaan --}}

                    <td class="text-left">
                        {{ $participant->job ?: '-' }}
                    </td>


                    {{-- Nomor HP --}}

                    <td class="text-center">
                        {{ $user->phone ?: '-' }}
                    </td>


                    {{-- Program --}}

                    <td class="text-left">

                        {{ optional($p->participantWaveProgram->waveProgram->program)->name ?? '-' }}

                    </td>


                    {{-- Gelombang --}}

                    <td class="text-left">

                        {{ optional($p->classroom->waveProgram->wave)->name ?? '-' }}

                    </td>


                    {{-- Kelas --}}

                    <td class="text-left">

                        {{ optional($p->classroom)->name ?? '-' }}

                    </td>


                    {{-- Status --}}

                    <td class="text-center status">

                        {{ $p->participantWaveProgram->status ?? '-' }}

                    </td>

                </tr>


            @empty

                <tr>

                    <td colspan="12" class="text-center">

                        Tidak ada data peserta.

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
         TANDA TANGAN
    ===================================================== --}}

    <div class="signature-wrapper">

        <div class="signature">

            Gresik,
            {{ now()->translatedFormat('d F Y') }}

            <br>

            Mengetahui,

            <div class="signature-space"></div>

            <strong>
                (........................................)
            </strong>

            <br>

            Pimpinan LPK Mirai Gresik

        </div>

        <div class="clearfix"></div>

    </div>


    {{-- =====================================================
         FOOTER
    ===================================================== --}}

    <div class="footer">

        Dokumen ini dicetak dari Sistem Informasi Terintegrasi
        LPK Mirai Gresik.

        <span style="float:right;">
            Dicetak {{ now()->format('d-m-Y H:i') }} WIB
        </span>

    </div>


</body>

</html>
