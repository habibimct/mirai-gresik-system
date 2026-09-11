@extends('adminlte::page')

@section('title', 'Detail Jadwal')

@section('content_header')

    <h1>Detail Jadwal</h1>

@stop

@section('content')

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="220">

                        Kelas

                    </th>

                    <td>

                        {{ $schedule->classroom->name }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Gelombang

                    </th>

                    <td>

                        {{ $schedule->classroom->waveProgram->wave->name }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Program

                    </th>

                    <td>

                        {{ $schedule->classroom->waveProgram->program->name }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Materi

                    </th>

                    <td>

                        {{ $schedule->subject }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Hari

                    </th>

                    <td>

                        {{ $schedule->day }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Jam

                    </th>

                    <td>

                        {{ substr($schedule->start_time, 0, 5) }}

                        -

                        {{ substr($schedule->end_time, 0, 5) }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Ruangan

                    </th>

                    <td>

                        {{ $schedule->room }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Keterangan

                    </th>

                    <td>

                        {{ $schedule->description }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Status

                    </th>

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

                </tr>

            </table>

        </div>

        <div class="card-footer">

            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">

                Kembali

            </a>

            <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warning">

                Edit

            </a>

        </div>

    </div>

@stop
