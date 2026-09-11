@extends('adminlte::page')

@section('title', 'Data Kelas')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">Data Kelas</h1>
            <small class="text-muted">
                Pengelolaan kelas pelatihan peserta
            </small>
        </div>

        <a href="{{ route('classrooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>
            Tambah Kelas
        </a>

    </div>

@stop


@section('content')

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

        </div>
    @endif


    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-exclamation-circle mr-1"></i>

            {{ session('error') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

        </div>
    @endif


    {{-- RINGKASAN --}}
    <div class="row">

        {{-- Total Kelas --}}
        <div class="col-lg-3 col-md-6">

            <x-adminlte-small-box title="{{ $classrooms->total() }}" text="Total Kelas" theme="primary"
                icon="fas fa-door-open" />

        </div>

        {{-- Total Peserta --}}
        <div class="col-lg-3 col-md-6">

            <x-adminlte-small-box title="{{ $classrooms->sum('participant_classrooms_count') }}" text="Peserta"
                theme="info" icon="fas fa-users" />

        </div>

    </div>


    {{-- DATA KELAS --}}
    <x-adminlte-card title="Daftar Kelas" theme="primary" icon="fas fa-door-open" body-class="p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover table-striped mb-0">

                <thead class="text-center">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th width="80">
                            Kode
                        </th>

                        <th>
                            Kelas
                        </th>

                        <th>
                            Program
                        </th>

                        <th>
                            Gelombang
                        </th>

                        <th width="90">
                            Kapasitas
                        </th>

                        <th width="90">
                            Terisi
                        </th>

                        <th width="100">
                            Sisa Kuota
                        </th>

                        <th>
                            Ruangan
                        </th>

                        <th width="100">
                            Status
                        </th>

                        <th width="140">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($classrooms as $classroom)
                        @php

                            $terisi = $classroom->participant_classrooms_count;

                            $sisa = max(0, $classroom->capacity - $terisi);

                            $persentase = $classroom->capacity > 0 ? ($terisi / $classroom->capacity) * 100 : 0;

                        @endphp


                        <tr>

                            {{-- NO --}}
                            <td class="text-center">

                                {{ $classrooms->firstItem() + $loop->index }}

                            </td>


                            {{-- KODE --}}
                            <td class="text-center">

                                <span class="badge badge-secondary">
                                    {{ $classroom->code }}
                                </span>

                            </td>


                            {{-- NAMA KELAS --}}
                            <td>

                                <strong>
                                    {{ $classroom->name }}
                                </strong>

                            </td>


                            {{-- PROGRAM --}}
                            <td>

                                {{ $classroom->waveProgram->program->name ?? '-' }}

                            </td>


                            {{-- GELOMBANG --}}
                            <td>

                                {{ $classroom->waveProgram->wave->name ?? '-' }}

                            </td>


                            {{-- KAPASITAS --}}
                            <td class="text-center">

                                {{ $classroom->capacity }}

                            </td>


                            {{-- TERISI --}}
                            <td class="text-center">

                                <span class="badge badge-info">

                                    {{ $terisi }}

                                </span>

                            </td>


                            {{-- SISA KUOTA --}}
                            <td class="text-center">

                                @if ($sisa <= 0)
                                    <span class="badge badge-danger">
                                        Penuh
                                    </span>
                                @elseif ($sisa <= 3)
                                    <span class="badge badge-warning">
                                        {{ $sisa }}
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        {{ $sisa }}
                                    </span>
                                @endif

                            </td>


                            {{-- RUANGAN --}}
                            <td class="text-center">

                                {{ $classroom->room ?? '-' }}

                            </td>


                            {{-- STATUS --}}
                            <td class="text-center">

                                @if ($classroom->is_active)
                                    <span class="badge badge-success">

                                        <i class="fas fa-check mr-1"></i>
                                        Aktif

                                    </span>
                                @else
                                    <span class="badge badge-danger">

                                        <i class="fas fa-times mr-1"></i>
                                        Nonaktif

                                    </span>
                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="text-center">

                                <div class="btn-group">

                                    {{-- Peserta --}}
                                    <a href="{{ route('classrooms.show', $classroom) }}" class="btn btn-info btn-sm"
                                        title="Peserta">

                                        <i class="fas fa-users"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-warning btn-sm"
                                        title="Edit">

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    {{-- Hapus --}}
                                    @if ($classroom->participant_classrooms_count == 0)
                                        <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus kelas ini?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Kelas sudah memiliki peserta">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="11" class="text-center py-4 text-muted">

                                <i class="fas fa-door-open fa-2x mb-2"></i>

                                <br>

                                Belum ada data kelas.

                                <br>

                                <a href="{{ route('classrooms.create') }}" class="btn btn-primary btn-sm mt-2">

                                    <i class="fas fa-plus mr-1"></i>
                                    Tambah Kelas

                                </a>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if ($classrooms->hasPages())
            <div class="card-footer">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div class="text-muted mb-2 mb-md-0">

                        Menampilkan
                        <strong>{{ $classrooms->firstItem() }}</strong>
                        -
                        <strong>{{ $classrooms->lastItem() }}</strong>
                        dari
                        <strong>{{ $classrooms->total() }}</strong>
                        kelas

                    </div>

                    <div>

                        {{ $classrooms->links() }}

                    </div>

                </div>

            </div>
        @endif

    </x-adminlte-card>

@stop
