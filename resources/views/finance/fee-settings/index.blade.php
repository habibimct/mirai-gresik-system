@extends('adminlte::page')
@section('title', 'Pengaturan Biaya')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-1">
                <i class="fas fa-money-bill-wave text-primary mr-2"></i>
                Pengaturan Biaya
            </h1>
            <p class="text-muted mb-0">
                Kelola biaya gelombang dan biaya program yang akan digunakan dalam tagihan peserta.
            </p>
        </div>
    </div>
@stop

@section('content')

    {{-- =========================================================
         PESAN SUKSES
         ========================================================= --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- =========================================================
         PESAN ERROR
         ========================================================= --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Terjadi kesalahan
            </strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- =========================================================
         INFORMASI SISTEM BIAYA
         ========================================================= --}}
    <div class="alert alert-info">
        <div class="d-flex">
            <div class="mr-3">
                <i class="fas fa-info-circle fa-lg"></i>
            </div>
            <div>
                <strong>
                    Cara kerja pengaturan biaya
                </strong>
                <div class="mt-1">
                    <small>
                        {{-- <strong>Biaya Gelombang</strong>
                        berlaku untuk seluruh peserta pada gelombang.
                        Sedangkan --}}
                        <strong>Biaya Program</strong>
                        berlaku khusus untuk kombinasi program dan gelombang.
                        Semua biaya yang aktif akan digunakan saat membuat atau menghitung ulang invoice peserta.
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         BIAYA GELOMBANG
         ========================================================= --}}
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-layer-group mr-2"></i>
                Biaya Gelombang
            </h3>
            <div class="card-tools">
                @if (request('wave_id'))
                    <span class="badge badge-warning">
                        {{ $waves->firstWhere('id', request('wave_id'))?->name }}
                    </span>
                @endif
            </div>
        </div>
        {{-- FILTER GELOMBANG --}}
        <div class="card-body pb-2">
            <form method="GET">
                {{-- Pertahankan program_id jika ada --}}
                <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                <div class="row align-items-end">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="wave_id">
                                <i class="fas fa-layer-group mr-1"></i>
                                Pilih Gelombang
                            </label>
                            <select name="wave_id" id="wave_id" class="form-control">
                                <option value="">
                                    -- Pilih Gelombang --
                                </option>
                                @foreach ($waves as $wave)
                                    <option value="{{ $wave->id }}" @selected(request('wave_id') == $wave->id)>
                                        {{ $wave->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning btn-block">
                                <i class="fas fa-search mr-1"></i>
                                Tampilkan Biaya
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- HASIL BIAYA GELOMBANG --}}
        @if (request('wave_id'))
            <div class="card-body pt-0">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-list mr-1"></i>
                            Daftar Biaya Gelombang
                        </h5>
                        <small class="text-muted">
                            Biaya yang berlaku umum pada gelombang ini.
                        </small>
                    </div>
                    <button class="btn btn-success btn-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalWaveFee">
                        <i class="fas fa-plus mr-1"></i>
                        Tambah Biaya
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="60" class="text-center">
                                    No
                                </th>
                                <th>
                                    Nama Biaya
                                </th>
                                <th width="220" class="text-right">
                                    Nominal
                                </th>
                                <th width="130" class="text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($waveFeeSettings as $fee)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <i class="fas fa-receipt text-warning mr-2"></i>
                                        <strong>
                                            {{ $fee->fee_name }}
                                        </strong>
                                    </td>
                                    <td class="text-right">
                                        <span class="font-weight-bold">
                                            Rp
                                            {{ number_format($fee->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if (!$fee->is_finalized)
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editWaveFee{{ $fee->id }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled
                                                title="Biaya sudah digunakan pada tagihan yang difinalkan">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                        @if (!$fee->is_finalized)
                                            <form action="{{ route('finance.wave-fee-settings.destroy', $fee) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus biaya {{ $fee->fee_name }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled
                                                title="Biaya sudah digunakan pada tagihan yang difinalkan">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                        <div class="text-muted">
                                            Belum ada biaya untuk gelombang ini.
                                        </div>
                                        <small class="text-muted">
                                            Klik "Tambah Biaya" untuk menambahkan biaya.
                                        </small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($waveFeeSettings->count())
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="2" class="text-right">
                                        Total Biaya Gelombang
                                    </th>
                                    <th class="text-right">
                                        <span class="text-warning font-weight-bold">
                                            Rp
                                            {{ number_format($waveFeeSettings->sum('amount'), 0, ',', '.') }}
                                        </span>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        @else
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-layer-group fa-3x text-warning mb-3"></i>
                    <h5>
                        Pilih Gelombang
                    </h5>
                    <p class="text-muted mb-0">
                        Pilih gelombang terlebih dahulu untuk melihat
                        dan mengatur biaya yang berlaku pada gelombang tersebut.
                    </p>
                </div>
            </div>
        @endif
    </div>

    {{-- =========================================================
         BIAYA PROGRAM
         ========================================================= --}}
    <div class="card card-primary card-outline mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-graduation-cap mr-2"></i>
                Biaya Program
            </h3>
            @if (request('program_id') && request('wave_id'))
                <div class="card-tools">
                    <span class="badge badge-primary">
                        Program & Gelombang Dipilih
                    </span>
                </div>
            @endif
        </div>

        {{-- FILTER PROGRAM --}}
        <div class="card-body pb-2">
            <form method="GET">
                <div class="row align-items-end">
                    {{-- PROGRAM --}}
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="program_id">
                                <i class="fas fa-graduation-cap mr-1"></i>
                                Program
                            </label>
                            <select name="program_id" id="program_id" class="form-control">
                                <option value="">
                                    -- Pilih Program --
                                </option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- GELOMBANG --}}
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="program_wave_id">
                                <i class="fas fa-layer-group mr-1"></i>
                                Gelombang
                            </label>
                            <select name="wave_id" id="program_wave_id" class="form-control">
                                <option value="">
                                    -- Pilih Gelombang --
                                </option>
                                @foreach ($waves as $wave)
                                    <option value="{{ $wave->id }}" @selected(request('wave_id') == $wave->id)>
                                        {{ $wave->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-1"></i>
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- HASIL BIAYA PROGRAM --}}
        @if (request('program_id') && request('wave_id'))
            <div class="card-body pt-0">

                {{-- INFORMASI FILTER --}}
                <div class="selected-program mb-3">
                    <div>
                        <small class="text-muted d-block">
                            PROGRAM
                        </small>
                        <strong>
                            {{ $programs->firstWhere('id', request('program_id'))?->name }}
                        </strong>
                    </div>

                    <div class="separator d-none d-md-block">
                        <i class="fas fa-chevron-right"></i>
                    </div>

                    <div>
                        <small class="text-muted d-block">
                            GELOMBANG
                        </small>
                        <strong>
                            {{ $waves->firstWhere('id', request('wave_id'))?->name }}
                        </strong>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-file-invoice-dollar mr-1"></i>
                            Rincian Biaya Program
                        </h5>
                        <small class="text-muted">
                            Biaya-biaya berikut akan menjadi komponen invoice peserta.
                        </small>
                    </div>

                    <button class="btn btn-primary btn-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalCreate">
                        <i class="fas fa-plus mr-1"></i>
                        Tambah Biaya
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="60" class="text-center">
                                    No
                                </th>
                                <th>
                                    Nama Biaya
                                </th>
                                <th width="220" class="text-right">
                                    Nominal
                                </th>
                                <th width="130" class="text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($feeSettings as $fee)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <i class="fas fa-money-check-alt text-primary mr-2"></i>
                                        <strong>
                                            {{ $fee->fee_name }}
                                        </strong>
                                    </td>
                                    <td class="text-right">
                                        <span class="font-weight-bold">
                                            Rp
                                            {{ number_format($fee->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if (!$fee->is_finalized)
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editFee{{ $fee->id }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled
                                                title="Biaya sudah digunakan pada tagihan yang difinalkan">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                        @if (!$fee->is_finalized)
                                            <form action="{{ route('finance.fee-settings.destroy', $fee) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus biaya {{ $fee->fee_name }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled
                                                title="Biaya sudah digunakan pada tagihan yang difinalkan">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-file-invoice-dollar fa-2x text-muted mb-2"></i>
                                        <div class="text-muted">
                                            Belum ada biaya untuk program dan gelombang ini.
                                        </div>
                                        <small class="text-muted">
                                            Klik "Tambah Biaya" untuk menambahkan komponen biaya.
                                        </small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if ($feeSettings->count())
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="2" class="text-right">
                                        Total Biaya Program
                                    </th>
                                    <th class="text-right">
                                        <span class="text-primary font-weight-bold">
                                            Rp
                                            {{ number_format($feeSettings->sum('amount'), 0, ',', '.') }}
                                        </span>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                {{-- CATATAN --}}
                @if ($feeSettings->count())
                    <div class="alert alert-light border mt-3 mb-0">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        <small>
                            Total biaya program saat ini adalah
                            <strong>
                                Rp {{ number_format($feeSettings->sum('amount'), 0, ',', '.') }}
                            </strong>.
                            Nilai ini akan digunakan sebagai biaya standar program
                            ketika invoice peserta dibuat.
                        </small>
                    </div>
                @endif
            </div>
        @else
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                    <h5>
                        Pilih Program & Gelombang
                    </h5>
                    <p class="text-muted mb-0">
                        Pilih program dan gelombang terlebih dahulu
                        untuk melihat serta mengatur biaya program.
                    </p>
                </div>
            </div>
        @endif
    </div>

    {{-- =========================================================
         MODAL TAMBAH BIAYA PROGRAM
         ========================================================= --}}
    <x-adminlte-modal id="modalCreate" title="Tambah Biaya Program" theme="primary" icon="fas fa-plus">
        <form id="createFeeForm" action="{{ route('finance.fee-settings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="program_id" value="{{ request('program_id') }}">
            <input type="hidden" name="wave_id" value="{{ request('wave_id') }}">

            <x-adminlte-input name="fee_name" label="Nama Biaya" placeholder="Contoh: Pelatihan, Asrama, Seragam, Modul"
                required />

            <x-adminlte-input name="amount" label="Nominal" type="number" min="0" step="1000"
                placeholder="0" required />
        </form>

        <x-slot name="footerSlot">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fas fa-times mr-1"></i>
                Batal
            </button>

            <button type="submit" form="createFeeForm" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>
                Simpan
            </button>
        </x-slot>
    </x-adminlte-modal>

    {{-- =========================================================
         MODAL TAMBAH BIAYA GELOMBANG
         ========================================================= --}}
    <x-adminlte-modal id="modalWaveFee" title="Tambah Biaya Gelombang" theme="warning" icon="fas fa-plus">
        <form id="waveFeeForm" action="{{ route('finance.wave-fee-settings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="wave_id" value="{{ request('wave_id') }}">

            <x-adminlte-input name="fee_name" label="Nama Biaya" placeholder="Contoh: Pendaftaran" required />

            <x-adminlte-input name="amount" label="Nominal" type="number" min="0" step="1000"
                placeholder="0" required />
        </form>

        <x-slot name="footerSlot">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fas fa-times mr-1"></i>
                Batal
            </button>

            <button type="submit" form="waveFeeForm" class="btn btn-warning">
                <i class="fas fa-save mr-1"></i>
                Simpan
            </button>
        </x-slot>
    </x-adminlte-modal>

    {{-- =========================================================
         MODAL EDIT BIAYA GELOMBANG
         ========================================================= --}}
    @foreach ($waveFeeSettings as $fee)
        <x-adminlte-modal id="editWaveFee{{ $fee->id }}" title="Edit Biaya Gelombang" theme="warning"
            icon="fas fa-edit">
            <form id="editWaveFeeForm{{ $fee->id }}" action="{{ route('finance.wave-fee-settings.update', $fee) }}"
                method="POST">
                @csrf
                @method('PUT')

                <x-adminlte-input name="fee_name" label="Nama Biaya" value="{{ $fee->fee_name }}" required />

                <x-adminlte-input name="amount" label="Nominal" type="number" min="0" step="1000"
                    value="{{ $fee->amount }}" required />
            </form>

            <x-slot name="footerSlot">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>

                <button type="submit" form="editWaveFeeForm{{ $fee->id }}" class="btn btn-warning">
                    <i class="fas fa-save mr-1"></i>
                    Simpan Perubahan
                </button>
            </x-slot>
        </x-adminlte-modal>
    @endforeach

    {{-- =========================================================
         MODAL EDIT BIAYA PROGRAM
         ========================================================= --}}
    @foreach ($feeSettings as $fee)
        <x-adminlte-modal id="editFee{{ $fee->id }}" title="Edit Biaya Program" theme="primary"
            icon="fas fa-edit">
            <form id="editFeeForm{{ $fee->id }}" action="{{ route('finance.fee-settings.update', $fee) }}"
                method="POST">
                @csrf
                @method('PUT')

                <x-adminlte-input name="fee_name" label="Nama Biaya" value="{{ $fee->fee_name }}" required />

                <x-adminlte-input name="amount" label="Nominal" type="number" min="0" step="1000"
                    value="{{ $fee->amount }}" required />
            </form>

            <x-slot name="footerSlot">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>

                <button type="submit" form="editFeeForm{{ $fee->id }}" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Simpan Perubahan
                </button>
            </x-slot>
        </x-adminlte-modal>
    @endforeach

@stop

@section('css')
    <style>
        /*
                    |--------------------------------------------------------------------------
                    | HEADER
                    |--------------------------------------------------------------------------
                    */
        .content-header h1 {
            font-weight: 600;
        }

        /*
                    |--------------------------------------------------------------------------
                    | CARD
                    |--------------------------------------------------------------------------
                    */
        .card {
            border-radius: 6px;
        }
        .card-header {
            padding: 14px 18px;
        }
        .card-title {
            font-weight: 600;
        }

        /*
                    |--------------------------------------------------------------------------
                    | TABLE
                    |--------------------------------------------------------------------------
                    */
        .table {
            margin-bottom: 0;
        }
        .table th {
            font-weight: 600;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        /*
                    |--------------------------------------------------------------------------
                    | NOMINAL
                    |--------------------------------------------------------------------------
                    */
        .table td.text-right {
            white-space: nowrap;
        }

        /*
                    |--------------------------------------------------------------------------
                    | SELECTED PROGRAM
                    |--------------------------------------------------------------------------
                    */
        .selected-program {
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 15px 18px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }
        .selected-program strong {
            font-size: 16px;
        }
        .separator {
            color: #adb5bd;
        }

        /*
                    |--------------------------------------------------------------------------
                    | EMPTY STATE
                    |--------------------------------------------------------------------------
                    */
        .empty-state {
            text-align: center;
            padding: 30px 15px;
        }
        .empty-state h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        /*
                    |--------------------------------------------------------------------------
                    | RESPONSIVE
                    |--------------------------------------------------------------------------
                    */
        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 22px;
            }
            .selected-program {
                display: block;
            }
            .selected-program>div {
                margin-bottom: 10px;
            }
            .separator {
                display: none;
            }
            .card-body {
                padding: 15px;
            }
        }
    </style>
@stop
