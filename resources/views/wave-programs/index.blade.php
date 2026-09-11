@extends('adminlte::page')

@section('title', 'Program Gelombang')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                {{ $wave->name }}
            </h1>

            <p class="text-muted mb-0">
                Daftar program yang tersedia pada gelombang ini
            </p>

        </div>

        <div>

            <a href="{{ route('waves.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>

                Kembali

            </a>

        </div>

    </div>

@stop


@section('content')


    {{-- =========================================================
         ALERT
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


    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">

            <i class="fas fa-exclamation-triangle mr-1"></i>

            {{ session('warning') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-times-circle mr-1"></i>

            {{ session('error') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif



    {{-- =========================================================
         RINGKASAN
         ========================================================= --}}

    <div class="row">


        {{-- NAMA GELOMBANG --}}
        <div class="col-md-4">

            <div class="info-box">

                <span class="info-box-icon bg-primary">

                    <i class="fas fa-layer-group"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Gelombang
                    </span>

                    <span class="info-box-number">

                        {{ $wave->name }}

                    </span>

                </div>

            </div>

        </div>


        {{-- JUMLAH PROGRAM --}}
        <div class="col-md-4">

            <div class="info-box">

                <span class="info-box-icon bg-info">

                    <i class="fas fa-book"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Jumlah Program
                    </span>

                    <span class="info-box-number">

                        {{ $wavePrograms->count() }}

                    </span>

                </div>

            </div>

        </div>


        {{-- PROGRAM AKTIF --}}
        <div class="col-md-4">

            <div class="info-box">

                <span class="info-box-icon bg-success">

                    <i class="fas fa-check-circle"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Program Aktif
                    </span>

                    <span class="info-box-number">

                        {{ $wavePrograms->where('is_active', true)->count() }}

                    </span>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         DAFTAR PROGRAM
         ========================================================= --}}

    <div class="card card-outline card-primary">


        {{-- HEADER --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-book mr-2"></i>

                Daftar Program

            </h3>


            <div class="card-tools">

                <a href="{{ route('waves.programs.create', $wave) }}" class="btn btn-primary btn-sm">

                    <i class="fas fa-plus mr-1"></i>

                    Tambah Program

                </a>

            </div>

        </div>



        {{-- BODY --}}

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">


                    <thead class="thead-light">

                        <tr>

                            <th width="60" class="text-center">

                                No

                            </th>

                            <th>

                                Program

                            </th>

                            <th width="130" class="text-center">

                                Kuota

                            </th>

                            <th width="130" class="text-center">

                                Status

                            </th>

                            <th width="180" class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>



                    <tbody>


                        @forelse($wavePrograms as $item)
                            <tr>


                                {{-- NO --}}

                                <td class="text-center">

                                    {{ $loop->iteration }}

                                </td>



                                {{-- PROGRAM --}}

                                <td>

                                    <div class="font-weight-bold">

                                        <i class="fas fa-graduation-cap text-primary mr-1"></i>

                                        {{ $item->program->name }}

                                    </div>

                                </td>



                                {{-- KUOTA --}}

                                <td class="text-center">

                                    <span class="badge badge-info">

                                        <i class="fas fa-users mr-1"></i>

                                        {{ $item->quota }}

                                    </span>

                                    <div class="small text-muted mt-1">

                                        Peserta

                                    </div>

                                </td>



                                {{-- STATUS --}}

                                <td class="text-center">

                                    @if ($item->is_active)
                                        <span class="badge badge-success">

                                            <i class="fas fa-check-circle mr-1"></i>

                                            Aktif

                                        </span>
                                    @else
                                        <span class="badge badge-secondary">

                                            <i class="fas fa-ban mr-1"></i>

                                            Nonaktif

                                        </span>
                                    @endif

                                </td>



                                {{-- AKSI --}}

                                <td class="text-center">

                                    <div class="btn-group">


                                        {{-- DETAIL --}}

                                        <a href="{{ route('waves.programs.show', [$wave, $item]) }}"
                                            class="btn btn-info btn-sm" title="Detail">

                                            <i class="fas fa-eye"></i>

                                        </a>



                                        {{-- EDIT --}}

                                        <a href="{{ route('waves.programs.edit', [$wave, $item]) }}"
                                            class="btn btn-warning btn-sm" title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>



                                        {{-- HAPUS --}}
                                        @if ($item->classrooms_count == 0)
                                            <form action="{{ route('waves.programs.destroy', [$wave, $item]) }}"
                                                method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus program ini dari gelombang?')">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled
                                                title="Program sudah memiliki kelas">

                                                <i class="fas fa-lock"></i>

                                            </button>
                                        @endif
                                    </div>

                                </td>


                            </tr>

                        @empty


                            <tr>

                                <td colspan="5" class="text-center text-muted py-5">


                                    <i class="fas fa-book fa-3x mb-3 d-block"></i>


                                    <h5>

                                        Belum Ada Program

                                    </h5>


                                    <p class="mb-3">

                                        Belum ada program yang ditambahkan
                                        pada {{ $wave->name }}.

                                    </p>


                                    <a href="{{ route('waves.programs.create', $wave) }}" class="btn btn-primary">

                                        <i class="fas fa-plus mr-1"></i>

                                        Tambah Program

                                    </a>


                                </td>

                            </tr>
                        @endforelse


                    </tbody>


                </table>

            </div>

        </div>


        {{-- FOOTER --}}

        @if ($wavePrograms->count() > 0)
            <div class="card-footer text-muted">

                <i class="fas fa-info-circle mr-1"></i>

                Menampilkan
                <strong>{{ $wavePrograms->count() }}</strong>
                program pada
                <strong>{{ $wave->name }}</strong>.

            </div>
        @endif


    </div>


@stop
