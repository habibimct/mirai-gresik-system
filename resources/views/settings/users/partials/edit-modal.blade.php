
@php
    $isOldEdit = (string) old('user_id') === (string) $user->id;

    $selectedRole = $isOldEdit
        ? old('role')
        : $user->roles->first()?->name;

    $selectedStatus = $isOldEdit
        ? old('is_active')
        : (string) (int) $user->is_active;
@endphp

<div class="modal fade"
    id="editUserModal-{{ $user->id }}"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('settings.users.update', $user) }}"
                method="POST">

                @csrf
                @method('PUT')

                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit mr-2"></i>
                        Edit User - {{ $user->name }}
                    </h5>

                    <button type="button" class="close"
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
                            value="{{ $isOldEdit ? old('name') : $user->name }}"
                            required>

                        @if ($isOldEdit)
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" name="phone"
                                    class="form-control"
                                    value="{{ $isOldEdit ? old('phone') : $user->phone }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ $isOldEdit ? old('email') : $user->email }}"
                                    required>

                                @if ($isOldEdit)
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
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
                                            @selected($selectedRole == $role->name)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @if ($isOldEdit)
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>

                                <select name="is_active" class="form-control">
                                    <option value="1"
                                        @selected($selectedStatus == '1')>
                                        Aktif
                                    </option>

                                    <option value="0"
                                        @selected($selectedStatus == '0')>
                                        Nonaktif
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h6 class="text-primary mb-3">
                        <i class="fas fa-lock mr-2"></i>
                        Ganti Password
                    </h6>

                    <div class="form-group">
                        <label>Password Baru</label>

                        <div class="input-group">
                            <input type="password"
                                name="password"
                                id="editUserPassword-{{ $user->id }}"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak ingin mengganti password">

                            <div class="input-group-append">
                                <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="toggleUserPassword('editUserPassword-{{ $user->id }}', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        @if ($isOldEdit)
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        @endif

                        <small class="form-text text-muted">
                            Kosongkan jika password tidak ingin diubah.
                        </small>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
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
