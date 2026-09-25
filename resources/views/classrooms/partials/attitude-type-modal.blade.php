{{-- ========================================================= --}}
{{-- MODAL KOMPONEN SIKAP --}}
{{-- ========================================================= --}}

<div class="modal fade" id="attitudeTypeModal" tabindex="-1" role="dialog" aria-labelledby="attitudeTypeModalLabel"
    aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="attitudeTypeModalLabel">
                    <i class="fas fa-list mr-1"></i>
                    Komponen Sikap
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                {{-- DAFTAR KOMPONEN --}}
                @if ($attitudeTypes->count())

                    <div class="list-group mb-3">

                        @foreach ($attitudeTypes as $type)
                            <div class="list-group-item">

                                <div class="d-flex justify-content-between align-items-center">

                                    <span>
                                        {{ $type->name }}
                                    </span>

                                    <div>

                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#editAttitudeType{{ $type->id }}">

                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form
                                            action="{{ route('classrooms.attitude-types.destroy', [$classroom, $type]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus komponen sikap ini?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                        <span class="badge badge-success ml-1">
                                            Aktif
                                        </span>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="text-center text-muted py-3">

                        <i class="fas fa-info-circle mr-1"></i>

                        Belum ada komponen sikap.

                    </div>

                @endif

                <hr>

                {{-- FORM TAMBAH --}}
                <form action="{{ route('classrooms.attitude-types.store', $classroom) }}" method="POST">

                    @csrf

                    <div class="form-group mb-0">

                        <label for="attitudeTypeName">
                            Nama Komponen Sikap
                        </label>

                        <div class="input-group">

                            <input type="text" name="name" id="attitudeTypeName" class="form-control"
                                placeholder="Contoh: Kepatuhan" required maxlength="255">

                            <div class="input-group-append">

                                <button type="submit" class="btn btn-primary">

                                    <i class="fas fa-plus mr-1"></i>
                                    Tambah

                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>



@foreach ($attitudeTypes as $type)
    <div class="modal fade" id="editAttitudeType{{ $type->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editAttitudeTypeLabel{{ $type->id }}" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <form
                    action="{{ route('classrooms.attitude-types.update', [$classroom, $type]) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="modal-header">

                        <h5 class="modal-title" id="editAttitudeTypeLabel{{ $type->id }}">

                            <i class="fas fa-edit mr-1"></i>
                            Edit Komponen Sikap

                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="form-group">

                            <label>
                                Nama Komponen Sikap
                            </label>

                            <input type="text" name="name" class="form-control" value="{{ $type->name }}"
                                required maxlength="255">

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save mr-1"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endforeach
