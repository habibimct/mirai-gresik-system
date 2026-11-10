
<div class="modal fade" id="createProgramModal" tabindex="-1"
    role="dialog" aria-labelledby="createProgramModalLabel">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('programs.store') }}" method="POST">
                @csrf

                <input type="hidden" name="form_context" value="create">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createProgramModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Program Baru
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Lengkapi informasi program pelatihan dengan benar.
                    </div>

                    <div class="row">

                        {{-- KODE --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kode Program <span class="text-danger">*</span></label>

                                <input type="text"
                                    name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}"
                                    placeholder="Contoh: JP"
                                    maxlength="20"
                                    autocomplete="off"
                                    required>

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- NAMA --}}
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Program <span class="text-danger">*</span></label>

                                <input type="text"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Bahasa Jepang"
                                    maxlength="255"
                                    required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group">
                        <label>Deskripsi</label>

                        <textarea name="description"
                            rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Masukkan deskripsi program...">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label>Status Program <span class="text-danger">*</span></label>

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
