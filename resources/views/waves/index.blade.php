@extends('adminlte::page')

@section('title', 'Gelombang')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-layer-group mr-2"></i>
                Data Gelombang
            </h1>

            <p class="text-muted mb-0">
                Kelola data gelombang pelatihan LPK Mirai Gresik.
            </p>
        </div>

    </div>

@stop


@section('content')

    {{-- =========================================================
        CARD DATA GELOMBANG
    ========================================================== --}}

    <x-adminlte-card title="Daftar Gelombang" theme="primary" icon="fas fa-layer-group" collapsible>

        {{-- HEADER CARD --}}

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-1">

                    <strong>
                        Data Gelombang
                    </strong>

                </h5>

                <small class="text-muted">

                    Menampilkan
                    <strong>
                        {{ $waves->total() }}
                    </strong>
                    data gelombang

                </small>

            </div>


            <div>

                <a href="{{ route('waves.create') }}" class="btn btn-primary">

                    <i class="fas fa-plus mr-1"></i>

                    Tambah Gelombang

                </a>

            </div>

        </div>


        {{-- TABEL --}}

        <div class="table-responsive">

            <table class="table table-bordered table-hover table-striped mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60" class="text-center">
                            No
                        </th>

                        <th width="120">
                            Kode
                        </th>

                        <th>
                            Gelombang
                        </th>

                        <th width="100" class="text-center">
                            Tahun
                        </th>

                        <th width="110" class="text-center">
                            Status
                        </th>

                        <th width="260" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($waves as $wave)
                        <tr>

                            {{-- NO --}}

                            <td class="text-center">

                                {{ $waves->firstItem() + $loop->index }}

                            </td>


                            {{-- KODE --}}

                            <td>

                                <span class="font-weight-bold">

                                    {{ $wave->code }}

                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td>

                                <strong>

                                    {{ $wave->name }}

                                </strong>

                            </td>


                            {{-- TAHUN --}}

                            <td class="text-center">

                                {{ $wave->year }}

                            </td>


                            {{-- STATUS --}}

                            <td class="text-center">

                                @if ($wave->is_active)
                                    <span class="badge badge-success px-2 py-1">

                                        <i class="fas fa-check-circle mr-1"></i>

                                        Aktif

                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">

                                        <i class="fas fa-times-circle mr-1"></i>

                                        Nonaktif

                                    </span>
                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="text-center">

                                <div class="btn-group">

                                    {{-- DETAIL --}}

                                    <a href="{{ route('waves.show', $wave) }}" class="btn btn-info btn-sm" title="Detail">

                                        <i class="fas fa-eye mr-1"></i>

                                        

                                    </a>


                                    {{-- PROGRAM --}}

                                    <a href="{{ route('waves.programs.index', $wave) }}" class="btn btn-primary btn-sm"
                                        title="Program">

                                        <i class="fas fa-book mr-1"></i>

                                        

                                    </a>


                                    {{-- EDIT --}}

                                    <a href="{{ route('waves.edit', $wave) }}" class="btn btn-warning btn-sm"
                                        title="Edit">

                                        <i class="fas fa-edit mr-1"></i>

                                        

                                    </a>


                                    {{-- HAPUS --}}

                                    @if ($wave->classrooms_count == 0)
                                        <form action="{{ route('waves.destroy', $wave) }}" method="POST" class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus gelombang ini?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Gelombang sudah memiliki kelas">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-4">

                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>

                                <div class="text-muted">

                                    Belum ada data gelombang.

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- FOOTER / PAGINATION --}}

        @if ($waves->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">

                <div class="text-muted small">

                    Menampilkan

                    <strong>
                        {{ $waves->firstItem() }}
                    </strong>

                    sampai

                    <strong>
                        {{ $waves->lastItem() }}
                    </strong>

                    dari

                    <strong>
                        {{ $waves->total() }}
                    </strong>

                    data

                </div>


                <div>

                    {{ $waves->links() }}

                </div>

            </div>
        @endif

    </x-adminlte-card>

@stop
