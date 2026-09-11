{{-- =========================================================
     MODAL DAFTAR KOMPONEN PENILAIAN
========================================================= --}}

<div class="modal fade" id="scoreTypeModal" tabindex="-1" role="dialog" aria-labelledby="scoreTypeModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-success">

                <h5 class="modal-title" id="scoreTypeModalLabel">

                    <i class="fas fa-list mr-2"></i>
                    Komponen Penilaian

                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body">

                {{-- Daftar Komponen --}}
                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="thead-light">

                            <tr>

                                <th width="60" class="text-center">
                                    No
                                </th>

                                <th>
                                    Komponen Penilaian
                                </th>

                                <th width="100">Status</th>

                                <th width="100" class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($scoreTypes as $type)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $type->name }}
                                    </td>

                                    <td class="text-center">

                                        @if ($type->is_active)
                                            <span class="badge badge-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                Nonaktif
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editType{{ $type->id }}" title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </button>


                                            <form action="{{ route('score-types.destroy', $type) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                    onclick="return confirm('Hapus komponen {{ $type->name }}?')">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center text-muted py-3">

                                        <i class="fas fa-info-circle mr-1"></i>

                                        Belum ada komponen penilaian.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Tambah Komponen --}}
                <hr>

                <div class="mt-3">

                    <h6 class="font-weight-bold mb-3">

                        <i class="fas fa-plus-circle text-success mr-1"></i>

                        Tambah Komponen

                    </h6>


                    <form action="{{ route('score-types.store') }}" method="POST">

                        @csrf

                        <input type="hidden" name="wave_program_id" value="{{ $classroom->wave_program_id }}">
                        
                        <div class="form-group">

                            <label for="scoreTypeName">
                                Nama Komponen
                            </label>

                            <input type="text" id="scoreTypeName" name="name" class="form-control"
                                placeholder="Contoh: Grammar" required>

                        </div>


                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-save mr-1"></i>

                            Tambah Komponen

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL EDIT KOMPONEN
     Diletakkan DI LUAR scoreTypeModal
========================================================= --}}

@foreach ($scoreTypes as $type)
    <div class="modal fade" id="editType{{ $type->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editTypeLabel{{ $type->id }}" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header bg-warning">

                    <h5 class="modal-title" id="editTypeLabel{{ $type->id }}">

                        <i class="fas fa-edit mr-2"></i>
                        Edit Komponen Penilaian

                    </h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                {{-- Form --}}
                <form action="{{ route('score-types.update', $type) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        {{-- Nama --}}
                        <div class="form-group">

                            <label for="name{{ $type->id }}">
                                Nama Komponen
                            </label>

                            <input type="text" id="name{{ $type->id }}" name="name" class="form-control"
                                value="{{ old('name', $type->name) }}" maxlength="100" required>

                        </div>


                        {{-- Status --}}
                        <div class="form-group">

                            <div class="custom-control custom-switch">

                                <input type="checkbox" class="custom-control-input" id="active{{ $type->id }}"
                                    name="is_active" value="1" {{ $type->is_active ? 'checked' : '' }}>

                                <label class="custom-control-label" for="active{{ $type->id }}">

                                    Komponen Aktif

                                </label>

                            </div>

                            <small class="form-text text-muted">

                                Komponen yang tidak aktif tidak digunakan
                                untuk penilaian baru.

                            </small>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">

                            <i class="fas fa-times mr-1"></i>
                            Batal

                        </button>

                        <button type="submit" class="btn btn-warning">

                            <i class="fas fa-save mr-1"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endforeach
