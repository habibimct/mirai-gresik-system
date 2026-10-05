<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Nilai Sikap</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 16mm 15mm 16mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #263445;
            line-height: 1.5;
        }

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

        .header-title .institution {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .header-title .document-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 2px;
        }

        .header-title .subtitle {
            font-size: 8px;
            margin-top: 1px;
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

        .brand-subtitle {
            text-align: center;
            font-size: 8px;
            color: #64748b;
            letter-spacing: 2px;
            margin-top: 2px;
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

        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #176b55;
            border-left: 4px solid #176b55;
            padding: 5px 8px;
            background: #edf6f2;
            margin: 15px 0 8px;
        }

        .profile {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .profile td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .profile .label {
            width: 115px;
            color: #64748b;
        }

        .profile .value {
            font-weight: bold;
            color: #263445;
        }

        .summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px;
            margin: 0 -5px 10px;
        }

        .summary td {
            width: 50%;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 10px;
            text-align: center;
        }

        .summary .caption {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .summary .number {
            font-size: 21px;
            color: #176b55;
            font-weight: bold;
            margin-top: 3px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data th {
            background: #176b55;
            color: #fff;
            font-weight: bold;
            padding: 7px 5px;
            border: 1px solid #176b55;
            text-align: center;
        }

        table.data td {
            border: 1px solid #d6dee5;
            padding: 6px 5px;
            text-align: center;
        }

        table.data tbody tr:nth-child(even) {
            background: #f5f8fa;
        }

        table.data td.left {
            text-align: left;
        }

        .final-row td {
            background: #edf6f2;
            font-weight: bold;
            color: #176b55;
        }

        .note {
            font-size: 8px;
            color: #64748b;
            margin-top: 6px;
        }

        .signature-page {
            page-break-before: always;
        }

        .signature-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #176b55;
            margin-bottom: 3px;
        }

        .signature-subtitle {
            text-align: center;
            font-size: 8px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 4px 12px;
        }

        .signature-space {
            height: 48px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .chart-heading {
            font-size: 9px;
            font-weight: bold;
            color: #176b55;
            border-bottom: 1px solid #b7d3c8;
            padding-bottom: 4px;
            margin: 5px 0 4px;
        }

        .chart-box {
            text-align: center;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .chart-box img {
            display: block;
            width: 100%;
            height: auto;
        }

        .chart-note {
            text-align: center;
            font-size: 7px;
            color: #64748b;
            margin-top: 2px;
        }

        .footer {
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
            margin-top: 10px;
            text-align: center;
            color: #94a3b8;
            font-size: 7px;
        }
    </style>
</head>

<body>

    {{-- HALAMAN 1: IDENTITAS DAN REKAP NILAI --}}

    <div class="header">
        <table class="header-table">
            <tr>

                {{-- LOGO --}}
                <td class="header-logo">

                    <img src="{{ $logoBase64 }}" style="width: 70px; height: auto;">

                </td>
                <td class="header-title">

                    <div class="brand">LPK MIRAI GRESIK</div>
                    <div class="document-title">REKAPITULASI NILAI SIKAP</div>
                    <div class="document-subtitle">
                        Laporan hasil penilaian sikap peserta pelatihan
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


    <div class="section-title">IDENTITAS PESERTA</div>

    <table class="profile">
        <tr>
            <td class="label">Nama Peserta</td>
            <td class="value">
                : {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Program</td>
            <td class="value">
                : {{ $classroom->waveProgram->program->name ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="value">
                : {{ $classroom->name ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="section-title">RINGKASAN HASIL PENILAIAN</div>

    <table class="summary">
        <tr>
            <td>
                <div class="caption">Jumlah Komponen</div>
                <div class="number">{{ $attitudeTypes->count() }}</div>
            </td>
            <td>
                <div class="caption">Nilai Akhir</div>
                <div class="number">
                    {{ $finalScore !== null ? number_format($finalScore, 2, ',', '.') : '-' }}
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">RATA-RATA NILAI PER KOMPONEN</div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 9%">No.</th>
                <th>Komponen Sikap</th>
                <th style="width: 28%">Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attitudeTypes as $index => $type)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="left">{{ $type->name }}</td>
                    <td>
                        {{ ($componentAverages[$type->id] ?? null) !== null
                            ? number_format($componentAverages[$type->id], 2, ',', '.')
                            : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada data penilaian.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($finalScore !== null)
            <tfoot>
                <tr class="final-row">
                    <td colspan="2">NILAI AKHIR</td>
                    <td>{{ number_format($finalScore, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                Direktur LPK Mirai Gresik
                <div class="signature-space"></div>
                <div class="signature-name">( .................................... )</div>
            </td>
            <td>
                Peserta Pelatihan
                <div class="signature-space"></div>
                <div class="signature-name">
                    (
                    {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '........................' }}
                    )
                </div>
            </td>
        </tr>
    </table>

    <div class="note">
        Nilai akhir dihitung dari rata-rata komponen sikap yang memiliki nilai.
        Skala penilaian: 0–100.
    </div>

    <div class="footer">
        LPK MIRAI GRESIK &bull; REKAPITULASI NILAI SIKAP
    </div>


    {{-- HALAMAN 2: DETAIL MINGGUAN --}}

    <div class="signature-page">

        <div class="header">
            <table class="header-table">
                <tr>

                    {{-- LOGO --}}
                    <td class="header-logo">

                        <img src="{{ $logoBase64 }}" style="width: 70px; height: auto;">

                    </td>
                    <td class="header-title">

                        <div class="brand">LPK MIRAI GRESIK</div>
                        <div class="document-title">DETAIL PENILAIAN SIKAP</div>
                        <div class="document-subtitle">
                            {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '-' }}
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

        <div class="section-title">HASIL PENILAIAN MINGGUAN</div>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 10%">Minggu</th>
                    <th style="width: 18%">Tanggal</th>
                    @foreach ($attitudeTypes as $type)
                        <th>{{ $type->name }}</th>
                    @endforeach
                    <th style="width: 15%">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attitudeTable as $row)
                    <tr>
                        <td>{{ $row['week'] }}</td>
                        <td>
                            {{ $row['date'] ? \Carbon\Carbon::parse($row['date'])->format('d/m/Y') : '-' }}
                        </td>
                        @foreach ($attitudeTypes as $type)
                            <td>
                                {{ ($row['scores'][$type->id] ?? null) !== null ? number_format($row['scores'][$type->id], 2, ',', '.') : '-' }}
                            </td>
                        @endforeach
                        <td>
                            {{ $row['average'] !== null ? number_format($row['average'], 2, ',', '.') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $attitudeTypes->count() + 3 }}">
                            Belum ada data penilaian mingguan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="note">
            Tanda (-) menunjukkan belum ada nilai pada komponen atau minggu tersebut.
        </div>

        <div class="footer">
            LPK MIRAI GRESIK &bull; DETAIL PENILAIAN SIKAP
        </div>
    </div>


    {{-- HALAMAN 3: TANDA TANGAN DAN GRAFIK --}}

    <div class="signature-page">

        <div class="header">
            <table class="header-table">
                <tr>

                    {{-- LOGO --}}
                    <td class="header-logo">

                        <img src="{{ $logoBase64 }}" style="width: 70px; height: auto;">

                    </td>
                    <td class="header-title">

                        <div class="brand">LPK MIRAI GRESIK</div>
                        <div class="document-title">GRAFIK NILAI</div>
                        <div class="document-subtitle">
                            {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '-' }}
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

        <div class="section-title">GRAFIK PERKEMBANGAN NILAI SIKAP</div>

        <div class="chart-heading">
            A. Perkembangan Nilai Setiap Komponen
        </div>

        <div class="chart-box">
            @if (!empty($componentChartUrl))
                <img src="{{ $componentChartUrl }}" alt="Grafik perkembangan setiap komponen">
            @else
                <div>Grafik komponen belum tersedia.</div>
            @endif
        </div>

        <div class="chart-heading">
            B. Perkembangan Rata-rata Nilai Sikap
        </div>

        <div class="chart-box">
            @if (!empty($averageChartUrl))
                <img src="{{ $averageChartUrl }}" alt="Grafik rata-rata nilai sikap">
            @else
                <div>Grafik rata-rata belum tersedia.</div>
            @endif
        </div>

        <div class="chart-note">
            Grafik menampilkan perkembangan nilai berdasarkan minggu penilaian.
        </div>

        <div class="footer">
            LPK MIRAI GRESIK &bull; DOKUMEN REKAPITULASI NILAI SIKAP
        </div>
    </div>

</body>

</html>
