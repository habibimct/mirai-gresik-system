@php
    $isOldEdit = old('form_context') === 'edit'
        && (string) old('wave_id') === (string) $wave->id;

    $codeValue = $isOldEdit ? old('code') : $wave->code;
    $nameValue = $isOldEdit ? old('name') : $wave->name;
    $yearValue = $isOldEdit ? old('year') : $wave->year;

    $registrationStart = $isOldEdit
        ? old('registration_start')
        : ($wave->registration_start
            ? \Carbon\Carbon::parse($wave->registration_start)->format('Y-m-d')
            : '');

    $registrationEnd = $isOldEdit
        ? old('registration_end')
        : ($wave->registration_end
            ? \Carbon\Carbon::parse($wave->registration_end)->format('Y-m-d')
            : '');

    $trainingStart = $isOldEdit
        ? old('training_start')
        : ($wave->training_start
            ? \Carbon\Carbon::parse($wave->training_start)->format('Y-m-d')
            : '');

    $trainingEnd = $isOldEdit
        ? old('training_end')
        : ($wave->training_end
            ? \Carbon\Carbon::parse($wave->training_end)->format('Y-m-d')
            : '');

    $statusValue = $isOldEdit
        ? old('is_active')
        : (string) (int) $wave->is_active;

    $descriptionValue = $isOldEdit
        ? old('description')
        : $wave->description;
@endphp

<div class="modal fade"
    id="editWaveModal-{{ $wave->id }}"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('waves.update', $wave) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="form_context" value="edit">
                <input type="hidden" name="wave_id" value="{{ $wave->id }}">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Gelombang
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
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
                                    class="form-control {{ $isOldEdit && $errors->has('code') ? 'is-invalid' : '' }}"
                                    value="{{ $codeValue }}"
                                    maxlength="20"
                                    required>

                                @if ($isOldEdit)
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Nama Gelombang <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control {{ $isOldEdit && $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ $nameValue }}"
                                    required>

                                @if ($isOldEdit)
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="year"
                                    class="form-control {{ $isOldEdit && $errors->has('year') ? 'is-invalid' : '' }}"
                                    value="{{ $yearValue }}"
                                    min="2000" max="2100"
                                    required>

                                @if ($isOldEdit)
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
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
                                    class="form-control {{ $isOldEdit && $errors->has('registration_start') ? 'is-invalid' : '' }}"
                                    value="{{ $registrationStart }}"
                                    required>

                                @if ($isOldEdit)
                                    @error('registration_start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Selesai Pendaftaran <span class="text-danger">*</span></label>
                                <input type="date" name="registration_end"
                                    class="form-control {{ $isOldEdit && $errors->has('registration_end') ? 'is-invalid' : '' }}"
                                    value="{{ $registrationEnd }}"
                                    required>

                                @if ($isOldEdit)
                                    @error('registration_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
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
                                    class="form-control {{ $isOldEdit && $errors->has('training_start') ? 'is-invalid' : '' }}"
                                    value="{{ $trainingStart }}"
                                    required>

                                @if ($isOldEdit)
                                    @error('training_start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Selesai Pelatihan <span class="text-danger">*</span></label>
                                <input type="date" name="training_end"
                                    class="form-control {{ $isOldEdit && $errors->has('training_end') ? 'is-invalid' : '' }}"
                                    value="{{ $trainingEnd }}"
                                    required>

                                @if ($isOldEdit)
                                    @error('training_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
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
                                    class="form-control {{ $isOldEdit && $errors->has('is_active') ? 'is-invalid' : '' }}"
                                    required>

                                    <option value="1" @selected($statusValue == '1')>
                                        Aktif
                                    </option>

                                    <option value="0" @selected($statusValue == '0')>
                                        Nonaktif
                                    </option>

                                </select>

                                @if ($isOldEdit)
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Deskripsi</label>

                                <textarea name="description" rows="3"
                                    class="form-control {{ $isOldEdit && $errors->has('description') ? 'is-invalid' : '' }}">{{ $descriptionValue }}</textarea>

                                @if ($isOldEdit)
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer bg-light">

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
