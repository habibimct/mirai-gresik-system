{{-- =========================================================
     RIWAYAT ABSENSI
========================================================= --}}

<div class="card card-primary">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h3 class="card-title mb-0">

                    <i class="fas fa-user-check mr-2"></i>

                    Riwayat Absensi

                </h3>
            </div>

            <div class="card-tools">

                <span class="badge badge-light mr-2">

                    {{ $classroom->attendanceSessions->count() }}
                    Pertemuan

                </span>

                <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                    data-target="#createAttendanceModal">

                    <i class="fas fa-plus mr-1"></i>

                    Tambah Absensi

                </button>

            </div>

        </div>

    </div>


    <div class="card-body">

        {{-- PESAN SUKSES --}}

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

                <i class="fas fa-check-circle mr-1"></i>

                {{ session('success') }}

            </div>
        @endif


        {{-- PESAN ERROR --}}

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

                <i class="fas fa-exclamation-circle mr-1"></i>

                {{ session('error') }}

            </div>
        @endif


        {{-- TABEL ABSENSI --}}

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="text-center">

                    <tr>

                        <th width="55">
                            No
                        </th>

                        <th width="110">
                            Tanggal
                        </th>

                        <th>
                            Materi
                        </th>

                        <th width="75">
                            Hadir
                        </th>

                        <th width="75">
                            Izin
                        </th>

                        <th width="75">
                            Sakit
                        </th>

                        <th width="75">
                            Alpha
                        </th>

                        <th width="80">
                            Total
                        </th>

                        <th width="125">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($classroom->attendanceSessions
                            ->sortByDesc('attendance_date')
                        as $session)
                        @php

                            $hadir = $session->attendances->where('status', 'Hadir')->count();

                            $izin = $session->attendances->where('status', 'Izin')->count();

                            $sakit = $session->attendances->where('status', 'Sakit')->count();

                            $alpha = $session->attendances->where('status', 'Alpha')->count();

                            $total = $session->attendances->count();

                        @endphp


                        <tr>

                            {{-- NO --}}

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>


                            {{-- TANGGAL --}}

                            <td class="text-center">

                                <strong>

                                    {{ \Carbon\Carbon::parse($session->attendance_date)->format('d-m-Y') }}

                                </strong>

                            </td>


                            {{-- MATERI --}}

                            <td>

                                <strong>

                                    {{ $session->schedule->subject ?? '-' }}

                                </strong>

                                @if ($session->schedule)
                                    <div class="small text-muted">

                                        <i class="fas fa-clock mr-1"></i>

                                        {{ \Carbon\Carbon::parse($session->schedule->start_time)->format('H:i') }}

                                        -

                                        {{ \Carbon\Carbon::parse($session->schedule->end_time)->format('H:i') }}

                                    </div>
                                @endif

                            </td>


                            {{-- HADIR --}}

                            <td class="text-center">

                                <span class="badge badge-success">

                                    {{ $hadir }}

                                </span>

                            </td>


                            {{-- IZIN --}}

                            <td class="text-center">

                                <span class="badge badge-info">

                                    {{ $izin }}

                                </span>

                            </td>


                            {{-- SAKIT --}}

                            <td class="text-center">

                                <span class="badge badge-warning">

                                    {{ $sakit }}

                                </span>

                            </td>


                            {{-- ALPHA --}}

                            <td class="text-center">

                                <span class="badge badge-danger">

                                    {{ $alpha }}

                                </span>

                            </td>


                            {{-- TOTAL --}}

                            <td class="text-center">

                                <strong>

                                    {{ $total }}

                                </strong>

                            </td>


                            {{-- AKSI --}}

                            <td class="text-center">
                                <div class="btn-group">

                                    {{-- Detail --}}

                                    <button type="button" class="btn btn-info btn-sm" title="Detail Absensi"
                                        data-toggle="modal" data-target="#detailAttendance{{ $session->id }}">

                                        <i class="fas fa-eye"></i>

                                    </button>


                                    {{-- Edit --}}

                                    <button type="button" class="btn btn-warning btn-sm" title="Edit Absensi"
                                        data-toggle="modal" data-target="#editAttendance{{ $session->id }}">

                                        <i class="fas fa-edit"></i>

                                    </button>


                                    {{-- Hapus --}}
                                    @if ($session->created_at->diffInHours(now()) < 12)
                                        <form
                                            action="{{ route('classrooms.attendance.destroy', [$classroom, $session]) }}"
                                            method="POST" class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Hapus absensi tanggal {{ \Carbon\Carbon::parse($session->attendance_date)->format('d-m-Y') }}?')">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Absensi tidak dapat dihapus setelah 12 jam">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="9" class="text-center py-4 text-muted">

                                <i class="fas fa-calendar-times fa-2x mb-2"></i>

                                <br>

                                <strong>
                                    Belum ada data absensi.
                                </strong>

                                <br>

                                <small>

                                    Silakan klik
                                    <strong>Tambah Absensi</strong>
                                    untuk membuat pertemuan baru.

                                </small>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL ABSENSI
========================================================= --}}

@include('classrooms.partials.attendance-create-modal')

@include('classrooms.partials.attendance-edit-modal')

@include('classrooms.partials.attendance-detail-modal')
