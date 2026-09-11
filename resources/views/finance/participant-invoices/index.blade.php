@extends('adminlte::page')

@section('title', 'Tagihan Peserta')


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

@section('content_header')

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h1 class="mb-1">
                <i class="fas fa-file-invoice-dollar text-primary mr-2"></i>
                Tagihan Peserta
            </h1>

            <p class="text-muted mb-0">
                Kelola tagihan, finalisasi, pembayaran, dan informasi invoice peserta.
            </p>

        </div>

    </div>

@stop



{{-- ========================================================= --}}
{{-- CONTENT --}}
{{-- ========================================================= --}}

@section('content')


    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('generate_messages'))

        <div class="alert alert-success alert-dismissible fade show">

            <h5>
                <i class="fas fa-check-circle mr-1"></i>
                Proses Berhasil
            </h5>

            <ul class="mb-0">

                @foreach (session('generate_messages') as $message)

                    <li>
                        {{ $message }}
                    </li>

                @endforeach

            </ul>

            <button type="button"
                class="close"
                data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- GENERATE FAILED --}}
    {{-- ========================================================= --}}

    @if (session('generate_failed'))

        <div class="alert alert-warning alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Beberapa Tagihan Tidak Dapat Diperbarui
            </h5>

            <ul class="mb-0">

                @foreach (session('generate_failed') as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button type="button"
                class="close"
                data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- INVOICE FAILED --}}
    {{-- ========================================================= --}}

    @if (session('invoice_failed'))

        <div class="alert alert-warning alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Beberapa Invoice Tidak Dapat Diperbarui
            </h5>

            <p class="mb-3">

                Invoice berikut tidak diperbarui karena jumlah pembayaran
                yang sudah diterima lebih besar daripada total tagihan baru.

            </p>


            <div class="table-responsive">

                <table class="table table-bordered table-sm bg-white mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="50" class="text-center">
                                No
                            </th>

                            <th>
                                Peserta
                            </th>

                            <th>
                                Program
                            </th>

                            <th>
                                Keterangan
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach (session('invoice_failed') as $index => $failed)

                            <tr>

                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $failed['name'] }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $failed['program'] }}
                                </td>

                                <td>
                                    {{ $failed['message'] }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <button type="button"
                class="close"
                data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- STATISTIK --}}
    {{-- ========================================================= --}}

    @if (request()->filled('classroom_id'))

        @php

            $totalParticipants = $participants->count();

            $totalFinal = $participants
                ->filter(fn($item) => $item->invoice && $item->invoice->is_final)
                ->count();

            $totalDraft = $participants
                ->filter(fn($item) => $item->invoice && !$item->invoice->is_final)
                ->count();

            $totalPaid = $participants
                ->filter(
                    fn($item) =>
                        $item->invoice &&
                        $item->invoice->status === 'Lunas',
                )
                ->count();

        @endphp


        <div class="row">

            {{-- Total Peserta --}}

            <div class="col-lg-3 col-md-6">

                <div class="small-box bg-primary">

                    <div class="inner">

                        <h3>
                            {{ $totalParticipants }}
                        </h3>

                        <p>
                            Total Peserta
                        </p>

                    </div>

                    <div class="icon">

                        <i class="fas fa-users"></i>

                    </div>

                </div>

            </div>


            {{-- Final --}}

            <div class="col-lg-3 col-md-6">

                <div class="small-box bg-success">

                    <div class="inner">

                        <h3>
                            {{ $totalFinal }}
                        </h3>

                        <p>
                            Invoice Final
                        </p>

                    </div>

                    <div class="icon">

                        <i class="fas fa-lock"></i>

                    </div>

                </div>

            </div>


            {{-- Draft --}}

            <div class="col-lg-3 col-md-6">

                <div class="small-box bg-warning">

                    <div class="inner">

                        <h3>
                            {{ $totalDraft }}
                        </h3>

                        <p>
                            Invoice Draft
                        </p>

                    </div>

                    <div class="icon">

                        <i class="fas fa-edit"></i>

                    </div>

                </div>

            </div>


            {{-- Lunas --}}

            <div class="col-lg-3 col-md-6">

                <div class="small-box bg-info">

                    <div class="inner">

                        <h3>
                            {{ $totalPaid }}
                        </h3>

                        <p>
                            Sudah Lunas
                        </p>

                    </div>

                    <div class="icon">

                        <i class="fas fa-check-circle"></i>

                    </div>

                </div>

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- FILTER --}}
    {{-- ========================================================= --}}

    <x-adminlte-card
        title="Filter Peserta"
        theme="primary"
        icon="fas fa-filter"
        collapsible>

        <form method="GET">

            <div class="row">

                {{-- Gelombang --}}

                <div class="col-lg-5 col-md-5">

                    <x-adminlte-select
                        name="wave_id"
                        label="Gelombang">

                        <option value="">
                            -- Pilih Gelombang --
                        </option>

                        @foreach ($waves as $wave)

                            <option
                                value="{{ $wave->id }}"
                                @selected(request('wave_id') == $wave->id)>

                                {{ $wave->name }}

                            </option>

                        @endforeach

                    </x-adminlte-select>

                </div>


                {{-- Kelas --}}

                <div class="col-lg-5 col-md-5">

                    <x-adminlte-select
                        name="classroom_id"
                        label="Kelas">

                        <option value="">
                            -- Pilih Kelas --
                        </option>

                        @foreach ($classrooms as $classroom)

                            <option
                                value="{{ $classroom->id }}"
                                @selected(request('classroom_id') == $classroom->id)>

                                {{ $classroom->name }}

                            </option>

                        @endforeach

                    </x-adminlte-select>

                </div>


                {{-- Button --}}

                <div class="col-lg-2 col-md-2 d-flex align-items-end">

                    <div class="w-100 mb-3">

                        <button
                            type="submit"
                            class="btn btn-primary btn-block">

                            <i class="fas fa-search mr-1"></i>

                            Tampilkan

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </x-adminlte-card>



    {{-- ========================================================= --}}
    {{-- DAFTAR PESERTA --}}
    {{-- ========================================================= --}}

    <x-adminlte-card
        title="Daftar Tagihan Peserta"
        theme="success"
        icon="fas fa-file-invoice">

        {{-- ===================================================== --}}
        {{-- TOOLBAR --}}
        {{-- ===================================================== --}}

        @if (request()->filled('classroom_id') && $participants->count())

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

                <div class="mb-2">

                    <span class="text-muted">

                        <i class="fas fa-users mr-1"></i>

                        {{ $participants->count() }} peserta ditemukan

                    </span>

                </div>


                <div class="mb-2">

                    <form
                        action="{{ route('finance.participant-invoices.generate-all') }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        <input
                            type="hidden"
                            name="classroom_id"
                            value="{{ request('classroom_id') }}">

                        <button
                            type="submit"
                            class="btn btn-info"
                            onclick="return confirm('Generate / regenerate seluruh invoice pada kelas ini?')">

                            <i class="fas fa-sync-alt mr-1"></i>

                            Generate / Regenerate Semua

                        </button>

                    </form>

                </div>

            </div>

        @endif



        {{-- ===================================================== --}}
        {{-- TABLE --}}
        {{-- ===================================================== --}}

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0 invoice-table">

                <thead class="thead-light">

                    <tr>

                        <th
                            width="55"
                            class="text-center">

                            No

                        </th>

                        <th>
                            Peserta
                        </th>

                        <th>
                            Program
                        </th>

                        <th
                            width="170"
                            class="text-center">

                            Status Tagihan

                        </th>

                        <th
                            width="190"
                            class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($participants as $i => $participant)

                        @php

                            $invoice = $participant->invoice;

                            $participantName =
                                $participant
                                    ->participantWaveProgram
                                    ->participant
                                    ->user
                                    ->name;

                            $programName =
                                $participant
                                    ->participantWaveProgram
                                    ->waveProgram
                                    ->program
                                    ->name;

                        @endphp


                        <tr>

                            {{-- No --}}

                            <td class="text-center align-middle">

                                {{ $i + 1 }}

                            </td>


                            {{-- Peserta --}}

                            <td class="align-middle">

                                <div class="font-weight-bold">

                                    <i class="fas fa-user text-primary mr-1"></i>

                                    {{ $participantName }}

                                </div>

                            </td>


                            {{-- Program --}}

                            <td class="align-middle">

                                <span>

                                    <i class="fas fa-graduation-cap text-success mr-1"></i>

                                    {{ $programName }}

                                </span>

                            </td>


                            {{-- Status --}}

                            <td class="text-center align-middle">

                                @if (!$invoice)

                                    <span class="badge badge-secondary px-2 py-1">

                                        <i class="fas fa-file mr-1"></i>

                                        Belum Dibuat

                                    </span>

                                @else

                                    {{-- FINAL / DRAFT --}}

                                    <div class="mb-1">

                                        @if ($invoice->is_final)

                                            <span class="badge badge-success px-2 py-1">

                                                <i class="fas fa-lock mr-1"></i>

                                                Final

                                            </span>

                                        @else

                                            <span class="badge badge-warning px-2 py-1">

                                                <i class="fas fa-edit mr-1"></i>

                                                Draft

                                            </span>

                                        @endif

                                    </div>


                                    {{-- PEMBAYARAN --}}

                                    @switch($invoice->status)

                                        @case('Belum Bayar')

                                            <span class="badge badge-danger">

                                                Belum Bayar

                                            </span>

                                        @break

                                        @case('Sebagian')

                                            <span class="badge badge-warning">

                                                Sebagian Dibayar

                                            </span>

                                        @break

                                        @case('Lunas')

                                            <span class="badge badge-success">

                                                Lunas

                                            </span>

                                        @break

                                        @default

                                            <span class="badge badge-secondary">

                                                {{ $invoice->status }}

                                            </span>

                                    @endswitch

                                @endif

                            </td>


                            {{-- Aksi --}}

                            <td class="text-center align-middle">

                                @if (!$invoice)

                                    {{-- GENERATE --}}

                                    <form
                                        action="{{ route('finance.participant-invoices.generate', $participant) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm"
                                            title="Generate Invoice">

                                            <i class="fas fa-file-invoice"></i>

                                        </button>

                                    </form>

                                @else

                                    {{-- DETAIL --}}

                                    <button
                                        type="button"
                                        class="btn btn-info btn-sm btn-detail"
                                        data-id="{{ $invoice->id }}"
                                        title="Lihat Detail Invoice">

                                        <i class="fas fa-eye"></i>

                                    </button>


                                    {{-- FINAL / UNFINAL --}}

                                    @if (!$invoice->is_final)

                                        <form
                                            action="{{ route('finance.participant-invoices.finalize', $invoice) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Finalkan tagihan peserta ini? Setelah final, tagihan dapat dilihat oleh peserta.')">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-warning btn-sm"
                                                title="Finalkan Invoice">

                                                <i class="fas fa-unlock"></i>

                                            </button>

                                        </form>

                                    @else

                                        <form
                                            action="{{ route('finance.participant-invoices.unfinal', $invoice) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Buka kembali invoice ini? Invoice akan kembali menjadi Draft.')">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-primary btn-sm"
                                                title="Buka Kembali Invoice">

                                                <i class="fas fa-lock"></i>

                                            </button>

                                        </form>

                                    @endif


                                    {{-- WHATSAPP --}}

                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm btn-whatsapp"
                                        data-id="{{ $invoice->id }}"
                                        title="Kirim Tagihan melalui WhatsApp">

                                        <i class="fab fa-whatsapp"></i>

                                    </button>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fas fa-file-invoice fa-3x mb-3"></i>

                                    <h5>
                                        Belum Ada Data Peserta
                                    </h5>

                                    <p class="mb-0">

                                        Silakan pilih gelombang dan kelas
                                        terlebih dahulu.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>



        {{-- FOOTER --}}

        @if ($participants->count())

            <div class="card-footer px-0 pb-0">

                <small class="text-muted">

                    <i class="fas fa-info-circle mr-1"></i>

                    Menampilkan
                    <strong>{{ $participants->count() }}</strong>
                    peserta.

                </small>

            </div>

        @endif

    </x-adminlte-card>



    {{-- ========================================================= --}}
    {{-- DETAIL INVOICE --}}
    {{-- ========================================================= --}}

    <x-adminlte-modal
        id="invoiceModal"
        title="Detail Tagihan"
        size="xl"
        theme="primary"
        icon="fas fa-file-invoice">

        <div id="invoiceContent">

            <div class="text-center p-5">

                <i class="fas fa-spinner fa-spin fa-2x"></i>

                <br>

                Memuat data...

            </div>

        </div>

    </x-adminlte-modal>



    {{-- ========================================================= --}}
    {{-- WHATSAPP --}}
    {{-- ========================================================= --}}

    <x-adminlte-modal
        id="whatsappModal"
        title="Kirim Tagihan WhatsApp"
        theme="success"
        size="lg"
        icon="fab fa-whatsapp">

        <input
            type="hidden"
            id="invoice_id">


        <div class="form-group">

            <label>
                Nama Peserta
            </label>

            <input
                type="text"
                id="wa_name"
                class="form-control"
                readonly>

        </div>


        <div class="form-group">

            <label>
                Nomor WhatsApp
            </label>

            <input
                type="text"
                id="wa_phone"
                class="form-control"
                readonly>

        </div>


        <div class="form-group">

            <label>
                Isi Tagihan
            </label>

            <textarea
                id="wa_message"
                class="form-control"
                rows="14"
                readonly></textarea>

        </div>


        <div class="form-group">

            <label>
                Rekening Pembayaran
            </label>

            <textarea
                id="wa_rekening"
                class="form-control"
                rows="4">Bank ... (no. rekening: ...) atas nama: ...</textarea>

        </div>


        <div class="form-group">

            <label>
                Catatan Tambahan
            </label>

            <textarea
                id="wa_note"
                class="form-control"
                rows="3">Mohon melakukan pembayaran tepat waktu. Terima kasih.</textarea>

        </div>


        <x-slot name="footerSlot">

            <button
                class="btn btn-secondary"
                data-dismiss="modal">

                Tutup

            </button>

            <button
                id="btnOpenWA"
                class="btn btn-success">

                <i class="fab fa-whatsapp mr-1"></i>

                Buka WhatsApp

            </button>

        </x-slot>

    </x-adminlte-modal>



    {{-- ========================================================= --}}
    {{-- RIWAYAT PEMBAYARAN --}}
    {{-- ========================================================= --}}

    <x-adminlte-card
        title="Riwayat Pembayaran"
        theme="info"
        icon="fas fa-history">

        <div class="table-responsive">

            <table class="table table-bordered table-hover payment-table mb-0">

                <thead class="thead-light">

                    <tr>

                        <th
                            width="55"
                            class="text-center">

                            No

                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Peserta
                        </th>

                        <th
                            class="text-right">

                            Nominal

                        </th>

                        <th
                            class="text-center">

                            Jenis

                        </th>

                        <th>
                            Channel
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


                            <td>

                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}

                            </td>


                            <td>

                                <strong>

                                    {{ $payment->invoice->participantClassroom->participantWaveProgram->participant->user->name }}

                                </strong>

                            </td>


                            <td class="text-right font-weight-bold">

                                Rp
                                {{ number_format($payment->amount, 0, ',', '.') }}

                            </td>


                            <td class="text-center">

                                @if ($payment->payment_type == 'Offline')

                                    <span class="badge badge-success">

                                        <i class="fas fa-cash-register mr-1"></i>

                                        Offline

                                    </span>

                                @else

                                    <span class="badge badge-primary">

                                        <i class="fas fa-globe mr-1"></i>

                                        Online

                                    </span>

                                @endif

                            </td>


                            <td>

                                {{ $payment->payment_channel }}

                            </td>


                            <td>

                                {{ optional($payment->receiver)->name }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-4 text-muted">

                                <i class="fas fa-receipt fa-2x mb-2"></i>

                                <br>

                                Belum ada pembayaran.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </x-adminlte-card>


@stop



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

@section('js')

<script>

    /*
    |--------------------------------------------------------------------------
    | DETAIL INVOICE
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.btn-detail', function() {

        let id = $(this).data('id');


        $('#invoiceContent').html(

            '<div class="text-center p-5">' +

            '<i class="fas fa-spinner fa-spin fa-2x"></i>' +

            '<br>' +

            'Memuat data...' +

            '</div>'

        );


        $('#invoiceModal').modal('show');


        $('#invoiceContent').load(

            "{{ url('finance/participant-invoices') }}/" + id

        );

    });



    /*
    |--------------------------------------------------------------------------
    | WHATSAPP DATA
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.btn-whatsapp', function() {

        let id = $(this).data('id');


        $.get(

            '/finance/participant-invoices/' + id + '/whatsapp-data',

            function(res) {

                $('#invoice_id').val(res.id);

                $('#wa_name').val(res.name);

                $('#wa_phone').val(res.phone);

                $('#wa_message').val(res.message);

                $('#whatsappModal').modal('show');

            }

        );

    });



    /*
    |--------------------------------------------------------------------------
    | OPEN WHATSAPP
    |--------------------------------------------------------------------------
    */

    $('#btnOpenWA').click(function() {

        let phone = $('#wa_phone').val();


        phone = phone.replace(/\D/g, '');


        if (phone.startsWith('0')) {

            phone = '62' + phone.substring(1);

        }


        let message =

            $('#wa_message').val()

            +

            "\n\n"

            +

            "Rekening Pembayaran\n"

            +

            $('#wa_rekening').val()

            +

            "\n\n"

            +

            $('#wa_note').val();


        window.open(

            'https://wa.me/' +
            phone +
            '?text=' +
            encodeURIComponent(message),

            '_blank'

        );

    });

</script>

@stop