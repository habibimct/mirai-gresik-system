{{-- =========================================================
     INFORMASI PESERTA & INVOICE
     ========================================================= --}}

<div class="row">

    {{-- INFORMASI PESERTA --}}
    <div class="col-lg-7">

        <div class="card card-outline card-primary h-100">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>
                    Informasi Peserta
                </h3>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <small class="text-muted d-block">
                            Nama Peserta
                        </small>

                        <strong class="d-block mt-1">

                            {{ $participantInvoice->participantClassroom->participantWaveProgram->participant->user->name }}

                        </strong>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted d-block">
                            Program
                        </small>

                        <strong class="d-block mt-1">

                            {{ $participantInvoice->participantClassroom->participantWaveProgram->waveProgram->program->name }}

                        </strong>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted d-block">
                            Gelombang
                        </small>

                        <strong class="d-block mt-1">

                            {{ $participantInvoice->participantClassroom->classroom->waveProgram->wave->name }}

                        </strong>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted d-block">
                            Kelas
                        </small>

                        <strong class="d-block mt-1">

                            {{ $participantInvoice->participantClassroom->classroom->name }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- STATUS INVOICE --}}
    <div class="col-lg-5">

        <div class="card card-outline card-info h-100">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-file-invoice-dollar mr-2"></i>

                    Status Tagihan

                </h3>

            </div>


            <div class="card-body">

                <div class="row text-center">

                    <div class="col-6">

                        <small class="text-muted d-block">
                            Status Invoice
                        </small>

                        @if ($participantInvoice->is_final)
                            <span class="badge badge-success mt-2 px-3 py-2">

                                <i class="fas fa-lock mr-1"></i>
                                Final

                            </span>
                        @else
                            <span class="badge badge-warning mt-2 px-3 py-2">

                                <i class="fas fa-edit mr-1"></i>
                                Draft

                            </span>
                        @endif

                    </div>


                    <div class="col-6">

                        <small class="text-muted d-block">
                            Status Pembayaran
                        </small>


                        @if ($participantInvoice->status == 'Lunas')
                            <span class="badge badge-success mt-2 px-3 py-2">

                                <i class="fas fa-check-circle mr-1"></i>
                                Lunas

                            </span>
                        @elseif ($participantInvoice->status == 'Sebagian')
                            <span class="badge badge-warning mt-2 px-3 py-2">

                                <i class="fas fa-clock mr-1"></i>
                                Sebagian

                            </span>
                        @else
                            <span class="badge badge-danger mt-2 px-3 py-2">

                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Belum Bayar

                            </span>
                        @endif

                    </div>

                </div>


                @if ($participantInvoice->is_final)
                    <div class="alert alert-success mt-4 mb-0">

                        <i class="fas fa-check-circle mr-1"></i>

                        Tagihan ini sudah difinalisasi dan dapat dilihat oleh peserta.

                    </div>
                @else
                    <div class="alert alert-warning mt-4 mb-0">

                        <i class="fas fa-info-circle mr-1"></i>

                        Tagihan masih dalam status draft dan dapat dihitung ulang.

                    </div>
                @endif

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     RINCIAN BIAYA
     ========================================================= --}}

<div class="card card-outline card-primary mt-4">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-list-ul mr-2"></i>

            Rincian Biaya

        </h3>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="55" class="text-center">
                            No
                        </th>

                        <th>
                            Nama Biaya
                        </th>

                        <th width="150">
                            Asal
                        </th>

                        <th width="180" class="text-right">
                            Nominal (Rp)
                        </th>

                        <th width="100" class="text-center">
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
                                    <i class="fas fa-tag text-danger mr-1"></i>

                                    <span class="text-danger font-weight-bold">

                                        {{ $item->fee_name }}

                                    </span>
                                @elseif ($item->source === 'Program')
                                    <i class="fas fa-graduation-cap text-primary mr-1"></i>

                                    {{ $item->fee_name }}
                                @else
                                    <i class="fas fa-layer-group text-warning mr-1"></i>

                                    {{ $item->fee_name }}
                                @endif

                            </td>


                            <td>

                                @if ($item->source === 'Wave')
                                    <span class="badge badge-warning">
                                        Gelombang
                                    </span>
                                @elseif ($item->source === 'Program')
                                    <span class="badge badge-primary">
                                        Program
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        Diskon
                                    </span>
                                @endif

                            </td>


                            <td class="text-right font-weight-bold">

                                @if ($item->amount < 0)
                                    <span class="text-danger">

                                        − Rp
                                        {{ number_format(abs($item->amount), 0, ',', '.') }}

                                    </span>
                                @else
                                    Rp
                                    {{ number_format($item->amount, 0, ',', '.') }}
                                @endif

                            </td>


                            <td class="text-center">

                                @if ($item->is_required)
                                    <span class="badge badge-danger">

                                        <i class="fas fa-check mr-1"></i>
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

                            <td colspan="5" class="text-center text-muted py-4">

                                <i class="fas fa-file-invoice fa-2x mb-2"></i>

                                <br>

                                Belum ada rincian biaya.

                            </td>

                        </tr>
                    @endforelse

                </tbody>


                <tfoot>

                    {{-- TOTAL TAGIHAN --}}
                    <tr class="bg-light">

                        <th colspan="3" class="text-right">
                            TOTAL TAGIHAN
                        </th>

                        <th class="text-right text-primary">

                            Rp
                            {{ number_format($participantInvoice->total_amount, 0, ',', '.') }}

                        </th>

                        <th></th>

                    </tr>


                    {{-- SUDAH DIBAYAR --}}
                    <tr>

                        <th colspan="3" class="text-right">
                            SUDAH DIBAYAR
                        </th>

                        <th class="text-right text-success">

                            Rp
                            {{ number_format($participantInvoice->paid_amount, 0, ',', '.') }}

                        </th>

                        <th></th>

                    </tr>


                    {{-- SISA TAGIHAN --}}
                    @php
                        $remainingAmount = max(0, $participantInvoice->total_amount - $participantInvoice->paid_amount);
                    @endphp

                    <tr class="{{ $remainingAmount > 0 ? 'bg-warning' : 'bg-success' }}">

                        <th colspan="3" class="text-right">

                            SISA TAGIHAN

                        </th>

                        <th class="text-right">

                            Rp
                            {{ number_format($remainingAmount, 0, ',', '.') }}

                        </th>

                        <th></th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     RINGKASAN PEMBAYARAN
     ========================================================= --}}

@php

    $totalAmount = (float) $participantInvoice->total_amount;

    $paidAmount = (float) $participantInvoice->paid_amount;

    $remainingAmount = max(0, $totalAmount - $paidAmount);

@endphp


{{-- =========================================================
     FORM PEMBAYARAN
     ========================================================= --}}

@if ($remainingAmount > 0)
    <div class="card card-outline card-success mt-3">

        {{-- HEADER --}}
        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-money-bill-wave mr-2"></i>

                Tambah Pembayaran

            </h3>

        </div>


        <form id="paymentForm" action="{{ route('finance.payments.store') }}" method="POST">

            @csrf

            <input type="hidden" name="participant_invoice_id" value="{{ $participantInvoice->id }}">


            {{-- =================================================
                 BODY
                 ================================================= --}}
            <div class="card-body">

                <div class="row">


                    {{-- =========================================
                         TANGGAL PEMBAYARAN
                         ========================================= --}}
                    <div class="col-md-4">

                        <x-adminlte-input name="payment_date" type="date" label="Tanggal Pembayaran"
                            value="{{ old('payment_date', now()->toDateString()) }}" />

                    </div>


                    {{-- =========================================
                         JENIS PEMBAYARAN
                         ========================================= --}}
                    <div class="col-md-4">

                        <x-adminlte-select name="payment_type" label="Jenis Pembayaran">

                            <option value="Offline" @selected(old('payment_type', 'Offline') === 'Offline')>

                                Offline

                            </option>

                            <option value="Online" @selected(old('payment_type') === 'Online')>

                                Online

                            </option>

                        </x-adminlte-select>

                    </div>


                    {{-- =========================================
                         CHANNEL PEMBAYARAN
                         ========================================= --}}
                    <div class="col-md-4">

                        <x-adminlte-select name="payment_channel" label="Channel Pembayaran">

                            <option value="Cash" @selected(old('payment_channel', 'Cash') === 'Cash')>

                                Cash

                            </option>

                            <option value="Transfer" @selected(old('payment_channel') === 'Transfer')>

                                Transfer

                            </option>

                            <option value="QRIS" @selected(old('payment_channel') === 'QRIS')>

                                QRIS

                            </option>

                            <option value="Midtrans" @selected(old('payment_channel') === 'Midtrans')>

                                Midtrans

                            </option>

                        </x-adminlte-select>

                    </div>



                    {{-- =========================================
                         NOMINAL PEMBAYARAN
                         ========================================= --}}
                    <div class="col-md-4">

                        <x-adminlte-input id="amount" name="amount" type="number" label="Nominal Pembayaran"
                            min="1" max="{{ $remainingAmount }}"
                            value="{{ old('amount', $remainingAmount) }}" />

                        <input type="hidden" id="remaining_amount" value="{{ $remainingAmount }}">


                        <small class="form-text text-muted">

                            Sisa tagihan:
                            <br>
                            <strong class="text-danger">

                                Rp {{ number_format($remainingAmount, 0, ',', '.') }}

                            </strong>

                        </small>


                        @error('amount')
                            <small class="text-danger d-block mt-1">

                                <i class="fas fa-exclamation-circle mr-1"></i>

                                {{ $message }}

                            </small>
                        @enderror

                    </div>



                    {{-- =========================================
                         NOMOR REFERENSI
                         ========================================= --}}
                    <div class="col-md-4">

                        <x-adminlte-input name="reference_number" label="No. Referensi" placeholder="Opsional"
                            value="{{ old('reference_number') }}" />

                    </div>



                    {{-- =========================================
                         CATATAN
                         ========================================= --}}
                    <div class="col-md-4">

                        <x-adminlte-input name="note" label="Catatan" placeholder="Opsional"
                            value="{{ old('note') }}" />

                    </div>

                </div>


                {{-- =================================================
                     INFORMASI
                     ================================================= --}}
                <div class="alert alert-light border mt-2 mb-0">

                    <div class="d-flex align-items-start">

                        <i class="fas fa-info-circle text-info mt-1 mr-2"></i>

                        <div>

                            <strong>Informasi Pembayaran</strong>

                            <div class="small text-muted mt-1">

                                Nominal pembayaran tidak boleh melebihi
                                sisa tagihan.

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 FOOTER / TOMBOL
                 ================================================= --}}
            <div class="card-footer d-flex justify-content-end">

                <button type="submit" class="btn btn-success px-4">

                    <i class="fas fa-save mr-1"></i>

                    Simpan Pembayaran

                </button>

            </div>


        </form>

    </div>
@else
    {{-- =========================================================
         TAGIHAN LUNAS
         ========================================================= --}}

    <div class="alert alert-success mt-3">

        <i class="fas fa-check-circle mr-2"></i>

        <strong>Tagihan sudah lunas.</strong>

        Tidak ada pembayaran yang perlu ditambahkan.

    </div>
@endif


{{-- =========================================================
     RIWAYAT PEMBAYARAN
     ========================================================= --}}

<div class="card card-outline card-info mt-4">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-history mr-2"></i>

            Riwayat Pembayaran

        </h3>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="55" class="text-center">
                            No
                        </th>

                        <th width="120">
                            Tanggal
                        </th>

                        <th class="text-right">
                            Nominal
                        </th>

                        <th>
                            Channel
                        </th>

                        <th>
                            Petugas
                        </th>

                        <th width="70" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($participantInvoice->payments as $payment)
                        <tr>

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>


                            <td>

                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}

                            </td>


                            <td class="text-right font-weight-bold">

                                Rp
                                {{ number_format($payment->amount, 0, ',', '.') }}

                            </td>


                            <td>

                                @if ($payment->payment_channel === 'Cash')
                                    <span class="badge badge-success">

                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Cash

                                    </span>
                                @elseif ($payment->payment_channel === 'Transfer')
                                    <span class="badge badge-primary">

                                        <i class="fas fa-university mr-1"></i>
                                        Transfer

                                    </span>
                                @elseif ($payment->payment_channel === 'QRIS')
                                    <span class="badge badge-info">

                                        <i class="fas fa-qrcode mr-1"></i>
                                        QRIS

                                    </span>
                                @else
                                    <span class="badge badge-secondary">

                                        {{ $payment->payment_channel }}

                                    </span>
                                @endif

                            </td>


                            <td>

                                {{ optional($payment->receiver)->name ?? '-' }}

                            </td>


                            <td class="text-center">

                                <form action="{{ route('finance.payments.destroy', $payment) }}" method="POST"
                                    onsubmit="return confirm('Hapus pembayaran ini?')">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pembayaran">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center text-muted py-4">

                                <i class="fas fa-history fa-2x mb-2"></i>

                                <br>

                                Belum ada pembayaran.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT VALIDASI PEMBAYARAN
     ========================================================= --}}

<script>
    $(document).on('submit', '#paymentForm', function(e) {

        let sisa = parseFloat(
            $('#remaining_amount').val()
        );

        let bayar = parseFloat(
            $('#amount').val()
        );


        if (isNaN(bayar) || bayar <= 0) {

            e.preventDefault();

            Swal.fire({

                icon: 'warning',

                title: 'Nominal Tidak Valid',

                text: 'Masukkan nominal pembayaran yang benar.'

            });

            return false;

        }


        if (bayar > sisa) {

            e.preventDefault();

            Swal.fire({

                icon: 'warning',

                title: 'Nominal Terlalu Besar',

                text: 'Nominal pembayaran tidak boleh melebihi sisa tagihan sebesar Rp ' +
                    new Intl.NumberFormat('id-ID').format(sisa) +
                    '.'

            });

            return false;

        }

    });
</script>
