<div class="card shadow-sm">

    {{-- Card Header --}}
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-2">
                <i class="fas fa-chart-line mr-2"></i>
                Penilaian
            </h3>

            <div class="card-tools mb-2">

                {{-- Komponen Penilaian --}}
                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal"
                    data-target="#scoreTypeModal">

                    <i class="fas fa-list mr-1"></i>
                    Komponen Penilaian

                </button>

                {{-- Tambah Penilaian --}}
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#createScoreSession">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Penilaian

                </button>

            </div>
        </div>
    </div>


    {{-- Card Body --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60" class="text-center">
                            No
                        </th>

                        <th width="100" class="text-center">
                            Minggu
                        </th>

                        <th width="130" class="text-center">
                            Tanggal
                        </th>

                        <th class="text-center">
                            Judul Penilaian
                        </th>

                        <th class="text-center">
                            Komponen
                        </th>

                        <th width="100" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($classroom->scoreSessions as $session)

                        <tr>

                            {{-- No --}}
                            <td class="text-center align-middle">

                                {{ $loop->iteration }}

                            </td>


                            {{-- Minggu --}}
                            <td class="text-center align-middle">

                                <span class="badge badge-primary">
                                    Minggu {{ $session->week }}
                                </span>

                            </td>


                            {{-- Tanggal --}}
                            <td class="text-center align-middle">

                                <i class="far fa-calendar-alt text-muted mr-1"></i>

                                {{ $session->assessment_date->format('d-m-Y') }}

                            </td>


                            {{-- Judul --}}
                            <td class="align-middle">

                                <strong>
                                    {{ $session->title }}
                                </strong>

                            </td>


                            {{-- Komponen --}}
                            <td class="align-middle">

                                @forelse ($session->sessionTypes as $type)
                                    <span class="badge badge-info mr-1 mb-1">

                                        <i class="fas fa-tag mr-1"></i>

                                        {{ $type->type->name }}

                                    </span>

                                @empty

                                    <span class="text-muted">
                                        <i class="fas fa-minus-circle mr-1"></i>
                                        Belum ada komponen
                                    </span>
                                @endforelse

                            </td>


                            {{-- Aksi --}}
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    {{-- Input / Detail Nilai --}}
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#scoreInput{{ $session->id }}" title="Input Nilai">

                                        <i class="fas fa-edit"></i>

                                    </button>


                                    {{-- Hapus --}}
                                    @if ($session->created_at->diffInHours(now()) < 12)
                                        <form
                                            action="{{ route('classrooms.scores.destroy', [$classroom, $session]) }}"
                                            method="POST" class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus penilaian ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Penilaian tidak dapat dihapus setelah 12 jam">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-4">

                                <div class="text-muted">

                                    <i class="fas fa-chart-line fa-2x mb-2"></i>

                                    <p class="mb-1">
                                        Belum ada penilaian.
                                    </p>

                                    <small>
                                        Silakan tambahkan sesi penilaian untuk kelas ini.
                                    </small>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- Footer --}}
    @if ($classroom->scoreSessions->count() > 0)
        <div class="card-footer text-muted">

            <i class="fas fa-info-circle mr-1"></i>

            Total
            <strong>{{ $classroom->scoreSessions->count() }}</strong>
            sesi penilaian.

        </div>
    @endif

</div>


{{-- Modal Input Nilai --}}
@foreach ($classroom->scoreSessions as $session)
    @include('classrooms.partials.score-input-modal')
@endforeach


{{-- Modal Tambah Sesi Penilaian --}}
@include('classrooms.partials.score-session-create-modal')


{{-- Modal Komponen Penilaian --}}
@include('classrooms.partials.score-type-modal')
