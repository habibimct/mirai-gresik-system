
<div class="modal fade"
    id="showWaveModal-{{ $wave->id }}"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Detail Gelombang
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- IDENTITAS GELOMBANG --}}
                <div class="text-center mb-4">

                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 70px; height: 70px;">

                            <i class="fas fa-layer-group fa-2x text-primary"></i>

                        </span>
                    </div>

                    <h4 class="font-weight-bold mb-1">
                        {{ $wave->name }}
                    </h4>

                    <span class="badge badge-secondary px-3 py-2">
                        {{ $wave->code }}
                    </span>

                    <div class="mt-2">
                        @if ($wave->is_active)
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle mr-1"></i>
                                Nonaktif
                            </span>
                        @endif
                    </div>

                </div>

                <hr>

                {{-- INFORMASI UMUM --}}
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Umum
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Kode Gelombang</small>
                        <strong>{{ $wave->code }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Tahun</small>
                        <strong>{{ $wave->year }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Jumlah Kelas</small>
                        <strong>{{ $wave->classrooms_count ?? 0 }} Kelas</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Status</small>
                        @if ($wave->is_active)
                            <span class="text-success font-weight-bold">Aktif</span>
                        @else
                            <span class="text-danger font-weight-bold">Nonaktif</span>
                        @endif
                    </div>

                </div>

                <hr>

                {{-- PERIODE PENDAFTARAN --}}
                <h6 class="text-info font-weight-bold mb-3">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Periode Pendaftaran
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Mulai Pendaftaran</small>
                        <strong>
                            {{ $wave->registration_start
                                ? \Carbon\Carbon::parse($wave->registration_start)->format('d/m/Y')
                                : '-' }}
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Selesai Pendaftaran</small>
                        <strong>
                            {{ $wave->registration_end
                                ? \Carbon\Carbon::parse($wave->registration_end)->format('d/m/Y')
                                : '-' }}
                        </strong>
                    </div>

                </div>

                <hr>

                {{-- PERIODE PELATIHAN --}}
                <h6 class="text-success font-weight-bold mb-3">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Periode Pelatihan
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Mulai Pelatihan</small>
                        <strong>
                            {{ $wave->training_start
                                ? \Carbon\Carbon::parse($wave->training_start)->format('d/m/Y')
                                : '-' }}
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Selesai Pelatihan</small>
                        <strong>
                            {{ $wave->training_end
                                ? \Carbon\Carbon::parse($wave->training_end)->format('d/m/Y')
                                : '-' }}
                        </strong>
                    </div>

                </div>

                <hr>

                {{-- DESKRIPSI --}}
                <h6 class="text-warning font-weight-bold mb-2">
                    <i class="fas fa-align-left mr-2"></i>
                    Deskripsi
                </h6>

                <div class="border rounded p-3 bg-light">
                    {!! nl2br(e($wave->description ?: 'Belum ada deskripsi gelombang.')) !!}
                </div>

            </div>

            <div class="modal-footer bg-light">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Tutup
                </button>

            </div>

        </div>
    </div>
</div>
