<table class="table table-bordered table-hover mb-0">

    <thead>

        <tr>

            <th width="120">Tanggal</th>

            <th width="80">Hari</th>

            <th width="150">Jam</th>

            <th>Materi</th>

            <th width="90">Status</th>

            <th width="100">Aksi</th>

        </tr>

    </thead>

    <tbody>

        @forelse($classroom->schedules as $schedule)

            <tr>

                {{-- Tanggal --}}
                <td>

                    {{ $schedule->schedule_date?->format('d-m-Y') }}

                </td>


                {{-- Hari --}}
                <td>

                    {{ $schedule->day }}

                </td>


                {{-- Jam --}}
                <td>

                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}

                    -

                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}

                </td>


                {{-- Materi --}}
                <td>

                    {{ $schedule->subject }}

                </td>


                {{-- Status --}}
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


                {{-- Aksi --}}
                <td>

                    <div class="btn-group">

                        {{-- Edit --}}
                        <button
                            class="btn btn-warning btn-sm"
                            data-toggle="modal"
                            data-target="#editSchedule{{ $schedule->id }}"
                            title="Edit">

                            <i class="fas fa-edit"></i>

                        </button>


                        {{-- Hapus --}}
                        @if ($schedule->attendance_sessions_count == 0)

                            <form
                                action="{{ route('classrooms.schedule.destroy', [$classroom, $schedule]) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus jadwal ini?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        @else

                            <button
                                type="button"
                                class="btn btn-secondary btn-sm"
                                disabled
                                title="Jadwal sudah digunakan untuk attendance">

                                <i class="fas fa-lock"></i>

                            </button>

                        @endif

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6" class="text-center">

                    Belum ada jadwal.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>