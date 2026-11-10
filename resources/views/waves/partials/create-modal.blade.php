
<div class="modal fade" id="createWaveModal" tabindex="-1"
    role="dialog" aria-labelledby="createWaveModalLabel">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('waves.store') }}" method="POST">
                @csrf

                <input type="hidden" name="form_context" value="create">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createWaveModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Gelombang
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- INFORMASI GELOMBANG --}}
                    <h6 class="text-primary font-weight-bold mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi Gelombang
                    </h6>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kode Gelombang <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}"
                                    placeholder="Contoh: G01"
                                    autocomplete="off"
                                    required>

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Nama Gelombang <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Gelombang I"
                                    required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="year"
                                    class="form-control @error('year') is-invalid @enderror"
                                    value="{{ old('year', date('Y')) }}"
                                    min="2000" max="2100"
                                    required>

                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <hr>

                    {{-- PERIODE PENDAFTARAN --}}
                    <h6 class="text-info font-weight-bold mb-3">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Periode Pendaftaran
                    </h6>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai Pendaftaran <span class="text-danger">*</span></label>
                                <input type="date" name="registration_start"
                                    class="form-control @error('registration_start') is-invalid @enderror"
                                    value="{{ old('registration_start') }}"
                                    required>

                                @error('registration_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Selesai Pendaftaran <span class="text-danger">*</span></label>
                                <input type="date" name="registration_end"
                                    class="form-control @error('registration_end') is-invalid @enderror"
                                    value="{{ old('registration_end') }}"
                                    required>

                                @error('registration_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <hr>

                    {{-- PERIODE PELATIHAN --}}
                    <h6 class="text-success font-weight-bold mb-3">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Periode Pelatihan
                    </h6>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai Pelatihan <span class="text-danger">*</span></label>
                                <input type="date" name="training_start"
                                    class="form-control @error('training_start') is-invalid @enderror"
                                    value="{{ old('training_start') }}"
                                    required>

                                @error('training_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Selesai Pelatihan <span class="text-danger">*</span></label>
                                <input type="date" name="training_end"
                                    class="form-control @error('training_end') is-invalid @enderror"
                                    value="{{ old('training_end') }}"
                                    required>

                                @error('training_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <hr>

                    {{-- STATUS DAN DESKRIPSI --}}
                    <h6 class="text-warning font-weight-bold mb-3">
                        <i class="fas fa-cog mr-2"></i>
                        Status dan Deskripsi
                    </h6>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="is_active"
                                    class="form-control @error('is_active') is-invalid @enderror"
                                    required>

                                    <option value="1" @selected(old('is_active', '1') == '1')>
                                        Aktif
                                    </option>

                                    <option value="0" @selected(old('is_active') == '0')>
                                        Nonaktif
                                    </option>

                                </select>

                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Masukkan keterangan atau deskripsi gelombang...">{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <small class="text-muted">
                        <span class="text-danger">*</span>
                        Field bertanda bintang wajib diisi.
                    </small>

                </div>

                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Gelombang
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
