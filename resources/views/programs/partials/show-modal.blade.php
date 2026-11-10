<div class="modal fade" id="showProgramModal-{{ $program->id }}" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Detail Program
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 70px; height: 70px;">

                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>

                        </span>
                    </div>

                    <h4 class="font-weight-bold mb-1">
                        {{ $program->name }}
                    </h4>

                    <span class="badge badge-secondary px-3 py-2">
                        {{ $program->code }}
                    </span>

                    <div class="mt-2">
                        @if ($program->is_active)
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle mr-1"></i>
                                Program Aktif
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle mr-1"></i>
                                Program Nonaktif
                            </span>
                        @endif
                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Kode Program</small>
                        <strong>{{ $program->code }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Nama Program</small>
                        <strong>{{ $program->name }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">
                            Gelombang yang Memiliki Kelas
                        </small>
                        <strong>
                            {{ $program->classrooms_count ?? 0 }} Gelombang
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Status</small>

                        @if ($program->is_active)
                            <span class="text-success font-weight-bold">Aktif</span>
                        @else
                            <span class="text-danger font-weight-bold">Nonaktif</span>
                        @endif
                    </div>

                </div>

                <div class="form-group mb-0">
                    <label>Deskripsi Program</label>

                    <div class="border rounded p-3 bg-light" style="min-height: 100px;">
                        {!! nl2br(e($program->description ?: 'Belum ada deskripsi program.')) !!}
                    </div>
                </div>

            </div>

            <div class="modal-footer bg-light">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Tutup
                </button>

                <button type="button" class="btn btn-warning" data-dismiss="modal" data-toggle="modal"
                    data-target="#editProgramModal-{{ $program->id }}">

                    <i class="fas fa-edit mr-1"></i>
                    Edit Program

                </button>

            </div>

        </div>
    </div>
</div>
