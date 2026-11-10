
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog"
    aria-labelledby="createUserModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('settings.users.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createUserModalLabel">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah User Baru
                    </h5>

                    <button type="button" class="close text-white"
                        data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <h6 class="text-primary mb-3">
                        <i class="fas fa-id-card mr-2"></i>
                        Informasi Pengguna
                    </h6>

                    <div class="form-group">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" name="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="contoh@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h6 class="text-primary mb-3">
                        <i class="fas fa-user-shield mr-2"></i>
                        Hak Akses
                    </h6>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role"
                                    class="form-control @error('role') is-invalid @enderror"
                                    required>

                                    <option value="">-- Pilih Role --</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @selected(old('role') == $role->name)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-control" required>
                                    <option value="1"
                                        @selected(old('is_active', '1') == '1')>
                                        Aktif
                                    </option>
                                    <option value="0"
                                        @selected(old('is_active') == '0')>
                                        Nonaktif
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h6 class="text-primary mb-3">
                        <i class="fas fa-lock mr-2"></i>
                        Keamanan Akun
                    </h6>

                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>

                        <div class="input-group">
                            <input type="password" name="password"
                                id="createUserPassword"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password" required>

                            <div class="input-group-append">
                                <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="toggleUserPassword('createUserPassword', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <small class="form-text text-muted">
                            Gunakan password yang kuat dan mudah dikelola.
                        </small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan User
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
