{{-- =========================================================
     TAB PESERTA KELAS
========================================================= --}}

@php
    $jumlahPeserta = $classroom->participantClassrooms->count();
    $kapasitas = $classroom->capacity;
    $sisaKuota = max($kapasitas - $jumlahPeserta, 0);
@endphp


{{-- =========================================================
     PESERTA YANG SUDAH MASUK KELAS
========================================================= --}}

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-users mr-1"></i>

            Peserta Kelas

        </h3>

        <div class="card-tools">

            <span class="badge badge-primary">

                {{ $jumlahPeserta }} Peserta

            </span>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="text-center">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama Peserta
                        </th>

                        <th width="180">
                            Status
                        </th>

                        <th width="120">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($classroom->participantClassrooms as $item)
                        <tr>

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>


                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="mr-2">

                                        <span
                                            class="d-inline-flex align-items-center justify-content-center
                                            bg-primary text-white rounded-circle"
                                            style="width: 35px; height: 35px;">

                                            <i class="fas fa-user"></i>

                                        </span>

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $item->participantWaveProgram->participant->user->name }}
                                        </strong>

                                    </div>

                                </div>

                            </td>


                            <td class="text-center">

                                @if ($item->status == 'Aktif')
                                    <span class="badge badge-success">
                                        {{ $item->status }}
                                    </span>
                                @elseif ($item->status == 'Lulus')
                                    <span class="badge badge-primary">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        {{ $item->status }}
                                    </span>
                                @endif

                            </td>


                            <td class="text-center">

                                @if ($item->attendances->isEmpty())
                                    <form action="{{ route('classrooms.removeParticipant', [$classroom, $item]) }}"
                                        method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" title="Keluarkan peserta"
                                            onclick="return confirm('Yakin ingin mengeluarkan peserta ini dari kelas?')">

                                            <i class="fas fa-user-minus"></i>

                                        </button>

                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm" disabled
                                        title="Peserta sudah memiliki data attendance">

                                        <i class="fas fa-lock"></i>

                                    </button>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center py-4">

                                <i class="fas fa-users-slash fa-2x text-muted mb-2"></i>

                                <div class="text-muted">

                                    Belum ada peserta di kelas ini.

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- =========================================================
     TAMBAHKAN PESERTA
========================================================= --}}

@if ($sisaKuota > 0)

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-plus mr-1"></i>

                Tambahkan Peserta

            </h3>

            <div class="card-tools">

                <span class="text-muted">

                    Sisa kuota:
                    <strong>{{ $sisaKuota }}</strong>

                </span>

            </div>

        </div>


        <form id="assignParticipantsForm" action="{{ route('classrooms.assignParticipants', $classroom) }}"
            method="POST">

            @csrf


            <div class="card-body p-0">

                @if ($participants->count())

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead class="text-center">

                                <tr>

                                    <th width="60">

                                        <input type="checkbox" id="checkAll">

                                    </th>

                                    <th>
                                        Nama Peserta
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($participants as $item)
                                    <tr>

                                        <td class="text-center">

                                            <input type="checkbox" name="participants[]" value="{{ $item->id }}"
                                                class="participant-checkbox">

                                        </td>


                                        <td>

                                            {{ $item->participant->user->name }}

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                @else
                    <div class="text-center text-muted py-4">

                        <i class="fas fa-user-check fa-2x mb-2"></i>

                        <p class="mb-0">

                            Tidak ada peserta yang tersedia untuk ditambahkan.

                        </p>

                    </div>

                @endif

            </div>


            @if ($participants->count())
                <div class="card-footer">

                    <button type="submit" class="btn btn-primary">

                        <i class="fas fa-user-plus mr-1"></i>

                        Tambahkan ke Kelas

                    </button>

                </div>
            @endif

        </form>

    </div>
@else
    {{-- Kelas penuh --}}

    <div class="alert alert-warning">

        <i class="fas fa-exclamation-triangle mr-1"></i>

        <strong>Kelas sudah penuh.</strong>

        Tidak ada kuota yang tersedia untuk menambahkan peserta baru.

    </div>

@endif
