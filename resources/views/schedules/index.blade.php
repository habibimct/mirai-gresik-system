@extends('adminlte::page')

@section('title', 'Jadwal')

@section('content_header')

    <div class="d-flex justify-content-between">

        <h1>Jadwal</h1>

        <a href="{{ route('schedules.create') }}" class="btn btn-primary">

            <i class="fas fa-plus"></i>

            Tambah Jadwal

        </a>

    </div>

@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <div class="card">

        <div class="card-body table-responsive p-0">

            <table class="table table-hover table-bordered">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Kelas</th>

                        <th>Hari</th>

                        <th>Jam</th>

                        <th>Materi</th>

                        <th>Ruangan</th>

                        <th>Status</th>

                        <th width="170">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($schedules as $schedule)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                {{ $schedule->classroom->name }}

                                <br>

                                <small>

                                    {{ $schedule->classroom->waveProgram->wave->name }}

                                    -

                                    {{ $schedule->classroom->waveProgram->program->name }}

                                </small>

                            </td>

                            <td>{{ $schedule->day }}</td>

                            <td>

                                {{ substr($schedule->start_time, 0, 5) }}

                                -

                                {{ substr($schedule->end_time, 0, 5) }}

                            </td>

                            <td>{{ $schedule->subject }}</td>

                            <td>{{ $schedule->room }}</td>

                            <td>

                                @if ($schedule->is_active)
                                    <span class="badge badge-success">

                                        Aktif

                                    </span>
                                @else
                                    <span class="badge badge-danger">

                                        Nonaktif

                                    </span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-info btn-sm">

                                    Detail

                                </a>

                                <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                Belum ada jadwal.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{ $schedules->links() }}

@stop
