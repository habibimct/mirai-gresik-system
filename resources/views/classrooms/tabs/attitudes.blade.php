{{-- ========================================================= --}}
{{-- NILAI SIKAP --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h5 class="mb-1">
            <i class="fas fa-user-check mr-1"></i>
            Penilaian Sikap
        </h5>

        <small class="text-muted">
            Penilaian sikap peserta kelas
        </small>
    </div>

    <div>
        <button type="button" class="btn btn-info mr-1" data-toggle="modal" data-target="#attitudeTypeModal">

            <i class="fas fa-list mr-1"></i>
            Komponen Sikap

        </button>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAttitudeSession">

            <i class="fas fa-plus mr-1"></i>
            Penilaian Sikap

        </button>
    </div>

</div>

<div class="table-responsive">

    <table class="table table-bordered table-hover">

        <thead class="thead-light">

            <tr>
                <th width="60" class="text-center">No</th>
                <th width="100">Minggu</th>
                <th width="130">Tanggal</th>
                <th>Judul Penilaian</th>
                <th>Komponen</th>
                <th width="120" class="text-center">Aksi</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($classroom->attitudeSessions as $session)

                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        Minggu {{ $session->week }}
                    </td>

                    <td>
                        {{ $session->assessment_date->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $session->title }}
                    </td>

                    <td>
                        @foreach ($session->sessionTypes as $sessionType)
                            <span class="badge badge-info mr-1 mb-1">
                                {{ $sessionType->type->name }}
                            </span>
                        @endforeach
                    </td>

                    <td class="text-center">

                        @php
                            $participantCount = $classroom->participantClassrooms->count();
                            $componentCount = $session->sessionTypes->count();

                            $expectedScoreCount = $participantCount * $componentCount;
                            $actualScoreCount = $session->scores->count();
                        @endphp

                        @if ($actualScoreCount === 0)
                            <span class="badge badge-secondary mr-1">
                                <i class="fas fa-clock mr-1"></i>
                                Belum Dinilai
                            </span>
                        @elseif ($actualScoreCount < $expectedScoreCount)
                            <span class="badge badge-warning mr-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Belum Lengkap
                                ({{ $actualScoreCount }}/{{ $expectedScoreCount }})
                            </span>
                        @else
                            <span class="badge badge-success mr-1">
                                <i class="fas fa-check mr-1"></i>
                                Sudah Dinilai
                            </span>
                        @endif

                        <button type="button" class="btn btn-sm btn-primary" title="Input / Edit Nilai"
                            data-toggle="modal" data-target="#attitudeScoreModal{{ $session->id }}">

                            <i class="fas fa-edit"></i>

                        </button>

                        @if ($session->created_at->gte(now()->subHours(6)))
                            <form
                                action="{{ route('classrooms.attitude-sessions.destroy', [$classroom, $session]) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm(
                                    'Yakin ingin menghapus penilaian sikap ini? Semua nilai pada sesi ini juga akan dihapus.'
                                );">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Penilaian">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Belum ada penilaian sikap.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>




@include('classrooms.partials.attitude-type-modal')
@include('classrooms.partials.attitude-session-create-modal')
@include('classrooms.partials.attitude-score-modal')
