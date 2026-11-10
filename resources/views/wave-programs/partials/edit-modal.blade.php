
@php
    $isOldEdit = old('form_context') === 'edit'
        && (string) old('wave_program_id') === (string) $item->id;

    $programValue = $isOldEdit
        ? old('program_id')
        : $item->program_id;

    $quotaValue = $isOldEdit
        ? old('quota')
        : $item->quota;

    $statusValue = $isOldEdit
        ? old('is_active')
        : (string) (int) $item->is_active;
@endphp

<div class="modal fade"
    id="editWaveProgramModal-{{ $item->id }}"
    tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('waves.programs.update', [$wave, $item]) }}"
                method="POST">

                @csrf
                @method('PUT')

                <input type="hidden" name="form_context" value="edit">
                <input type="hidden" name="wave_program_id" value="{{ $item->id }}">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Program Gelombang
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- GELOMBANG --}}
                    <div class="form-group">
                        <label>Gelombang</label>

                        <input type="text" class="form-control"
                            value="{{ $wave->name }}" readonly>
                    </div>

                    <hr>

                    {{-- PROGRAM --}}
                    <div class="form-group">
                        <label>
                            <i class="fas fa-graduation-cap mr-1 text-primary"></i>
                            Program <span class="text-danger">*</span>
                        </label>

                        <select name="program_id"
                            class="form-control {{ $isOldEdit && $errors->has('program_id') ? 'is-invalid' : '' }}"
                            required>

                            <option value="{{ $item->program_id }}"
                                @selected($programValue == $item->program_id)>
                                {{ $item->program->name }}
                            </option>

                            @foreach ($programs as $program)
                                @if ($program->id != $item->program_id)
                                    <option value="{{ $program->id }}"
                                        @selected($programValue == $program->id)>
                                        {{ $program->name }}
                                    </option>
                                @endif
                            @endforeach

                        </select>

                        @if ($isOldEdit)
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
                            class="form-control {{ $isOldEdit && $errors->has('quota') ? 'is-invalid' : '' }}"
                            value="{{ $quotaValue }}"
                            required>

                        @if ($isOldEdit)
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
                            class="form-control {{ $isOldEdit && $errors->has('is_active') ? 'is-invalid' : '' }}">

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
