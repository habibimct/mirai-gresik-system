
<div class="modal fade"
    id="showWaveProgramModal-{{ $item->id }}"
    tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Detail Program Gelombang
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- IDENTITAS PROGRAM --}}
                <div class="text-center mb-4">

                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 70px; height: 70px;">

                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>

                        </span>
                    </div>

                    <h4 class="font-weight-bold mb-1">
                        {{ $item->program->name }}
                    </h4>

                    <small class="text-muted">
                        Program pada {{ $wave->name }}
                    </small>

                    <div class="mt-2">
                        @if ($item->is_active)
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        @else
                            <span class="badge badge-secondary px-3 py-2">
                                <i class="fas fa-ban mr-1"></i>
                                Nonaktif
                            </span>
                        @endif
                    </div>

                </div>

                <hr>

                {{-- INFORMASI GELOMBANG --}}
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-layer-group mr-2"></i>
                    Informasi Gelombang
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Nama Gelombang</small>
                        <strong>{{ $wave->name }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Kode Gelombang</small>
                        <strong>{{ $wave->code }}</strong>
                    </div>

                </div>

                <hr>

                {{-- INFORMASI PROGRAM --}}
                <h6 class="text-info font-weight-bold mb-3">
                    <i class="fas fa-book mr-2"></i>
                    Informasi Program
                </h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Nama Program</small>
                        <strong>{{ $item->program->name }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Kuota Peserta</small>
                        <strong>
                            <i class="fas fa-users text-info mr-1"></i>
                            {{ $item->quota }} Peserta
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Jumlah Kelas</small>
                        <strong>
                            {{ $item->classrooms_count ?? 0 }} Kelas
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Status Program</small>

                        @if ($item->is_active)
                            <span class="text-success font-weight-bold">Aktif</span>
                        @else
                            <span class="text-secondary font-weight-bold">Nonaktif</span>
                        @endif
                    </div>

                </div>

            </div>

            <div class="modal-footer bg-light">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Tutup
                </button>

                <button type="button"
                    class="btn btn-warning"
                    data-dismiss="modal"
                    data-toggle="modal"
                    data-target="#editWaveProgramModal-{{ $item->id }}">

                    <i class="fas fa-edit mr-1"></i>
                    Edit Program

                </button>

            </div>

        </div>
    </div>
</div>
