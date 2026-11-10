@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-users-cog mr-2"></i>
                User Management
            </h1>

            <p class="text-muted mb-0">
                Kelola akun pengguna dan hak akses sistem MGS.
            </p>
        </div>

    </div>

@stop


@section('content')

    {{-- =========================================================
         ALERT
         ========================================================= --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            <i class="fas fa-check-circle mr-2"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">

            <i class="fas fa-exclamation-circle mr-2"></i>

            {{ session('error') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif


    {{-- =========================================================
         RINGKASAN USER
         ========================================================= --}}

    <div class="row">

        {{-- TOTAL USER --}}
        <div class="col-lg-4 col-md-6">

            <div class="info-box shadow-sm">

                <span class="info-box-icon bg-primary">

                    <i class="fas fa-users"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Total User
                    </span>

                    <span class="info-box-number">

                        {{ $users->total() }}

                    </span>

                </div>

            </div>

        </div>


        {{-- USER AKTIF --}}
        <div class="col-lg-4 col-md-6">

            <div class="info-box shadow-sm">

                <span class="info-box-icon bg-success">

                    <i class="fas fa-user-check"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        User Aktif
                    </span>

                    <span class="info-box-number">

                        {{ \App\Models\User::where('is_active', true)->count() }}

                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         DAFTAR USER
         ========================================================= --}}

    <div class="card card-primary card-outline shadow-sm">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-0">

                    <i class="fas fa-user-friends mr-2"></i>

                    Daftar User

                </h3>


                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah User
                </button>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped mb-0">

                    <thead class="bg-light">

                        <tr>

                            <th width="60" class="text-center">

                                No

                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Email
                            </th>

                            <th width="240">
                                Password
                            </th>

                            <th>
                                Role
                            </th>

                            <th width="120" class="text-center">

                                Status

                            </th>

                            <th width="420" class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                {{-- NO --}}
                                <td class="text-center align-middle">

                                    {{ $users->firstItem() + $loop->index }}

                                </td>


                                {{-- NAMA --}}
                                <td class="align-middle">

                                    <div class="d-flex align-items-center">

                                        <div class="mr-2">

                                            <span
                                                class="bg-primary text-white rounded-circle d-inline-flex
                                                       align-items-center justify-content-center"
                                                style="width: 38px; height: 38px;">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </span>

                                        </div>


                                        <div>

                                            <strong class="d-block">

                                                {{ $user->name }}

                                            </strong>

                                            <small class="text-muted">

                                                User ID:
                                                #{{ $user->id }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- EMAIL --}}
                                <td class="align-middle">

                                    <span>

                                        {{ $user->email }}

                                    </span>

                                </td>


                                {{-- PASSWORD --}}
                                <td class="align-middle">

                                    @if ($user->password_display_plain)
                                        <div class="input-group input-group-sm">

                                            <input type="text" id="generated-password-{{ $user->id }}"
                                                class="form-control" value="{{ $user->password_display_plain }}" readonly>

                                            <div class="input-group-append">

                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="copyPassword('generated-password-{{ $user->id }}')"
                                                    title="Salin Password">
                                                    <i class="fas fa-copy"></i>
                                                </button>

                                            </div>

                                        </div>
                                    @else
                                        <span class="text-muted">
                                            Belum tersedia
                                        </span>
                                    @endif

                                </td>


                                {{-- ROLE --}}
                                <td class="align-middle">

                                    @if ($user->roles->count())
                                        @foreach ($user->roles as $role)
                                            @php

                                                $roleClass = match ($role->name) {
                                                    'Super Admin' => 'danger',

                                                    'Admin' => 'primary',

                                                    'Staff Administrasi' => 'info',

                                                    'Bendahara' => 'success',

                                                    'Instruktur' => 'warning',

                                                    'Peserta' => 'secondary',

                                                    default => 'dark',
                                                };

                                            @endphp


                                            <span class="badge badge-{{ $roleClass }} mr-1">

                                                {{ $role->name }}

                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="text-center align-middle">

                                    @if ($user->is_active)
                                        <span class="badge badge-success">

                                            <i class="fas fa-check-circle mr-1"></i>

                                            Aktif

                                        </span>
                                    @else
                                        <span class="badge badge-danger">

                                            <i class="fas fa-times-circle mr-1"></i>

                                            Nonaktif

                                        </span>
                                    @endif

                                </td>



                                {{-- AKSI --}}
                                <td class="text-center align-middle">

                                    <div class="d-flex justify-content-center align-items-center flex-wrap"
                                        style="gap: 5px;">

                                        {{-- EDIT --}}
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editUserModal-{{ $user->id }}" title="Edit User">

                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- GENERATE PASSWORD --}}
                                        <form action="{{ route('settings.users.generate-password', $user) }}"
                                            method="POST" class="m-0"
                                            onsubmit="return confirm('Generate password baru untuk {{ $user->name }}? Password lama akan diganti.')">
                                            @csrf

                                            <button type="submit" class="btn btn-primary btn-sm" title="Generate Password">

                                                <i class="fas fa-key"></i>
                                            </button>
                                        </form>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="m-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus User"
                                                onclick="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">

                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fas fa-users-slash fa-3x mb-3"></i>

                                        <h5>
                                            Belum Ada User
                                        </h5>

                                        <p class="mb-3">
                                            Belum ada akun pengguna yang terdaftar.
                                        </p>

                                        <a href="{{ route('users.create') }}" class="btn btn-primary">

                                            <i class="fas fa-plus mr-1"></i>

                                            Tambah User

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             PAGINATION
             ===================================================== --}}

        @if ($users->hasPages())
            <div class="card-footer">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <small class="text-muted mb-2 mb-md-0">

                        Menampilkan

                        <strong>
                            {{ $users->firstItem() }}
                        </strong>

                        sampai

                        <strong>
                            {{ $users->lastItem() }}
                        </strong>

                        dari

                        <strong>
                            {{ $users->total() }}
                        </strong>

                        user

                    </small>


                    <div>

                        {{ $users->links() }}

                    </div>

                </div>

            </div>
        @endif

    </div>

    {{-- MODAL CREATE USER --}}
    @include('settings.users.partials.create-modal')

    {{-- MODAL EDIT USER --}}
    @foreach ($users as $user)
        @include('settings.users.partials.edit-modal', [
            'user' => $user,
            'roles' => $roles,
        ])
    @endforeach

    @section('js')
        <script>
            function copyPassword(id) {
                const input = document.getElementById(id);

                if (!input) return;

                navigator.clipboard.writeText(input.value)
                    .then(() => {
                        toastr.success('Password berhasil disalin!');
                    })
                    .catch(() => {
                        input.select();
                        document.execCommand('copy');
                        toastr.success('Password berhasil disalin!');
                    });
            }
        </script>

        <script>
            function toggleUserPassword(inputId, button) {
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }

            $(document).ready(function() {

                // Buka kembali modal jika validasi gagal
                @if ($errors->any())

                    const failedUserId = @json(old('user_id'));

                    if (failedUserId) {
                        $('#editUserModal-' + failedUserId).modal('show');
                    } else {
                        $('#createUserModal').modal('show');
                    }
                @endif

            });

            // Menyimpan elemen yang membuka modal
            let modalTriggerElement = null;

            // Saat modal dibuka
            $(document).on('show.bs.modal', '.modal', function(event) {
                modalTriggerElement = event.relatedTarget || document.activeElement;
            });

            // Sebelum modal ditutup
            $(document).on('hide.bs.modal', '.modal', function() {
                const activeElement = document.activeElement;

                // Lepaskan fokus dari elemen di dalam modal
                if (activeElement && this.contains(activeElement)) {
                    activeElement.blur();
                }
            });

            // Setelah modal selesai ditutup
            $(document).on('hidden.bs.modal', '.modal', function() {
                // Kembalikan fokus ke tombol yang membuka modal
                if (
                    modalTriggerElement &&
                    document.contains(modalTriggerElement)
                ) {
                    modalTriggerElement.focus();
                }

                modalTriggerElement = null;
            });
        </script>
    @stop

@stop
