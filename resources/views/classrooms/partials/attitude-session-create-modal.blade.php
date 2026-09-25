{{-- ========================================================= --}}
{{-- MODAL TAMBAH PENILAIAN SIKAP --}}
{{-- ========================================================= --}}

<div class="modal fade"
    id="createAttitudeSession"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createAttitudeSessionLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form
                action="{{ route('classrooms.attitude-sessions.store', $classroom) }}"
                method="POST">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title"
                        id="createAttitudeSessionLabel">

                        <i class="fas fa-plus mr-1"></i>
                        Tambah Penilaian Sikap

                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        {{-- MINGGU --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="attitude_week">
                                    Minggu
                                </label>

                                <input type="number"
                                    name="week"
                                    id="attitude_week"
                                    class="form-control"
                                    min="1"
                                    required>

                            </div>

                        </div>

                        {{-- TANGGAL --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="attitude_date">
                                    Tanggal
                                </label>

                                <input type="date"
                                    name="assessment_date"
                                    id="attitude_date"
                                    class="form-control"
                                    value="{{ date('Y-m-d') }}"
                                    required>

                            </div>

                        </div>

                        {{-- JUDUL --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="attitude_title">
                                    Judul Penilaian
                                </label>

                                <input type="text"
                                    name="title"
                                    id="attitude_title"
                                    class="form-control"
                                    placeholder="Contoh: Penilaian Sikap 1"
                                    required
                                    maxlength="255">

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <label class="mb-0">
                            Komponen Sikap
                        </label>

                        <small class="text-muted">
                            Pilih minimal 1 komponen
                        </small>

                    </div>

                    @if ($attitudeTypes->count())

                        <div class="row">

                            @foreach ($attitudeTypes as $type)

                                <div class="col-md-6">

                                    <div class="custom-control custom-checkbox mb-2">

                                        <input type="checkbox"
                                            class="custom-control-input"
                                            id="attitudeType{{ $type->id }}"
                                            name="attitude_types[]"
                                            value="{{ $type->id }}">

                                        <label class="custom-control-label"
                                            for="attitudeType{{ $type->id }}">

                                            {{ $type->name }}

                                        </label>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="alert alert-warning">

                            <i class="fas fa-exclamation-triangle mr-1"></i>

                            Belum ada komponen sikap aktif untuk program ini.

                        </div>

                    @endif

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                        class="btn btn-primary"
                        @disabled(!$attitudeTypes->count())>

                        <i class="fas fa-save mr-1"></i>
                        Simpan Penilaian

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>