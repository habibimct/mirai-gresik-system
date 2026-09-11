@extends('adminlte::page')

@section('title', 'Edit Jadwal')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Edit Jadwal</h1>

    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

</div>

@stop

@section('content')

<div class="card">

    <form action="{{ route('schedules.update', $schedule) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            {{-- Kelas --}}
            <div class="form-group">

                <label>Kelas</label>

                <select name="classroom_id" class="form-control" required>

                    <option value="">-- Pilih Kelas --</option>

                    @foreach($classrooms as $classroom)

                        <option
                            value="{{ $classroom->id }}"
                            {{ old('classroom_id', $schedule->classroom_id) == $classroom->id ? 'selected' : '' }}>

                            {{ $classroom->name }}
                            -
                            {{ $classroom->waveProgram->wave->name }}
                            -
                            {{ $classroom->waveProgram->program->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Materi --}}
            <div class="form-group">

                <label>Materi</label>

                <input
                    type="text"
                    name="subject"
                    class="form-control"
                    value="{{ old('subject', $schedule->subject) }}"
                    required>

            </div>

            <div class="row">

                {{-- Hari --}}
                <div class="col-md-4">

                    <div class="form-group">

                        <label>Hari</label>

                        <select name="day" class="form-control">

                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)

                                <option
                                    value="{{ $day }}"
                                    {{ old('day', $schedule->day) == $day ? 'selected' : '' }}>

                                    {{ $day }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- Jam Mulai --}}
                <div class="col-md-4">

                    <div class="form-group">

                        <label>Jam Mulai</label>

                        <input
                            type="time"
                            name="start_time"
                            class="form-control"
                            value="{{ old('start_time', substr($schedule->start_time,0,5)) }}"
                            required>

                    </div>

                </div>

                {{-- Jam Selesai --}}
                <div class="col-md-4">

                    <div class="form-group">

                        <label>Jam Selesai</label>

                        <input
                            type="time"
                            name="end_time"
                            class="form-control"
                            value="{{ old('end_time', substr($schedule->end_time,0,5)) }}"
                            required>

                    </div>

                </div>

            </div>

            {{-- Ruangan --}}
            <div class="form-group">

                <label>Ruangan</label>

                <input
                    type="text"
                    name="room"
                    class="form-control"
                    value="{{ old('room', $schedule->room) }}">

            </div>

            {{-- Keterangan --}}
            <div class="form-group">

                <label>Keterangan</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4">{{ old('description', $schedule->description) }}</textarea>

            </div>

            {{-- Status --}}
            <div class="form-group">

                <label>Status</label>

                <select name="is_active" class="form-control">

                    <option
                        value="1"
                        {{ old('is_active', $schedule->is_active) == 1 ? 'selected' : '' }}>

                        Aktif

                    </option>

                    <option
                        value="0"
                        {{ old('is_active', $schedule->is_active) == 0 ? 'selected' : '' }}>

                        Nonaktif

                    </option>

                </select>

            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-primary">

                <i class="fas fa-save"></i>

                Simpan Perubahan

            </button>

            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">

                Batal

            </a>

        </div>

    </form>

</div>

@stop