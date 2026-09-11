<table>

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <tr>
        <td colspan="8" align="center">
            <strong>LAPORAN KEUANGAN PESERTA</strong>
        </td>
    </tr>

    <tr>
        <td colspan="8" align="center">
            <strong>LPK MIRAI GRESIK</strong>
        </td>
    </tr>

    <tr></tr>


    {{-- =====================================================
        IDENTITAS LAPORAN
    ====================================================== --}}

    <tr>
        <td>
            <strong>Identitas</strong>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Program</td>
        <td colspan="2">
            : {{ $program?->name ?? 'Semua Program' }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Gelombang</td>
        <td colspan="2">
            : {{ $wave?->name ?? 'Semua Gelombang' }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Kelas</td>
        <td colspan="2">
            : {{ $classroom?->name ?? 'Semua Kelas' }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Tanggal Cetak</td>
        <td colspan="2">
            : {{ now()->format('d-m-Y H:i') }}
        </td>
    </tr>

    <tr></tr>


    {{-- =====================================================
        A. DAFTAR TAGIHAN PESERTA
    ====================================================== --}}

    <tr>
        <td colspan="8">
            <strong>A. DAFTAR TAGIHAN PESERTA</strong>
        </td>
    </tr>

    <tr>

        <th>No</th>
        <th>Nama Peserta</th>
        <th>Program</th>
        <th>Kelas</th>
        <th>Total Tagihan</th>
        <th>Total Dibayar</th>
        <th>Sisa Tagihan</th>
        <th>Status</th>

    </tr>

    @forelse ($invoices as $invoice)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $invoice->participantClassroom
                    ->participantWaveProgram
                    ->participant
                    ->user
                    ->name }}
            </td>

            <td>
                {{ optional(
                    $invoice->participantClassroom
                        ->participantWaveProgram
                        ->waveProgram
                        ->program
                )->name }}
            </td>

            <td>
                {{ optional(
                    $invoice->participantClassroom
                        ->classroom
                )->name }}
            </td>

            <td>
                {{ $invoice->total_amount }}
            </td>

            <td>
                {{ $invoice->paid_amount }}
            </td>

            <td>
                {{ $invoice->total_amount - $invoice->paid_amount }}
            </td>

            <td>
                {{ $invoice->status }}
            </td>

        </tr>

    @empty

        <tr>

            <td colspan="8">
                Tidak ada data tagihan.
            </td>

        </tr>

    @endforelse


    <tr></tr>


    {{-- =====================================================
        B. TAGIHAN TIAP PESERTA
    ====================================================== --}}

    <tr>

        <td colspan="8">
            <strong>B. TAGIHAN TIAP PESERTA</strong>
        </td>

    </tr>

    <tr>

        <th>No</th>
        <th>Nama Peserta</th>
        <th colspan="2">Total Tagihan</th>
        <th>Total Dibayar</th>
        <th>Sisa Tagihan</th>
        <th>Status</th>
        <th></th>

    </tr>

    @forelse ($participantSummaries as $summary)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $summary['participant']->user->name }}
            </td>

            <td colspan="2">
                {{ $summary['total_tagihan'] }}
            </td>

            <td>
                {{ $summary['total_dibayar'] }}
            </td>

            <td>
                {{ $summary['sisa_tagihan'] }}
            </td>

            <td>
                {{ $summary['status'] }}
            </td>

            <td></td>

        </tr>

    @empty

        <tr>

            <td colspan="8">
                Tidak ada data rekap peserta.
            </td>

        </tr>

    @endforelse


    <tr></tr>


    {{-- =====================================================
        C. RIWAYAT PEMBAYARAN
    ====================================================== --}}

    <tr>

        <td colspan="8">
            <strong>C. RIWAYAT PEMBAYARAN</strong>
        </td>

    </tr>

    <tr>

        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Peserta</th>
        <th>Jenis</th>
        <th>Metode</th>
        <th>Nominal</th>
        <th>Petugas</th>
        <th>Referensi</th>

    </tr>

    @forelse ($payments as $payment)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ \Carbon\Carbon::parse(
                    $payment->payment_date
                )->format('d-m-Y') }}
            </td>

            <td>
                {{ $payment->invoice
                    ->participantClassroom
                    ->participantWaveProgram
                    ->participant
                    ->user
                    ->name }}
            </td>

            <td>
                {{ $payment->payment_type }}
            </td>

            <td>
                {{ $payment->payment_channel }}
            </td>

            <td>
                {{ $payment->amount }}
            </td>

            <td>
                {{ optional($payment->receiver)->name }}
            </td>

            <td>
                {{ $payment->reference_number }}
            </td>

        </tr>

    @empty

        <tr>

            <td colspan="8">
                Tidak ada riwayat pembayaran.
            </td>

        </tr>

    @endforelse


    <tr></tr>


    {{-- =====================================================
        D. RINGKASAN KEUANGAN
    ====================================================== --}}

    <tr>

        <td>
            <strong>D. RINGKASAN KEUANGAN</strong>
        </td>

    </tr>

    <tr>

        <td></td>

        <td>
            Total Tagihan
        </td>

        <td>
            {{ $totalInvoice }}
        </td>

    </tr>

    <tr>

        <td></td>

        <td>
            Total Dibayar
        </td>

        <td>
            {{ $totalPaid }}
        </td>

    </tr>

    <tr>

        <td></td>

        <td>
            Sisa Tagihan
        </td>

        <td>
            {{ $totalRemaining }}
        </td>

    </tr>

</table>