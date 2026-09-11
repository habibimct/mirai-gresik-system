@foreach ($classroom->attendanceSessions as $session)
    <div class="modal fade" id="editAttendance{{ $session->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editAttendanceLabel{{ $session->id }}" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

            <form action="{{ route('classrooms.attendance.update', [$classroom, $session]) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="modal-content border-0 shadow">

                    {{-- Header --}}
                    <div class="modal-header bg-warning">

                        <h5 class="modal-title font-weight-bold" id="editAttendanceLabel{{ $session->id }}">

                            <i class="fas fa-user-edit mr-2"></i>
                            Edit Absensi

                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    {{-- Body --}}
                    <div class="modal-body p-4">

                        {{-- Info --}}
                        <div class="alert alert-light border mb-4">

                            <div class="d-flex">

                                <div class="mr-3 text-warning">

                                    <i class="fas fa-info-circle fa-lg"></i>

                                </div>

                                <div>

                                    <strong>Edit Data Absensi</strong>

                                    <div class="small text-muted mt-1">

                                        Perbarui jadwal atau status
                                        kehadiran peserta pada sesi pembelajaran ini.

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Tanggal & Jadwal --}}
                        <div class="row">

                            {{-- Jadwal --}}
                            <div class="form-group">

                                <label for="schedule_id{{ $session->id }}" class="font-weight-bold">

                                    <i class="fas fa-calendar-check text-warning mr-1"></i>
                                    Jadwal

                                </label>

                                <select name="schedule_id" id="schedule_id{{ $session->id }}" class="form-control"
                                    required>

                                    <option value="">
                                        -- Pilih Jadwal --
                                    </option>

                                    @foreach ($classroom->schedules as $schedule)
                                        <option value="{{ $schedule->id }}"
                                            {{ $schedule->id == $session->schedule_id ? 'selected' : '' }}>

                                            {{ $schedule->schedule_date?->format('d-m-Y') }}
                                            |
                                            {{ $schedule->day }}
                                            |
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                            |
                                            {{ $schedule->subject }}

                                        </option>
                                    @endforeach

                                </select>

                                <small class="form-text text-muted">
                                    Tanggal absensi mengikuti tanggal jadwal yang dipilih.
                                </small>

                            </div>

                        </div>

                        <hr>

                        {{-- Header Peserta --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>

                                <h6 class="font-weight-bold mb-1">

                                    <i class="fas fa-users text-warning mr-1"></i>
                                    Daftar Kehadiran

                                </h6>

                                <small class="text-muted">
                                    Periksa dan ubah status kehadiran peserta jika diperlukan.
                                </small>

                            </div>

                            <span class="badge badge-warning px-3 py-2">

                                {{ $session->attendances->count() }}
                                Peserta

                            </span>

                        </div>

                        {{-- Tabel Peserta --}}
                        <div class="table-responsive">

                            <table class="table table-bordered table-hover mb-0">

                                <thead class="thead-light">

                                    <tr>

                                        <th width="60" class="text-center">
                                            No.
                                        </th>

                                        <th>
                                            Peserta
                                        </th>

                                        <th width="180" class="text-center">
                                            Status
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($session->attendances as $index => $attendance)
                                        <tr>

                                            <td class="text-center align-middle">

                                                {{ $index + 1 }}

                                            </td>

                                            <td class="align-middle">

                                                <div class="font-weight-bold">

                                                    {{ $attendance->participantClassroom->participantWaveProgram->participant->user->name }}

                                                </div>

                                            </td>

                                            <td class="align-middle">

                                                <select name="status[{{ $attendance->id }}]"
                                                    class="form-control form-control-sm">

                                                    @foreach (['Hadir', 'Izin', 'Sakit', 'Alpha'] as $status)
                                                        <option value="{{ $status }}"
                                                            {{ $attendance->status == $status ? 'selected' : '' }}>

                                                            {{ $status }}

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="3" class="text-center text-muted py-4">

                                                <i class="fas fa-users-slash fa-2x mb-2"></i>

                                                <div>
                                                    Tidak ada data kehadiran peserta.
                                                </div>

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer bg-light">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">

                            <i class="fas fa-times mr-1"></i>
                            Batal

                        </button>

                        <button type="submit" class="btn btn-warning">

                            <i class="fas fa-save mr-1"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
@endforeach
