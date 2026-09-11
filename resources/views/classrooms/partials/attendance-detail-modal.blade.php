@foreach($classroom->attendanceSessions as $session)

<div class="modal fade"
    id="detailAttendance{{ $session->id }}"
    tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header bg-info">

                <h5 class="modal-title">

                    Detail Absensi

                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row mb-3">

                    <div class="col-md-4">

                        <strong>Tanggal</strong><br>

                        {{ \Carbon\Carbon::parse($session->attendance_date)->format('d-m-Y') }}

                    </div>

                    <div class="col-md-4">

                        <strong>Hari</strong><br>

                        {{ $session->schedule->day }}

                    </div>

                    <div class="col-md-4">

                        <strong>Materi</strong><br>

                        {{ $session->schedule->subject }}

                    </div>

                </div>

                @php

                    $hadir = $session->attendances->where('status','Hadir')->count();
                    $izin = $session->attendances->where('status','Izin')->count();
                    $sakit = $session->attendances->where('status','Sakit')->count();
                    $alpha = $session->attendances->where('status','Alpha')->count();

                @endphp

                <div class="row mb-3">

                    <div class="col">

                        <span class="badge badge-success p-2">
                            Hadir : {{ $hadir }}
                        </span>

                        <span class="badge badge-info p-2">
                            Izin : {{ $izin }}
                        </span>

                        <span class="badge badge-warning p-2">
                            Sakit : {{ $sakit }}
                        </span>

                        <span class="badge badge-danger p-2">
                            Alpha : {{ $alpha }}
                        </span>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="text-center">

                            <tr>

                                <th width="60">No</th>

                                <th>Nama Peserta</th>

                                <th width="150">Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($session->attendances as $attendance)

                                <tr>

                                    <td class="text-center">

                                        {{ $loop->iteration }}

                                    </td>

                                    <td>

                                        {{ $attendance->participantClassroom->participantWaveProgram->participant->user->name }}

                                    </td>

                                    <td class="text-center">

                                        @switch($attendance->status)

                                            @case('Hadir')

                                                <span class="badge badge-success">

                                                    Hadir

                                                </span>

                                            @break

                                            @case('Izin')

                                                <span class="badge badge-info">

                                                    Izin

                                                </span>

                                            @break

                                            @case('Sakit')

                                                <span class="badge badge-warning">

                                                    Sakit

                                                </span>

                                            @break

                                            @default

                                                <span class="badge badge-danger">

                                                    Alpha

                                                </span>

                                        @endswitch

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>

@endforeach