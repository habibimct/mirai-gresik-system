@extends('adminlte::page')

@section('title', 'Detail Tagihan')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                Detail Tagihan
            </h1>

            <p class="text-muted mb-0">
                Informasi lengkap tagihan dan pembayaran peserta.
            </p>

        </div>

        <a href="{{ route('finance.participant-invoices.index') }}"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>

            Kembali

        </a>

    </div>

@stop


@section('content')


{{-- ========================================================= --}}
{{-- INFORMASI PESERTA --}}
{{-- ========================================================= --}}

<div class="row">


    {{-- Identitas --}}

    <div class="col-lg-8">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-user mr-1"></i>

                    Informasi Peserta

                </h3>

            </div>


            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="info-row">

                            <span class="info-label">
                                Peserta
                            </span>

                            <span class="info-value font-weight-bold">

                                {{ $participantInvoice->participantClassroom->participantWaveProgram->participant->user->name }}

                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Program
                            </span>

                            <span class="info-value">

                                {{ $participantInvoice->participantClassroom->participantWaveProgram->waveProgram->program->name }}

                            </span>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="info-row">

                            <span class="info-label">
                                Gelombang
                            </span>

                            <span class="info-value">

                                {{ $participantInvoice->participantClassroom->classroom->waveProgram->wave->name }}

                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Kelas
                            </span>

                            <span class="info-value">

                                {{ $participantInvoice->participantClassroom->classroom->name }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Status --}}

    <div class="col-lg-4">

        <div class="card card-outline card-info">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-info-circle mr-1"></i>

                    Status Tagihan

                </h3>

            </div>


            <div class="card-body text-center">


                {{-- Finalisasi --}}

                @if ($participantInvoice->is_final)

                    <span class="badge badge-success status-badge">

                        <i class="fas fa-check-circle mr-1"></i>

                        Final

                    </span>

                    <p class="text-muted small mt-2 mb-3">

                        Tagihan telah difinalisasi dan dapat dilihat peserta.

                    </p>

                @else

                    <span class="badge badge-warning status-badge">

                        <i class="fas fa-edit mr-1"></i>

                        Draft

                    </span>

                    <p class="text-muted small mt-2 mb-3">

                        Tagihan masih dapat dihitung ulang.

                    </p>

                @endif


                {{-- Status pembayaran --}}

                @if ($participantInvoice->status == 'Lunas')

                    <span class="badge badge-success">

                        <i class="fas fa-check-circle mr-1"></i>

                        Lunas

                    </span>

                @elseif ($participantInvoice->status == 'Sebagian')

                    <span class="badge badge-warning">

                        <i class="fas fa-clock mr-1"></i>

                        Sebagian Dibayar

                    </span>

                @else

                    <span class="badge badge-danger">

                        <i class="fas fa-times-circle mr-1"></i>

                        Belum Bayar

                    </span>

                @endif

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- RINGKASAN KEUANGAN --}}
{{-- ========================================================= --}}

<div class="row">


    {{-- Total --}}

    <div class="col-md-4">

        <div class="small-box bg-primary">

            <div class="inner">

                <h4>

                    Rp
                    {{ number_format($participantInvoice->total_amount, 0, ',', '.') }}

                </h4>

                <p>
                    Total Tagihan
                </p>

            </div>

            <div class="icon">

                <i class="fas fa-file-invoice-dollar"></i>

            </div>

        </div>

    </div>


    {{-- Dibayar --}}

    <div class="col-md-4">

        <div class="small-box bg-success">

            <div class="inner">

                <h4>

                    Rp
                    {{ number_format($participantInvoice->paid_amount, 0, ',', '.') }}

                </h4>

                <p>
                    Sudah Dibayar
                </p>

            </div>

            <div class="icon">

                <i class="fas fa-money-bill-wave"></i>

            </div>

        </div>

    </div>


    {{-- Sisa --}}

    <div class="col-md-4">

        <div class="small-box bg-info">

            <div class="inner">

                <h4>

                    Rp
                    {{ number_format(
                        $participantInvoice->total_amount - $participantInvoice->paid_amount,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

                <p>
                    Sisa Tagihan
                </p>

            </div>

            <div class="icon">

                <i class="fas fa-wallet"></i>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- RINCIAN BIAYA --}}
{{-- ========================================================= --}}

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-list-ul mr-1"></i>

            Rincian Biaya

        </h3>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60"
                            class="text-center">

                            No

                        </th>

                        <th>
                            Nama Biaya
                        </th>

                        <th width="140">
                            Asal
                        </th>

                        <th width="180"
                            class="text-right">

                            Nominal

                        </th>

                        <th width="100"
                            class="text-center">

                            Wajib

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($participantInvoice->items as $item)

                        <tr>

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>


                            <td>

                                @if ($item->source === 'Diskon')

                                    <span class="text-danger">

                                        <i class="fas fa-tag mr-1"></i>

                                        {{ $item->fee_name }}

                                    </span>

                                @else

                                    {{ $item->fee_name }}

                                @endif

                            </td>


                            <td>

                                @if ($item->source === 'Wave')

                                    <span class="badge badge-info">

                                        Gelombang

                                    </span>

                                @elseif ($item->source === 'Program')

                                    <span class="badge badge-primary">

                                        Program

                                    </span>

                                @elseif ($item->source === 'Diskon')

                                    <span class="badge badge-danger">

                                        Diskon

                                    </span>

                                @else

                                    <span class="badge badge-secondary">

                                        {{ $item->source }}

                                    </span>

                                @endif

                            </td>


                            <td class="text-right font-weight-bold">

                                @if ($item->amount < 0)

                                    <span class="text-danger">

                                        - Rp
                                        {{ number_format(
                                            abs($item->amount),
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                @else

                                    Rp
                                    {{ number_format(
                                        $item->amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                @endif

                            </td>


                            <td class="text-center">

                                @if ($item->is_required)

                                    <span class="badge badge-danger">

                                        Wajib

                                    </span>

                                @else

                                    <span class="text-muted">

                                        -

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center text-muted py-4">

                                <i class="fas fa-info-circle mr-1"></i>

                                Belum ada rincian biaya.

                            </td>

                        </tr>

                    @endforelse

                </tbody>


                <tfoot>

                    <tr class="bg-light">

                        <th colspan="3"
                            class="text-right">

                            Total Tagihan

                        </th>

                        <th class="text-right text-primary">

                            Rp
                            {{ number_format(
                                $participantInvoice->total_amount,
                                0,
                                ',',
                                '.'
                            ) }}

                        </th>

                        <th></th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>


    {{-- Action --}}

    <div class="card-footer d-flex justify-content-between align-items-center">

        <div>

            <span class="text-muted">

                <i class="fas fa-info-circle mr-1"></i>

                Sisa tagihan:

            </span>

            <strong class="text-primary">

                Rp
                {{ number_format(
                    $participantInvoice->total_amount -
                    $participantInvoice->paid_amount,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>


        @if (
            $participantInvoice->total_amount >
            $participantInvoice->paid_amount
        )

            <button class="btn btn-success"
                data-toggle="modal"
                data-target="#paymentModal">

                <i class="fas fa-money-bill-wave mr-1"></i>

                Tambah Pembayaran

            </button>

        @else

            <span class="badge badge-success p-2">

                <i class="fas fa-check-circle mr-1"></i>

                Tagihan Sudah Lunas

            </span>

        @endif

    </div>

</div>



{{-- ========================================================= --}}
{{-- RINGKASAN PEMBAYARAN --}}
{{-- ========================================================= --}}

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-calculator mr-1"></i>

            Ringkasan Pembayaran

        </h3>

    </div>


    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <div class="payment-summary">

                    <span>
                        Total Tagihan
                    </span>

                    <strong>
                        Rp
                        {{ number_format(
                            $participantInvoice->total_amount,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>

            </div>


            <div class="col-md-4">

                <div class="payment-summary">

                    <span>
                        Sudah Dibayar
                    </span>

                    <strong class="text-success">

                        Rp
                        {{ number_format(
                            $participantInvoice->paid_amount,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>

            </div>


            <div class="col-md-4">

                <div class="payment-summary">

                    <span>
                        Sisa Tagihan
                    </span>

                    <strong class="text-primary">

                        Rp
                        {{ number_format(
                            $participantInvoice->total_amount -
                            $participantInvoice->paid_amount,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL PEMBAYARAN --}}
{{-- ========================================================= --}}

<x-adminlte-modal
    id="paymentModal"
    title="Tambah Pembayaran"
    theme="success"
    icon="fas fa-money-bill-wave"
>

    <form
        action="{{ route('finance.payments.store') }}"
        method="POST"
    >

        @csrf


        <input
            type="hidden"
            name="participant_invoice_id"
            value="{{ $participantInvoice->id }}"
        >


        <x-adminlte-input
            name="payment_date"
            type="date"
            label="Tanggal Pembayaran"
            value="{{ now()->toDateString() }}"
        />


        <x-adminlte-select
            name="payment_type"
            label="Jenis Pembayaran"
        >

            <option value="Offline">
                Offline
            </option>

            <option value="Online">
                Online
            </option>

        </x-adminlte-select>


        <x-adminlte-select
            name="payment_channel"
            label="Channel Pembayaran"
        >

            <option value="Cash">
                Cash
            </option>

            <option value="Transfer">
                Transfer
            </option>

            <option value="QRIS">
                QRIS
            </option>

            <option value="Midtrans">
                Midtrans
            </option>

        </x-adminlte-select>


        <x-adminlte-input
            name="amount"
            type="number"
            label="Nominal Pembayaran"
            min="1"
            placeholder="Masukkan nominal pembayaran"
        />


        <x-adminlte-input
            name="reference_number"
            label="Nomor Referensi"
            placeholder="Opsional"
        />


        <x-adminlte-textarea
            name="note"
            label="Catatan"
            placeholder="Catatan pembayaran..."
        />


        <div class="alert alert-info">

            <i class="fas fa-info-circle mr-1"></i>

            Sisa tagihan saat ini:

            <strong>

                Rp
                {{ number_format(
                    $participantInvoice->total_amount -
                    $participantInvoice->paid_amount,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>


        <x-slot name="footerSlot">

            <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
            >

                <i class="fas fa-times mr-1"></i>

                Batal

            </button>


            <button
                type="submit"
                class="btn btn-success"
            >

                <i class="fas fa-save mr-1"></i>

                Simpan Pembayaran

            </button>

        </x-slot>

    </form>

</x-adminlte-modal>

@stop



@section('css')

<style>

    .info-row {

        display: flex;

        padding: 8px 0;

        border-bottom: 1px solid #f0f0f0;

    }


    .info-label {

        width: 110px;

        color: #6c757d;

        flex-shrink: 0;

    }


    .info-value {

        color: #343a40;

    }


    .status-badge {

        font-size: 15px;

        padding: 8px 14px;

    }


    .payment-summary {

        background: #f8f9fa;

        border: 1px solid #e9ecef;

        border-radius: 8px;

        padding: 16px;

        height: 100%;

        display: flex;

        flex-direction: column;

        justify-content: center;

    }


    .payment-summary span {

        color: #6c757d;

        font-size: 14px;

        margin-bottom: 5px;

    }


    .payment-summary strong {

        font-size: 20px;

    }


    .table td,
    .table th {

        vertical-align: middle;

    }


    @media (max-width: 767.98px) {

        .info-row {

            display: block;

        }


        .info-label {

            display: block;

            width: auto;

            font-size: 13px;

            margin-bottom: 3px;

        }


        .payment-summary {

            margin-bottom: 10px;

        }


        .card-footer {

            flex-direction: column;

            align-items: stretch !important;

            gap: 10px;

        }


        .card-footer .btn {

            width: 100%;

        }

    }

</style>

@stop