<div class="modal fade"
    id="createScoreSession"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createScoreSessionLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <form action="{{ route('classrooms.scores.store', $classroom) }}"
            method="POST"
            class="w-100">

            @csrf

            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title font-weight-bold"
                        id="createScoreSessionLabel">

                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Penilaian

                    </h5>

                    <button type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body p-4">

                    {{-- Info --}}
                    <div class="alert alert-light border mb-4">

                        <div class="d-flex">

                            <div class="mr-3 text-primary">

                                <i class="fas fa-info-circle fa-lg"></i>

                            </div>

                            <div>

                                <strong>Penilaian Pembelajaran</strong>

                                <div class="small text-muted mt-1">

                                    Tentukan minggu, tanggal, judul penilaian,
                                    dan komponen nilai yang akan digunakan.

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Minggu & Tanggal --}}
                    <div class="row">

                        {{-- Minggu --}}
                        <div class="col-md-5">

                            <div class="form-group">

                                <label for="week"
                                    class="font-weight-bold">

                                    <i class="fas fa-calendar-week text-primary mr-1"></i>
                                    Minggu Ke

                                </label>

                                <input type="number"
                                    id="week"
                                    name="week"
                                    class="form-control"
                                    min="1"
                                    placeholder="1"
                                    required>

                            </div>

                        </div>

                        {{-- Tanggal --}}
                        <div class="col-md-7">

                            <div class="form-group">

                                <label for="assessment_date"
                                    class="font-weight-bold">

                                    <i class="fas fa-calendar-alt text-primary mr-1"></i>
                                    Tanggal

                                </label>

                                <input type="date"
                                    id="assessment_date"
                                    name="assessment_date"
                                    class="form-control"
                                    required>

                            </div>

                        </div>

                    </div>

                    {{-- Judul --}}
                    <div class="form-group">

                        <label for="title"
                            class="font-weight-bold">

                            <i class="fas fa-heading text-primary mr-1"></i>
                            Judul Penilaian

                        </label>

                        <input type="text"
                            id="title"
                            name="title"
                            class="form-control"
                            placeholder="Contoh: Penilaian 1"
                            required>

                        <small class="form-text text-muted">
                            Berikan nama yang mudah dikenali pada daftar penilaian (maksimal dua kata).
                        </small>

                    </div>

                    {{-- Komponen Penilaian --}}
                    <div class="form-group mb-0">

                        <label class="font-weight-bold">

                            <i class="fas fa-tasks text-primary mr-1"></i>
                            Komponen Penilaian

                        </label>

                        <div class="border rounded p-3 bg-light">

                            @forelse ($scoreTypes as $type)

                                <div class="custom-control custom-checkbox mb-2">

                                    <input type="checkbox"
                                        class="custom-control-input"
                                        id="scoreType{{ $type->id }}"
                                        name="score_types[]"
                                        value="{{ $type->id }}">

                                    <label class="custom-control-label"
                                        for="scoreType{{ $type->id }}">

                                        {{ $type->name }}

                                    </label>

                                </div>

                            @empty

                                <div class="text-muted small">

                                    <i class="fas fa-exclamation-circle mr-1"></i>

                                    Belum ada komponen penilaian yang tersedia.

                                </div>

                            @endforelse

                        </div>

                        <small class="form-text text-muted">
                            Pilih satu atau lebih komponen penilaian yang akan digunakan.
                        </small>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer bg-light">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Batal

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-save mr-1"></i>
                        Simpan Penilaian

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>