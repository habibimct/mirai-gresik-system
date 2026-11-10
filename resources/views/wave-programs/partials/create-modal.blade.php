
@php
    $isOldCreate = old('form_context') === 'create';
@endphp

<div class="modal fade" id="createWaveProgramModal" tabindex="-1"
    role="dialog" aria-labelledby="createWaveProgramModalLabel">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('waves.programs.store', $wave) }}" method="POST">
                @csrf

                <input type="hidden" name="form_context" value="create">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createWaveProgramModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Program Gelombang
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- GELOMBANG --}}
                    <div class="form-group">
                        <label>
                            <i class="fas fa-layer-group mr-1 text-primary"></i>
                            Gelombang
                        </label>

                        <input type="text" class="form-control"
                            value="{{ $wave->name }}" readonly>

                        <small class="form-text text-muted">
                            Program akan ditambahkan ke gelombang ini.
                        </small>
                    </div>

                    <hr>

                    {{-- PROGRAM --}}
                    <div class="form-group">
                        <label>
                            <i class="fas fa-graduation-cap mr-1 text-primary"></i>
                            Program <span class="text-danger">*</span>
                        </label>

                        <select name="program_id"
                            class="form-control {{ $isOldCreate && $errors->has('program_id') ? 'is-invalid' : '' }}"
                            required>

                            <option value="">-- Pilih Program --</option>

                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}"
                                    @selected($isOldCreate && old('program_id') == $program->id)>
                                    {{ $program->name }}
                                </option>
                            @endforeach

                        </select>

                        @if ($isOldCreate)
                            @error('program_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    {{-- KUOTA --}}
                    <div class="form-group">
                        <label>
                            <i class="fas fa-users mr-1 text-primary"></i>
                            Kuota <span class="text-danger">*</span>
                        </label>

                        <input type="number" name="quota" min="1"
                            class="form-control {{ $isOldCreate && $errors->has('quota') ? 'is-invalid' : '' }}"
                            value="{{ $isOldCreate ? old('quota', 0) : 0 }}"
                            placeholder="Masukkan jumlah kuota"
                            required>

                        @if ($isOldCreate)
                            @error('quota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endif

                        <small class="form-text text-muted">
                            Jumlah maksimal peserta untuk program ini.
                        </small>
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label>
                            <i class="fas fa-toggle-on mr-1 text-primary"></i>
                            Status Program
                        </label>

                        <select name="is_active"
                            class="form-control {{ $isOldCreate && $errors->has('is_active') ? 'is-invalid' : '' }}">

                            <option value="1"
                                @selected(!$isOldCreate || old('is_active', 1) == 1)>
                                Aktif
                            </option>

                            <option value="0"
                                @selected($isOldCreate && old('is_active') == 0)>
                                Nonaktif
                            </option>

                        </select>

                        @if ($isOldCreate)
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endif

                        <small class="form-text text-muted">
                            Program aktif dapat digunakan dalam proses pelatihan.
                        </small>
                    </div>

                </div>

                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Program
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
