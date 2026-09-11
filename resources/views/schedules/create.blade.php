@extends('adminlte::page')

@section('title', 'Tambah Jadwal')

@section('content_header')

    <h1>Tambah Jadwal</h1>

@stop

@section('content')

    <div class="card">

        <form method="POST" action="{{ route('schedules.store') }}">

            @csrf

            <div class="card-body">

                <div class="form-group">

                    <label>Kelas</label>

                    <select name="classroom_id" class="form-control" required>

                        <option value="">-- Pilih --</option>

                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">

                                {{ $classroom->name }}

                                -

                                {{ $classroom->waveProgram->wave->name }}

                                -

                                {{ $classroom->waveProgram->program->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Materi</label>

                    <input type="text" name="subject" class="form-control" required>

                </div>

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Hari</label>

                            <select name="day" class="form-control">

                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Jam Mulai</label>

                            <input type="time" name="start_time" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Jam Selesai</label>

                            <input type="time" name="end_time" class="form-control">

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label>Ruangan</label>

                    <input type="text" name="room" class="form-control">

                </div>

                <div class="form-group">

                    <label>Keterangan</label>

                    <textarea name="description" class="form-control"></textarea>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select name="is_active" class="form-control">

                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>

                    </select>

                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-primary">

                    Simpan

                </button>

                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </form>

    </div>

@stop
