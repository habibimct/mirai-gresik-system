<div class="modal fade" id="graduationSettingModal" tabindex="-1" role="dialog"
    aria-labelledby="graduationSettingModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0 shadow">

            <form action="{{ route('score-recaps.graduation-setting', $classroom) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- Header --}}
                <div class="modal-header bg-warning">

                    <h5 class="modal-title font-weight-bold" id="graduationSettingModalLabel">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Pengaturan Kelulusan
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body p-4">

                    {{-- Info --}}
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex">

                            <div class="mr-3 text-warning">
                                <i class="fas fa-info-circle fa-lg"></i>
                            </div>

                            <div>
                                <strong>Kriteria Kelulusan</strong>

                                <div class="small text-muted mt-1">
                                    Peserta dinyatakan lulus apabila memenuhi
                                    batas nilai dan kehadiran minimal yang ditentukan.
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Nilai Minimal --}}
                    <div class="form-group">

                        <label for="minimum_score" class="font-weight-bold">
                            <i class="fas fa-star text-warning mr-1"></i>
                            Nilai Minimal Lulus
                        </label>

                        <div class="input-group">

                            <input type="number"
                                id="minimum_score"
                                name="minimum_score"
                                class="form-control"
                                min="0"
                                max="100"
                                step="0.01"
                                value="{{ old('minimum_score', $classroom->minimum_score) }}"
                                required>

                            <div class="input-group-append">
                                <span class="input-group-text">/ 100</span>
                            </div>

                        </div>

                        <small class="form-text text-muted">
                            Nilai minimal yang harus dicapai peserta untuk dinyatakan lulus.
                        </small>

                    </div>

                    {{-- Kehadiran Minimal --}}
                    <div class="form-group mb-0">

                        <label for="minimum_attendance" class="font-weight-bold">
                            <i class="fas fa-user-check text-success mr-1"></i>
                            Kehadiran Minimal
                        </label>

                        <div class="input-group">

                            <input type="number"
                                id="minimum_attendance"
                                name="minimum_attendance"
                                class="form-control"
                                min="0"
                                max="100"
                                step="0.01"
                                value="{{ old('minimum_attendance', $classroom->minimum_attendance) }}"
                                required>

                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>

                        </div>

                        <small class="form-text text-muted">
                            Persentase kehadiran minimal yang harus dipenuhi peserta.
                        </small>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Pengaturan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>