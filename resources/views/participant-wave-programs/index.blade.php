@extends('adminlte::page')

@section('title', 'Program Peserta')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                Program Peserta
            </h1>

            <p class="text-muted mb-0">
                Kelola program dan penyesuaian biaya peserta.
            </p>

        </div>

        <a href="{{ route('participants.programs.create', $participant) }}" class="btn btn-primary">

            <i class="fas fa-plus mr-1"></i>
            Tambah Program

        </a>

    </div>

@stop


@section('content')


    {{-- =========================================================
         SUCCESS MESSAGE
         ========================================================= --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif



    {{-- =========================================================
         INFORMASI PESERTA
         ========================================================= --}}

    <div class="row">


        {{-- IDENTITAS PESERTA --}}

        <div class="col-md-8">

            <div class="card card-outline card-primary">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="mr-3">

                            <div class="participant-avatar">

                                <i class="fas fa-user"></i>

                            </div>

                        </div>

                        <div>

                            <h4 class="mb-1">

                                {{ $participant->user->name }}

                            </h4>

                            <div class="text-muted">

                                <i class="fas fa-envelope mr-1"></i>

                                {{ $participant->user->email }}

                            </div>

                            @if ($participant->nik)
                                <div class="text-muted mt-1">

                                    <i class="fas fa-id-card mr-1"></i>

                                    NIK: {{ $participant->nik }}

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- JUMLAH PROGRAM --}}

        <div class="col-md-4">

            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>
                        {{ $programs->count() }}
                    </h3>

                    <p>
                        Program Diikuti
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-graduation-cap"></i>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         DAFTAR PROGRAM
         ========================================================= --}}

    <div class="card card-outline card-primary">


        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-graduation-cap mr-1"></i>

                Daftar Program

            </h3>


            <div class="card-tools">

                <a href="{{ route('participants.index') }}" class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left mr-1"></i>

                    Kembali

                </a>

            </div>

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

                                Gelombang

                            </th>

                            <th>

                                Program

                            </th>

                            <th width="160" class="text-right">

                                Biaya Standar

                            </th>

                            <th width="180" class="text-right">

                                Penyesuaian Khusus

                            </th>

                            <th width="180" class="text-right">

                                Biaya Peserta

                            </th>

                            <th width="120" class="text-center">

                                Status

                            </th>

                            <th width="110" class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @forelse ($programs as $item)
                            @php

                                $standardFee = (float) ($item->waveProgram->fee ?? 0);

                                $agreedFee = $item->agreed_fee !== null ? (float) $item->agreed_fee : null;

                                $participantFee = $agreedFee !== null ? $agreedFee : $standardFee;

                            @endphp


                            <tr>


                                {{-- NO --}}

                                <td class="text-center align-middle">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- GELOMBANG --}}

                                <td class="align-middle">

                                    <span class="font-weight-bold">

                                        {{ $item->waveProgram->wave->name }}

                                    </span>

                                </td>


                                {{-- PROGRAM --}}

                                <td class="align-middle">

                                    <i class="fas fa-book text-primary mr-1"></i>

                                    {{ $item->waveProgram->program->name }}

                                </td>


                                {{-- BIAYA STANDAR --}}

                                <td class="text-right align-middle">

                                    <span class="text-muted">

                                        Rp {{ number_format($item->standard_fee, 0, ',', '.') }}

                                    </span>

                                </td>


                                {{-- PENYESUAIAN KHUSUS --}}

                                <td class="text-right align-middle">

                                    @if ($agreedFee !== null)
                                        <span class="badge badge-warning mb-1">

                                            <i class="fas fa-sliders-h mr-1"></i>

                                            Khusus

                                        </span>

                                        <br>

                                        <strong class="text-warning">

                                            Rp
                                            {{ number_format($agreedFee, 0, ',', '.') }}

                                        </strong>
                                    @else
                                        <span class="text-muted">

                                            <i class="fas fa-minus mr-1"></i>

                                            Tidak ada

                                        </span>
                                    @endif

                                </td>


                                {{-- BIAYA PESERTA --}}

                                <td class="text-right align-middle">

                                    <strong class="text-success">

                                        Rp
                                        {{ number_format($participantFee, 0, ',', '.') }}

                                    </strong>


                                    @if ($agreedFee !== null)
                                        <div>

                                            <small class="text-warning">

                                                Penyesuaian khusus

                                            </small>

                                        </div>
                                    @else
                                        <div>

                                            <small class="text-muted">

                                                Mengikuti standar

                                            </small>

                                        </div>
                                    @endif

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center align-middle">

                                    @switch($item->status)
                                        @case('Aktif')
                                            <span class="badge badge-success">

                                                <i class="fas fa-check-circle mr-1"></i>

                                                Aktif

                                            </span>
                                        @break

                                        @case('Lulus')
                                        @case('Selesai')
                                            <span class="badge badge-primary">

                                                <i class="fas fa-graduation-cap mr-1"></i>

                                                {{ $item->status }}

                                            </span>
                                        @break

                                        @case('Mengundurkan Diri')
                                        @case('Berhenti')
                                            <span class="badge badge-danger">

                                                <i class="fas fa-times-circle mr-1"></i>

                                                {{ $item->status }}

                                            </span>
                                        @break

                                        @case('Dibatalkan')
                                            <span class="badge badge-secondary">

                                                <i class="fas fa-ban mr-1"></i>

                                                Dibatalkan

                                            </span>
                                        @break

                                        @default
                                            <span class="badge badge-secondary">

                                                {{ $item->status }}

                                            </span>
                                    @endswitch

                                </td>


                                {{-- AKSI --}}

                                <td class="text-center align-middle">
                                    @if (!$item->is_finalized)
                                        <a href="{{ route('participants.programs.edit', [$participant, $item]) }}"
                                            class="btn btn-warning btn-sm" title="Edit Penyesuaian">

                                            <i class="fas fa-edit"></i>

                                        </a>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Program sudah difinalkan">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif
                                    @if (!$item->is_finalized)
                                        <form action="{{ route('participants.programs.destroy', [$participant, $item]) }}"
                                            method="POST" class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Program"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Program sudah difinalkan">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif

                                </td>

                            </tr>


                            @empty


                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        <div class="text-muted">

                                            <i class="fas fa-graduation-cap fa-3x mb-3"></i>

                                            <h5>

                                                Belum Ada Program

                                            </h5>

                                            <p>

                                                Peserta ini belum memiliki program.

                                            </p>

                                            <a href="{{ route('participants.programs.create', $participant) }}"
                                                class="btn btn-primary">

                                                <i class="fas fa-plus mr-1"></i>

                                                Tambah Program

                                            </a>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse


                        </tbody>

                    </table>

                </div>

            </div>



            {{-- =====================================================
             FOOTER
             ===================================================== --}}

            @if ($programs->count() > 0)
                <div class="card-footer bg-light">

                    <div class="d-flex justify-content-between align-items-center">

                        <small class="text-muted">

                            <i class="fas fa-info-circle mr-1"></i>

                            Total
                            <strong>{{ $programs->count() }}</strong>
                            program.

                        </small>


                        <small class="text-muted">

                            <span class="mr-3">

                                <i class="fas fa-square text-muted mr-1"></i>

                                Biaya Standar

                            </span>

                            <span>

                                <i class="fas fa-square text-warning mr-1"></i>

                                Penyesuaian Khusus

                            </span>

                        </small>

                    </div>

                </div>
            @endif


        </div>


    @stop



    @section('css')

        <style>
            .participant-avatar {

                width: 55px;
                height: 55px;

                border-radius: 50%;

                display: flex;
                align-items: center;
                justify-content: center;

                background-color: #e9ecef;

                color: #6c757d;

                font-size: 24px;

            }


            .table td,
            .table th {

                vertical-align: middle;

            }


            .small-box {

                min-height: 130px;

            }


            .small-box .icon {

                top: 15px;

            }


            .card-outline {

                border-top: 3px solid #007bff;

            }


            @media (max-width: 768px) {

                .content-header h1 {

                    font-size: 22px;

                }

            }
        </style>

    @stop
