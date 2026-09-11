@extends('adminlte::page')

@section('title', 'Edit Program Peserta')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="m-0">
                Edit Program Peserta
            </h1>

            <small class="text-muted">
                Mengubah data keikutsertaan peserta pada program pelatihan
            </small>
        </div>

        <a href="{{ route('participants.programs.index', $participant) }}" class="btn btn-secondary btn-sm">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>

@stop


@section('content')

    {{-- =========================================================
         VALIDASI ERROR
         ========================================================= --}}

    @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Data belum dapat disimpan
            </h5>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    @endif


    {{-- =========================================================
         CARD UTAMA
         ========================================================= --}}

    <div class="card card-primary card-outline">


        {{-- HEADER --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-edit mr-2"></i>

                Data Keikutsertaan Program

            </h3>

        </div>


        <form action="{{ route('participants.programs.update', [$participant, $program]) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="card-body">


                {{-- =====================================================
                     IDENTITAS PESERTA
                     ===================================================== --}}

                <div class="section-title mb-3">

                    <h5 class="text-primary mb-1">

                        <i class="fas fa-user mr-2"></i>
                        Identitas Peserta

                    </h5>

                    <small class="text-muted">
                        Informasi peserta yang terdaftar pada program.
                    </small>

                </div>


                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Nama Peserta
                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>

                                </div>

                                <input type="text" class="form-control bg-light" value="{{ $participant->user->name }}"
                                    readonly>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Program
                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">
                                        <i class="fas fa-graduation-cap"></i>
                                    </span>

                                </div>

                                <input type="text" class="form-control bg-light"
                                    value="{{ $program->waveProgram->program->name }}" readonly>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Gelombang
                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">
                                        <i class="fas fa-layer-group"></i>
                                    </span>

                                </div>

                                <input type="text" class="form-control bg-light"
                                    value="{{ $program->waveProgram->wave->name }}" readonly>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Biaya Standar
                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Rp
                                    </span>
                                </div>

                                <input type="text" class="form-control bg-light"
                                    value="{{ number_format($standardFee, 0, ',', '.') }}" readonly>

                            </div>

                            <small class="text-muted">
                                Biaya standar dihitung otomatis dari pengaturan biaya
                                gelombang dan program.
                            </small>

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =====================================================
                     PENGATURAN BIAYA
                     ===================================================== --}}

                <div class="section-title mb-3">

                    <h5 class="text-primary mb-1">

                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Pengaturan Biaya

                    </h5>

                    <small class="text-muted">
                        Atur biaya khusus dan potongan untuk peserta.
                    </small>

                </div>


                <div class="row">


                    {{-- BIAYA DISEPAKATI --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="agreed_fee">

                                Biaya Disepakati

                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                </div>

                                <input type="number" id="agreed_fee" name="agreed_fee"
                                    class="form-control @error('agreed_fee') is-invalid @enderror"
                                    value="{{ old('agreed_fee', $program->agreed_fee) }}" min="0" step="1000"
                                    placeholder="Contoh: 500000">

                                @error('agreed_fee')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <small class="form-text text-muted">

                                Kosongkan apabila peserta menggunakan biaya standar.

                            </small>

                        </div>

                    </div>


                    {{-- DISKON --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="discount">

                                Diskon

                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                </div>

                                <input type="number" id="discount" name="discount"
                                    class="form-control @error('discount') is-invalid @enderror"
                                    value="{{ old('discount', $program->discount) }}" min="0" step="1000"
                                    placeholder="Contoh: 100000">

                                @error('discount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <small class="form-text text-muted">

                                Masukkan nominal potongan biaya peserta.

                            </small>

                        </div>

                    </div>

                </div>

                <hr class="my-4">

                <div class="section-title mb-3">

                    <h5 class="text-primary mb-1">

                        <i class="fas fa-calculator mr-2"></i>

                        Ringkasan Biaya

                    </h5>

                    <small class="text-muted">
                        Perhitungan biaya peserta berdasarkan pengaturan di atas.
                    </small>

                </div>


                <div class="row">

                    {{-- BIAYA STANDAR --}}

                    <div class="col-md-4">

                        <div class="small text-muted">
                            Biaya Standar
                        </div>

                        <div class="h5 mb-0">

                            Rp {{ number_format($standardFee, 0, ',', '.') }}

                        </div>

                    </div>


                    {{-- BIAYA KHUSUS --}}

                    <div class="col-md-4">

                        <div class="small text-muted">
                            Biaya Disepakati
                        </div>

                        <div class="h5 mb-0">

                            @if ($agreedFee !== null)
                                Rp {{ number_format($agreedFee, 0, ',', '.') }}
                            @else
                                <span class="text-muted">
                                    Menggunakan standar
                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- DISKON --}}

                    <div class="col-md-4">

                        <div class="small text-muted">
                            Diskon
                        </div>

                        <div class="h5 mb-0">

                            Rp {{ number_format($discount, 0, ',', '.') }}

                        </div>

                    </div>

                </div>


                <div class="alert alert-info mt-4 mb-0">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <strong>
                                <i class="fas fa-file-invoice-dollar mr-1"></i>
                                Perkiraan Total Tagihan
                            </strong>

                            <div class="small">
                                Nilai ini yang akan digunakan saat invoice dibuat.
                            </div>

                        </div>

                        <div class="h4 mb-0" id="final-fee">

                            Rp {{ number_format($finalFee, 0, ',', '.') }}

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     STATUS
                     ===================================================== --}}

                <div class="form-group">

                    <label for="status">

                        Status Keikutsertaan

                    </label>

                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">

                        @foreach (['Aktif', 'Lulus', 'Mengundurkan Diri', 'Dibatalkan'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $program->status) == $status ? 'selected' : '' }}>

                                {{ $status }}

                            </option>
                        @endforeach

                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text text-muted">

                        Status menunjukkan kondisi keikutsertaan peserta pada program ini.

                    </small>

                </div>


            </div>


            {{-- =========================================================
                 FOOTER
                 ========================================================= --}}

            <div class="card-footer bg-light">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">

                        <i class="fas fa-info-circle mr-1"></i>

                        Pastikan data sudah benar sebelum disimpan.

                    </small>


                    <div>

                        <a href="{{ route('participants.programs.index', $participant) }}"
                            class="btn btn-secondary mr-1">

                            <i class="fas fa-times mr-1"></i>

                            Batal

                        </a>


                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save mr-1"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </div>


        </form>

    </div>

@stop


@section('css')

    <style>
        .section-title {
            border-left: 4px solid #007bff;
            padding-left: 12px;
        }

        .form-group label {
            font-weight: 600;
        }

        .card-outline {
            border-top: 3px solid #007bff;
        }

        .input-group-text {
            min-width: 42px;
            justify-content: center;
        }
    </style>

@stop


@section('js')

    <script>
        $(document).ready(function() {

            function formatRupiah(number) {

                return new Intl.NumberFormat('id-ID').format(number);

            }


            function calculateTotal() {

                const standardFee =
                    parseFloat(@json($standardFee)) || 0;

                const agreedFee =
                    parseFloat($('#agreed_fee').val()) || 0;

                const discount =
                    parseFloat($('#discount').val()) || 0;


                /*
                |--------------------------------------------------------------------------
                | Jika agreed fee kosong
                | gunakan biaya standar
                |--------------------------------------------------------------------------
                */

                const baseFee =
                    $('#agreed_fee').val() === '' ?
                    standardFee :
                    agreedFee;


                const total =
                    Math.max(
                        0,
                        baseFee - discount
                    );


                $('#final-fee').text(
                    'Rp ' + formatRupiah(total)
                );

            }


            $('#agreed_fee, #discount').on(
                'input',
                calculateTotal
            );


            calculateTotal();

        });
    </script>

@stop
