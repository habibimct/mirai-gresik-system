<div class="modal fade" id="createAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="createAttendanceModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <form action="{{ route('classrooms.attendance.store', $classroom) }}" method="POST">

            @csrf

            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title font-weight-bold" id="createAttendanceModalLabel">

                        <i class="fas fa-user-check mr-2"></i>
                        Tambah Absensi

                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body p-4">

                    {{-- Info --}}
                    <div class="alert alert-light border mb-4">

                        <div class="d-flex">

                            <div class="mr-3 text-success">
                                <i class="fas fa-info-circle fa-lg"></i>
                            </div>

                            <div>

                                <strong>Absensi Pembelajaran</strong>

                                <div class="small text-muted mt-1">
                                    Tentukan tanggal dan jadwal pembelajaran,
                                    kemudian tentukan status kehadiran setiap peserta.
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Jadwal --}}
                    <div class="row">

                        {{-- Jadwal --}}
                        <div class="col-md-7">

                            <div class="form-group">

                                <label for="schedule_id" class="font-weight-bold">

                                    <i class="fas fa-clock text-success mr-1"></i>
                                    Jadwal

                                </label>

                                <select name="schedule_id" id="schedule_id" class="form-control" required>

                                    <option value="">
                                        -- Pilih Jadwal --
                                    </option>

                                    @foreach ($classroom->schedules as $schedule)
                                        <option value="{{ $schedule->id }}">

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

                            </div>

                        </div>

                    </div>

                    <hr>

                    {{-- Header Peserta --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <h6 class="font-weight-bold mb-1">

                                <i class="fas fa-users text-success mr-1"></i>
                                Daftar Peserta

                            </h6>

                            <small class="text-muted">
                                Tentukan status kehadiran masing-masing peserta.
                            </small>

                        </div>

                        <span class="badge badge-success px-3 py-2">

                            {{ $classroom->participantClassrooms->count() }}
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

                                @forelse ($classroom->participantClassrooms as $index => $item)
                                    <tr>

                                        <td class="text-center align-middle">

                                            {{ $index + 1 }}

                                        </td>

                                        <td class="align-middle">

                                            <div class="font-weight-bold">

                                                {{ $item->participantWaveProgram->participant->user->name }}

                                            </div>

                                        </td>

                                        <td class="align-middle">

                                            <select name="status[{{ $item->id }}]"
                                                class="form-control form-control-sm">

                                                <option value="Hadir">
                                                    Hadir
                                                </option>

                                                <option value="Izin">
                                                    Izin
                                                </option>

                                                <option value="Sakit">
                                                    Sakit
                                                </option>

                                                <option value="Alpha">
                                                    Alpha
                                                </option>

                                            </select>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="text-center text-muted py-4">

                                            <i class="fas fa-users-slash fa-2x mb-2"></i>

                                            <div>
                                                Belum ada peserta di kelas ini.
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

                    <button type="submit" class="btn btn-success">

                        <i class="fas fa-save mr-1"></i>
                        Simpan Absensi

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
