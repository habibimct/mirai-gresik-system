@extends('adminlte::page')

@section('title', 'Rekap Nilai')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-chart-line text-primary mr-2"></i>
                Rekap Nilai
            </h1>

            <p class="text-muted mb-0">
                Rekapitulasi penilaian peserta berdasarkan kelas.
            </p>
        </div>

    </div>

@stop


@section('content')


    {{-- Statistik --}}
    <div class="row">

        {{-- Total Kelas --}}
        <div class="col-lg-4 col-md-6">

            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>
                        {{ $classrooms->count() }}
                    </h3>

                    <p>
                        Total Kelas
                    </p>

                </div>

                <div class="icon">
                    <i class="fas fa-school"></i>
                </div>

            </div>

        </div>


        {{-- Total Peserta --}}
        <div class="col-lg-4 col-md-6">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>
                        {{ $classrooms->sum(fn($classroom) => $classroom->participantClassrooms->count()) }}
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

    </div>



    {{-- Daftar Kelas --}}
    <div class="card card-primary card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-list mr-1"></i>

                Daftar Kelas

            </h3>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="60" class="text-center">
                                No
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

                            <th width="120" class="text-center">
                                Peserta
                            </th>

                            <th width="100" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($classrooms as $classroom)

                            <tr>

                                {{-- No --}}
                                <td class="text-center align-middle">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- Kelas --}}
                                <td class="align-middle">

                                    <strong>
                                        {{ $classroom->name }}
                                    </strong>

                                    @if(isset($classroom->code))

                                        <br>

                                        <small class="text-muted">
                                            {{ $classroom->code }}
                                        </small>

                                    @endif

                                </td>


                                {{-- Program --}}
                                <td class="align-middle">

                                    <span class="badge badge-primary">

                                        <i class="fas fa-book mr-1"></i>

                                        {{ $classroom->waveProgram->program->name }}

                                    </span>

                                </td>


                                {{-- Gelombang --}}
                                <td class="align-middle">

                                    <span class="badge badge-secondary">

                                        <i class="fas fa-layer-group mr-1"></i>

                                        {{ $classroom->waveProgram->wave->name }}

                                    </span>

                                </td>


                                {{-- Peserta --}}
                                <td class="text-center align-middle">

                                    <span class="badge badge-success px-3 py-2">

                                        <i class="fas fa-users mr-1"></i>

                                        {{ $classroom->participantClassrooms->count() }}

                                    </span>

                                </td>


                                {{-- Aksi --}}
                                <td class="text-center align-middle">

                                    <a href="{{ route('score-recaps.show', $classroom) }}"
                                        class="btn btn-info btn-sm"
                                        title="Lihat Rekap Nilai">

                                        <i class="fas fa-chart-bar mr-1"></i>
                                       
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="fas fa-folder-open fa-2x mb-3"></i>

                                    <div>
                                        Belum ada kelas.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Footer --}}
        @if($classrooms->count() > 0)

            <div class="card-footer text-muted">

                <i class="fas fa-info-circle mr-1"></i>

                Klik tombol <strong>Lihat</strong> untuk melihat
                rekap nilai peserta pada masing-masing kelas.

            </div>

        @endif

    </div>


@stop