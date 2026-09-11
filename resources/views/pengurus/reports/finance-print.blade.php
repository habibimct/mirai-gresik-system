<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Keuangan Peserta
    </title>

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

        /* =====================================================
           PAGE
        ====================================================== */

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }


        /* =====================================================
           HEADER
        ====================================================== */

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


        /* =====================================================
           FILTER
        ====================================================== */

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


        /* =====================================================
           STATISTICS
        ====================================================== */

        .statistics {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .statistics td {
            border: 1px solid #9ca3af;
            padding: 5px;
            vertical-align: middle;
        }

        .statistics-label {
            font-size: 8px;
            color: #6b7280;
        }

        .statistics-value {
            font-size: 10px;
            font-weight: bold;
            margin-top: 2px;
        }


        /* =====================================================
           REPORT TABLE
        ====================================================== */

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


        /* =====================================================
           COLUMN WIDTH
        ====================================================== */

        .col-no {
            width: 4%;
        }

        .col-name {
            width: 18%;
        }

        .col-program {
            width: 13%;
        }

        .col-wave {
            width: 12%;
        }

        .col-classroom {
            width: 11%;
        }

        .col-money {
            width: 12%;
        }

        .col-status {
            width: 10%;
        }


        /* =====================================================
           ALIGNMENT
        ====================================================== */

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }


        /* =====================================================
           SUMMARY
        ====================================================== */

        .summary {
            margin-top: 15px;
            font-size: 9px;
        }

        .summary strong {
            font-weight: bold;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .footer {
            margin-top: 30px;
            width: 100%;
            font-size: 9px;
        }

        .footer-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            padding: 0;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            text-align: right;
        }


        /* =====================================================
           PRINT
        ====================================================== */

        @media print {

            body {
                padding: 0;
            }

            @page {
                size: A4 landscape;
                margin: 8mm;
            }

            .no-print {
                display: none !important;
            }

        }

    </style>

</head>


<body>


@php

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    $pageSize = 20;

    $financePages = collect($financeData)->chunk($pageSize);

    $totalPages = $financePages->count();

    /*
    |--------------------------------------------------------------------------
    | Jika tidak ada data
    |--------------------------------------------------------------------------
    */

    if ($totalPages === 0) {

        $totalPages = 1;

        $financePages = collect([
            collect()
        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | NOMOR LAPORAN
    |--------------------------------------------------------------------------
    */

    $reportNumber =
        'LP/KEU/' .
        ($wave?->code ?? 'ALL') .
        '/' .
        ($program?->code ?? 'ALL') .
        '/' .
        now()->format('Ymd-His') .
        '/' .
        str_pad(
            $financeData->count(),
            4,
            '0',
            STR_PAD_LEFT
        );

@endphp



{{-- =========================================================
     SETIAP HALAMAN
========================================================= --}}

@foreach ($financePages as $pageIndex => $pageFinanceData)

    @php

        $pageNumber = $pageIndex + 1;

        $isFirstPage = $pageNumber === 1;

        $isLastPage = $pageNumber === $totalPages;

    @endphp


    <div class="page">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <table class="header-table">

            <tr>

                <td class="header-logo">

                    <img
                        src="{{ asset('images/mgs-logo3.png') }}"
                        alt="MGS">

                </td>


                <td class="header-title">

                    <div class="organization">
                        LPK MIRAI GRESIK
                    </div>


                    <div class="title">
                        LAPORAN KEUANGAN PESERTA
                    </div>


                    <div class="subtitle">
                        Rekapitulasi Tagihan dan Pembayaran
                    </div>


                    <div class="subtitle">
                        Nomor: {{ $reportNumber }}
                    </div>


                    <div class="page-number">

                        Halaman
                        {{ $pageNumber }}
                        dari
                        {{ $totalPages }}

                    </div>

                </td>


                <td class="header-space"></td>

            </tr>

        </table>


        <div class="header-line"></div>



        {{-- =================================================
             FILTER
             HANYA HALAMAN PERTAMA
        ================================================== --}}

        @if ($isFirstPage)

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


            {{-- =================================================
                 STATISTIK
            ================================================== --}}

            <table class="statistics">

                <tr>

                    <td>

                        <div class="statistics-label">
                            Total Tagihan
                        </div>

                        <div class="statistics-value">
                            Rp
                            {{ number_format(
                                $totalAmount,
                                0,
                                ',',
                                '.'
                            ) }}
                        </div>

                    </td>


                    <td>

                        <div class="statistics-label">
                            Total Dibayar
                        </div>

                        <div class="statistics-value">
                            Rp
                            {{ number_format(
                                $totalPaid,
                                0,
                                ',',
                                '.'
                            ) }}
                        </div>

                    </td>


                    <td>

                        <div class="statistics-label">
                            Total Piutang
                        </div>

                        <div class="statistics-value">
                            Rp
                            {{ number_format(
                                $totalOutstanding,
                                0,
                                ',',
                                '.'
                            ) }}
                        </div>

                    </td>


                    <td>

                        <div class="statistics-label">
                            Total Peserta
                        </div>

                        <div class="statistics-value">
                            {{ $totalParticipants }}
                        </div>

                    </td>

                </tr>

            </table>

        @endif



        {{-- =================================================
             TABEL KEUANGAN
        ================================================== --}}

        <table class="report-table">

            <thead>

                <tr>

                    <th class="col-no">
                        No
                    </th>

                    <th class="col-name">
                        Nama Peserta
                    </th>

                    <th class="col-program">
                        Program
                    </th>

                    <th class="col-wave">
                        Gelombang
                    </th>

                    <th class="col-classroom">
                        Kelas
                    </th>

                    <th class="col-money">
                        Tagihan
                    </th>

                    <th class="col-money">
                        Dibayar
                    </th>

                    <th class="col-money">
                        Sisa
                    </th>

                    <th class="col-status">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($pageFinanceData as $index => $data)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Nomor urut global
                        |--------------------------------------------------------------------------
                        */

                        $globalIndex =
                            ($pageIndex * $pageSize)
                            + $index
                            + 1;

                    @endphp


                    <tr>

                        <td class="center">
                            {{ $globalIndex }}
                        </td>


                        <td>
                            {{ $data['name'] }}
                        </td>


                        <td>
                            {{ $data['program'] }}
                        </td>


                        <td>
                            {{ $data['wave'] }}
                        </td>


                        <td>
                            {{ $data['classroom'] }}
                        </td>


                        <td class="right">

                            Rp
                            {{ number_format(
                                $data['total_amount'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        <td class="right">

                            Rp
                            {{ number_format(
                                $data['paid_amount'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        <td class="right">

                            Rp
                            {{ number_format(
                                $data['remaining'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        <td class="center">

                            {{ $data['status'] }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="center"
                            style="padding: 15px;"
                        >
                            Tidak ada data keuangan final.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>



        {{-- =================================================
             RINGKASAN
             HANYA HALAMAN TERAKHIR
        ================================================== --}}

        @if ($isLastPage)

            <div class="summary">

                <strong>
                    Ringkasan Status:
                </strong>

                Lunas:
                {{ $paidParticipants }}

                &nbsp; | &nbsp;

                Sebagian:
                {{ $partialParticipants }}

                &nbsp; | &nbsp;

                Belum Bayar:
                {{ $unpaidParticipants }}

            </div>



            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <div class="footer">

                <table class="footer-table">

                    <tr>

                        <td class="footer-left">

                            Dicetak pada:
                            {{ now()->translatedFormat(
                                'd F Y H:i'
                            ) }}

                        </td>


                        <td class="footer-right">

                            LPK Mirai Gresik

                        </td>

                    </tr>

                </table>

            </div>

        @endif


    </div>

@endforeach



{{-- =========================================================
     TOMBOL CETAK
========================================================= --}}

<div class="no-print"
     style="text-align: center; margin-top: 30px;">

    <button
        onclick="window.print()"
        style="
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            background: #4f46e5;
            color: white;
            cursor: pointer;
        "
    >

        🖨️ Cetak Laporan

    </button>

</div>



<script>

    window.addEventListener('load', function () {

        window.print();

    });

</script>


</body>

</html>
