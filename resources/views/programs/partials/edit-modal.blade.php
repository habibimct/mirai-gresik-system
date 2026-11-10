
@php
    $isOldEdit = old('form_context') === 'edit'
        && (string) old('program_id') === (string) $program->id;

    $codeValue = $isOldEdit ? old('code') : $program->code;
    $nameValue = $isOldEdit ? old('name') : $program->name;
    $descriptionValue = $isOldEdit ? old('description') : $program->description;
    $statusValue = $isOldEdit
        ? old('is_active')
        : (string) (int) $program->is_active;
@endphp

<div class="modal fade"
    id="editProgramModal-{{ $program->id }}"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('programs.update', $program) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="form_context" value="edit">
                <input type="hidden" name="program_id" value="{{ $program->id }}">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Program
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle text-warning mr-2"></i>
                        Perbarui informasi program sesuai kebutuhan.
                    </div>

                    <div class="row">

                        {{-- KODE --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kode Program <span class="text-danger">*</span></label>

                                <input type="text"
                                    name="code"
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

                        {{-- NAMA --}}
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Program <span class="text-danger">*</span></label>

                                <input type="text"
                                    name="name"
                                    class="form-control {{ $isOldEdit && $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ $nameValue }}"
                                    maxlength="255"
                                    required>

                                @if ($isOldEdit)
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group">
                        <label>Deskripsi</label>

                        <textarea name="description"
                            rows="4"
                            class="form-control {{ $isOldEdit && $errors->has('description') ? 'is-invalid' : '' }}">{{ $descriptionValue }}</textarea>

                        @if ($isOldEdit)
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label>Status Program <span class="text-danger">*</span></label>

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
