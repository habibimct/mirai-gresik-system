<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <title>Laporan Keuangan</title>

    <style>
        @page {
            margin: 25px 30px 35px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            line-height: 1.35;
        }

        /* =====================================================
           HEADER DOKUMEN
        ====================================================== */

        .header {
            text-align: center;
            margin-bottom: 16px;
        }

        .header .title {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header .organization {
            margin: 2px 0 6px 0;
            font-size: 15px;
            font-weight: bold;
        }

        .header .document-number {
            margin: 0;
            font-size: 10px;
        }


        /* =====================================================
           GARIS PEMBATAS HEADER
        ====================================================== */

        .header-line {
            border-bottom: 2px solid #000;
            margin-top: 8px;
            margin-bottom: 14px;
        }


        /* =====================================================
           INFORMASI LAPORAN
        ====================================================== */

        .info {
            width: 100%;
            margin-bottom: 15px;
        }

        .info td {
            border: none;
            padding: 2px 3px;
            vertical-align: top;
        }

        .info-label {
            width: 110px;
            font-weight: bold;
        }

        .info-separator {
            width: 10px;
        }


        /* =====================================================
           JUDUL BAGIAN
        ====================================================== */

        .section-title {
            font-size: 11px;
            font-weight: bold;

            margin-top: 15px;
            margin-bottom: 7px;

            page-break-after: avoid;
            page-break-inside: avoid;
        }


        /* =====================================================
           TABEL
        ====================================================== */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table {
            page-break-inside: auto;
        }

        .table thead {
            display: table-header-group;
        }

        .table tfoot {
            display: table-footer-group;
        }

        .table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }

        .table th {
            background-color: #eeeeee;
            text-align: center;
            font-weight: bold;
        }


        /* =====================================================
           RINGKASAN KEUANGAN
        ====================================================== */

        .closing-block {
            margin-top: 15px;

            /*
             * Jangan biarkan blok ini terpecah.
             * Ringkasan + tanda tangan akan pindah bersama
             * jika halaman sebelumnya sudah tidak cukup.
             */
            page-break-inside: avoid;
        }

        .summary {
            width: 38%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #000;
            padding: 5px;
        }

        .summary-label {
            font-weight: bold;
        }

        .summary-total td {
            font-weight: bold;
        }


        /* =====================================================
           TANDA TANGAN
        ====================================================== */

        .signature-wrapper {
            width: 100%;
            margin-top: 22px;

            page-break-inside: avoid;
        }

        .signature {
            width: 250px;
            margin-left: auto;
            text-align: center;
        }

        .signature .date {
            margin-bottom: 4px;
        }

        .signature .acknowledge {
            margin-bottom: 2px;
        }

        .signature .space {
            height: 55px;
        }

        .signature .line {
            font-weight: bold;
        }

        .signature .position {
            margin-top: 4px;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .footer {
            position: fixed;

            left: 0;
            right: 0;
            bottom: -20px;

            text-align: center;

            font-size: 8px;
            color: #555;
        }


        /* =====================================================
           UTILITAS
        ====================================================== */

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>

</head>


<body>
    {{-- =====================================================
     HEADER DOKUMEN
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
                    LAPORAN KEUANGAN PESERTA
                </div>

                <div style="font-size: 10px; margin-top: 4px;">
                    Nomor :
                    LK/KEU/{{ now()->format('Ymd-His') }}/{{ str_pad($invoices->count(), 4, '0', STR_PAD_LEFT) }}
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
    ====================================================== --}}

    <table class="info">

        <tr>

            <td class="info-label">
                Program
            </td>

            <td class="info-separator">
                :
            </td>

            <td>
                {{ $program?->name ?? 'Semua Program' }}
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
                {{ $wave?->name ?? 'Semua Gelombang' }}
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
                {{ now()->format('d-m-Y H:i:s') }} WIB
            </td>

        </tr>

    </table>


    {{-- =====================================================
         A. DAFTAR TAGIHAN
    ====================================================== --}}

    <div class="section-title">

        A. DAFTAR TAGIHAN PESERTA

    </div>


    <table class="table">

        <thead>

            <tr>

                <th width="35">
                    No
                </th>

                <th>
                    Nama Peserta
                </th>

                <th>
                    Program
                </th>

                <th>
                    Kelas
                </th>

                <th width="85">
                    Total
                </th>

                <th width="85">
                    Dibayar
                </th>

                <th width="85">
                    Sisa
                </th>

                <th width="65">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($invoices as $invoice)
                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>


                    <td>

                        {{ $invoice->participantClassroom->participantWaveProgram->participant->user->name }}

                    </td>


                    <td>

                        {{ optional($invoice->participantClassroom->participantWaveProgram->waveProgram->program)->name }}

                    </td>


                    <td>

                        {{ optional($invoice->participantClassroom->classroom)->name }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($invoice->total_amount, 0, ',', '.') }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($invoice->paid_amount, 0, ',', '.') }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($invoice->total_amount - $invoice->paid_amount, 0, ',', '.') }}

                    </td>


                    <td class="text-center">

                        {{ $invoice->status }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">

                        Tidak terdapat data tagihan peserta.

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
     B. TAGIHAN TIAP PESERTA
    ====================================================== --}}

    <div class="section-title">

        B. TAGIHAN TIAP PESERTA

    </div>


    <table class="table">

        <thead>

            <tr>

                <th width="35">
                    No
                </th>

                <th>
                    Nama Peserta
                </th>

                <th width="105">
                    Total Tagihan
                </th>

                <th width="105">
                    Total Dibayar
                </th>

                <th width="105">
                    Sisa Tagihan
                </th>

                <th width="75">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($participantSummaries as $summary)
                <tr>

                    <td class="text-center">

                        {{ $loop->iteration }}

                    </td>


                    <td>

                        {{ $summary['participant']->user->name }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($summary['total_tagihan'], 0, ',', '.') }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($summary['total_dibayar'], 0, ',', '.') }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($summary['sisa_tagihan'], 0, ',', '.') }}

                    </td>


                    <td class="text-center">

                        {{ $summary['status'] }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Tidak terdapat data rekap tagihan peserta.

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
         C. RIWAYAT PEMBAYARAN
    ====================================================== --}}

    <div class="section-title">

        C. RIWAYAT PEMBAYARAN

    </div>


    <table class="table">

        <thead>

            <tr>

                <th width="35">
                    No
                </th>

                <th width="75">
                    Tanggal
                </th>

                <th>
                    Peserta
                </th>

                <th width="75">
                    Jenis
                </th>

                <th width="75">
                    Metode
                </th>

                <th width="95">
                    Nominal
                </th>

                <th>
                    Petugas
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($payments as $payment)
                <tr>

                    <td class="text-center">

                        {{ $loop->iteration }}

                    </td>


                    <td class="text-center">

                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}

                    </td>


                    <td>

                        {{ $payment->invoice->participantClassroom->participantWaveProgram->participant->user->name }}

                    </td>


                    <td class="text-center">

                        {{ $payment->payment_type }}

                    </td>


                    <td class="text-center">

                        {{ $payment->payment_channel }}

                    </td>


                    <td class="text-right nowrap">

                        {{ number_format($payment->amount, 0, ',', '.') }}

                    </td>


                    <td>

                        {{ optional($payment->receiver)->name }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="text-center">

                        Tidak terdapat data pembayaran.

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
         RINGKASAN + TANDA TANGAN
         SATU BLOK
    ====================================================== --}}

    <div class="closing-block">


        {{-- RINGKASAN --}}

        <table class="summary">
            <tr>
                <td class="summary-label">
                    Total Tagihan
                </td>
                <td class="text-right">
                    {{ number_format($totalInvoice, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="summary-label">
                    Total Dibayar
                </td>
                <td class="text-right">
                    {{ number_format($totalPaid, 0, ',', '.') }}
                </td>
            </tr>

            <tr class="summary-total">
                <td class="summary-label">
                    Sisa Tagihan
                </td>
                <td class="text-right">
                    {{ number_format($totalRemaining, 0, ',', '.') }}
                </td>
            </tr>
        </table>


        {{-- TANDA TANGAN --}}

        <div class="signature-wrapper">
            <div class="signature">
                <div class="date">
                    Gresik,
                    {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="acknowledge">

                    Mengetahui,

                </div>
                <div class="space"></div>
                <div class="line">

                    ______________________________

                </div>
                <div class="position">
                    Pimpinan LPK Mirai Gresik
                </div>
            </div>
        </div>
    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        LPK Mirai Gresik &nbsp;|&nbsp;
        Laporan Keuangan Peserta &nbsp;|&nbsp;
        Halaman <span class="page-number"></span>

    </div>


</body>

</html>
