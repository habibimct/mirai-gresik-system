@extends('adminlte::page')

@section('title', 'Laporan Keuangan')

@section('content_header')

    <h1>Laporan Keuangan</h1>

@stop

@push('css')
    <style>
        .finance-card .small-box h3 {
            font-size: 1.5rem !important;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')

    <x-adminlte-card title="Filter" theme="primary" icon="fas fa-filter">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">

                    <x-adminlte-select name="program_id" id="program_id" label="Program">

                        <option value="">-- Semua Program --</option>

                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>

                                {{ $program->name }}

                            </option>
                        @endforeach

                    </x-adminlte-select>

                </div>

                <div class="col-md-3">

                    <x-adminlte-select name="wave_id" id="wave_id" label="Gelombang">

                        <option value="">-- Semua Gelombang --</option>

                        @foreach ($waves as $wave)
                            <option value="{{ $wave->id }}" @selected(request('wave_id') == $wave->id)>

                                {{ $wave->name }}

                            </option>
                        @endforeach

                    </x-adminlte-select>

                </div>

                <div class="col-md-3">

                    <x-adminlte-select name="classroom_id" id="classroom_id" label="Kelas">

                        <option value="">-- Semua Kelas --</option>

                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" @selected(request('classroom_id') == $classroom->id)>

                                {{ $classroom->name }}
                                @if ($classroom->waveProgram?->wave)
                                    — {{ $classroom->waveProgram->wave->name }}
                                @endif

                            </option>
                        @endforeach

                    </x-adminlte-select>

                </div>

                <div class="col-md-2 d-flex align-items-end">

                    <button type="submit" class="btn btn-primary btn-block mb-3">

                        <i class="fas fa-search"></i>

                        Tampilkan

                    </button>

                </div>

            </div>

        </form>
    </x-adminlte-card>


    <div class="finance-card">
        <div class="row">
            <div class="col-md-3">
                <x-adminlte-small-box title="{{ number_format($totalInvoice, 0, ',', '.') }}" text="Total Tagihan (Rp)"
                    icon="fas fa-file-invoice-dollar" theme="primary" />
            </div>
            <div class="col-md-3">
                <x-adminlte-small-box title="{{ number_format($totalPaid, 0, ',', '.') }}" text="Sudah Dibayar (Rp)"
                    icon="fas fa-wallet" theme="success" />
            </div>
            <div class="col-md-3">
                <x-adminlte-small-box title="{{ number_format($totalRemaining, 0, ',', '.') }}" text="Sisa Tagihan (Rp)"
                    icon="fas fa-money-bill-wave" theme="danger" />
            </div>
            <div class="col-md-3">
                <x-adminlte-small-box title="{{ $percentPaid }}%" text="Persentase Lunas" icon="fas fa-chart-pie"
                    theme="warning" />
            </div>
        </div>
    </div>

    <x-adminlte-card title="Daftar Tagihan Peserta" theme="primary">
        <div class="mb-3">

            <a href="{{ route('reports.finances.export-excel', request()->query()) }}" class="btn btn-success">

                <i class="fas fa-file-excel"></i>

                Excel

            </a>

            <a href="{{ route('reports.finances.export-pdf', request()->query()) }}" class="btn btn-danger">

                <i class="fas fa-file-pdf"></i>

                PDF

            </a>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Peserta</th>

                        <th>Program</th>

                        <th>Gelombang</th>

                        <th>Kelas</th>

                        <th>Tagihan</th>

                        <th>Dibayar</th>

                        <th>Sisa</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($invoices as $invoice)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $invoice->participantClassroom->participantWaveProgram->participant->user->name }}</td>

                            <td>{{ $invoice->participantClassroom->participantWaveProgram->waveProgram->program->name }}
                            </td>

                            <td>{{ $invoice->participantClassroom->classroom->waveProgram->wave->name }}</td>

                            <td>{{ $invoice->participantClassroom->classroom->name }}</td>

                            <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>

                            <td>Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>

                            <td>Rp {{ number_format($invoice->total_amount - $invoice->paid_amount, 0, ',', '.') }}</td>

                            <td>{{ $invoice->status }}</td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </x-adminlte-card>

    <x-adminlte-card title="Tagihan Tiap Peserta" theme="info">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Peserta</th>

                        <th>Total Tagihan</th>

                        <th>Sudah Dibayar</th>

                        <th>Sisa Tagihan</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($participantSummaries as $summary)
                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $summary['participant']->user->name }}
                            </td>

                            <td>
                                Rp {{ number_format($summary['total_tagihan'], 0, ',', '.') }}
                            </td>

                            <td class="text-success font-weight-bold">
                                Rp {{ number_format($summary['total_dibayar'], 0, ',', '.') }}
                            </td>

                            <td class="text-danger font-weight-bold">
                                Rp {{ number_format($summary['sisa_tagihan'], 0, ',', '.') }}
                            </td>

                            <td>

                                @if ($summary['status'] === 'Lunas')
                                    <span class="badge badge-success">
                                        Lunas
                                    </span>
                                @elseif ($summary['status'] === 'Sebagian')
                                    <span class="badge badge-warning">
                                        Sebagian
                                    </span>
                                @elseif ($summary['status'] === 'Belum Bayar')
                                    <span class="badge badge-danger">
                                        Belum Bayar
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Belum Ada Tagihan
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center text-muted">

                                Belum ada data tagihan peserta.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </x-adminlte-card>

    <x-adminlte-card title="Riwayat Pembayaran" theme="success">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>Peserta</th>

                        <th>Jenis</th>

                        <th>Nominal</th>

                        <th>Metode</th>

                        <th>Referensi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($payments as $payment)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>

                            <td>{{ $payment->invoice->participantClassroom->participantWaveProgram->participant->user->name }}
                            </td>

                            <td>{{ $payment->payment_type }}</td>

                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>

                            <td>{{ $payment->payment_channel }}</td>

                            <td>{{ $payment->reference_number }}</td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </x-adminlte-card>

@stop


