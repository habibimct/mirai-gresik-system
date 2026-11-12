
<div class="modal fade"
    id="showParticipantModal-{{ $participant->id }}"
    tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">
                    <i class="fas fa-user mr-2"></i>
                    Detail Peserta
                </h5>

                <button type="button" class="close text-white"
                    data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- IDENTITAS UTAMA --}}
                <div class="text-center mb-4">

                    <div class="d-inline-flex align-items-center justify-content-center
                        rounded-circle bg-primary text-white mb-3"
                        style="width: 75px; height: 75px;">

                        <i class="fas fa-user fa-2x"></i>

                    </div>

                    <h4 class="font-weight-bold mb-1">
                        {{ $participant->user->name }}
                    </h4>

                    <div class="text-muted">
                        {{ $participant->user->email }}
                    </div>

                    <div class="mt-2">

                        @if ($participant->status === 'Aktif')
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        @elseif ($participant->status === 'Lulus')
                            <span class="badge badge-primary px-3 py-2">
                                <i class="fas fa-graduation-cap mr-1"></i>
                                Lulus
                            </span>
                        @else
                            <span class="badge badge-secondary px-3 py-2">
                                {{ $participant->status }}
                            </span>
                        @endif

                    </div>

                </div>

                <hr>

                {{-- DATA AKUN --}}
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-user-circle mr-2"></i>
                    Data Akun
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Nama Lengkap</small>
                        <strong>{{ $participant->user->name }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Email</small>
                        <strong>{{ $participant->user->email }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">No. HP</small>
                        <strong>{{ $participant->user->phone ?: '-' }}</strong>
                    </div>

                </div>

                <hr>

                {{-- IDENTITAS --}}
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-id-card mr-2"></i>
                    Identitas Peserta
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">NIK</small>
                        <strong>{{ $participant->nik ?: '-' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Jenis Kelamin</small>

                        <strong>
                            @if ($participant->gender === 'L')
                                Laki-laki
                            @elseif ($participant->gender === 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Tempat Lahir</small>
                        <strong>{{ $participant->birth_place ?: '-' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Tanggal Lahir</small>
                        <strong>
                            {{ $participant->birth_date
                                ? \Carbon\Carbon::parse($participant->birth_date)->format('d/m/Y')
                                : '-' }}
                        </strong>
                    </div>

                </div>

                <hr>

                {{-- ALAMAT DAN PENDIDIKAN --}}
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-address-card mr-2"></i>
                    Alamat dan Pendidikan
                </h6>

                <div class="mb-3">
                    <small class="text-muted d-block">Alamat</small>

                    <div class="border rounded bg-light p-3 mt-1">
                        {!! nl2br(e($participant->address ?: 'Belum ada alamat.')) !!}
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Pendidikan Terakhir</small>
                        <strong>{{ $participant->education ?: '-' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Pekerjaan</small>
                        <strong>{{ $participant->job ?: '-' }}</strong>
                    </div>

                </div>

                <hr>

                {{-- STATUS --}}
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-toggle-on mr-2"></i>
                    Status Peserta
                </h6>

                <strong>{{ $participant->status }}</strong>

            </div>

            <div class="modal-footer bg-light">

                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">

                    <i class="fas fa-times mr-1"></i>
                    Tutup

                </button>

                <button type="button"
                    class="btn btn-warning"
                    data-dismiss="modal"
                    data-toggle="modal"
                    data-target="#editParticipantModal-{{ $participant->id }}">

                    <i class="fas fa-edit mr-1"></i>
                    Edit Peserta

                </button>

            </div>

        </div>
    </div>
</div>
