@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">

                <i class="fas fa-user-edit mr-2"></i>

                Edit User

            </h1>

            <p class="text-muted mb-0">

                Perbarui informasi dan hak akses pengguna.

            </p>

        </div>

        <a href="{{ route('users.index') }}"
            class="btn btn-secondary btn-sm">

            <i class="fas fa-arrow-left mr-1"></i>

            Kembali

        </a>

    </div>

@stop


@section('content')

    <div class="row">


        {{-- =====================================================
             FORM EDIT USER
             ===================================================== --}}

        <div class="col-lg-8">

            <div class="card card-primary card-outline shadow-sm">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-user-edit mr-2"></i>

                        Informasi User

                    </h3>

                </div>


                <form action="{{ route('users.update', $user) }}"
                    method="POST">

                    @csrf

                    @method('PUT')


                    <div class="card-body">


                        {{-- =================================================
                             DATA DASAR
                             ================================================= --}}

                        <h5 class="text-primary mb-3">

                            <i class="fas fa-id-card mr-2"></i>

                            Data Dasar

                        </h5>


                        <div class="row">


                            {{-- NAMA --}}
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="name">

                                        Nama

                                        <span class="text-danger">*</span>

                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">

                                            <span class="input-group-text">

                                                <i class="fas fa-user"></i>

                                            </span>

                                        </div>

                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}"
                                            placeholder="Nama lengkap"
                                            autofocus
                                        >

                                    </div>

                                    @error('name')

                                        <small class="text-danger">

                                            {{ $message }}

                                        </small>

                                    @enderror

                                </div>

                            </div>


                            {{-- NO HP --}}
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="phone">

                                        No. HP

                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">

                                            <span class="input-group-text">

                                                <i class="fas fa-phone"></i>

                                            </span>

                                        </div>

                                        <input
                                            type="text"
                                            id="phone"
                                            name="phone"
                                            class="form-control"
                                            value="{{ old('phone', $user->phone) }}"
                                            placeholder="08xxxxxxxxxx"
                                        >

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- EMAIL --}}

                        <div class="form-group">

                            <label for="email">

                                Email

                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">

                                        <i class="fas fa-envelope"></i>

                                    </span>

                                </div>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="contoh@email.com"
                                >

                            </div>

                            @error('email')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                            @enderror

                        </div>


                        <hr>


                        {{-- =================================================
                             HAK AKSES
                             ================================================= --}}

                        <h5 class="text-primary mb-3">

                            <i class="fas fa-user-shield mr-2"></i>

                            Hak Akses

                        </h5>


                        <div class="row">


                            {{-- ROLE --}}
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="role">

                                        Role

                                        <span class="text-danger">*</span>

                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">

                                            <span class="input-group-text">

                                                <i class="fas fa-user-tag"></i>

                                            </span>

                                        </div>

                                        <select
                                            name="role"
                                            id="role"
                                            class="form-control @error('role') is-invalid @enderror"
                                        >

                                            <option value="">
                                                -- Pilih Role --
                                            </option>

                                            @foreach ($roles as $role)

                                                <option
                                                    value="{{ $role->name }}"
                                                    @selected(old('role', $user->roles->first()?->name) == $role->name)
                                                >

                                                    {{ $role->name }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    @error('role')

                                        <small class="text-danger">

                                            {{ $message }}

                                        </small>

                                    @enderror

                                </div>

                            </div>


                            {{-- STATUS --}}
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="is_active">

                                        Status

                                        <span class="text-danger">*</span>

                                    </label>

                                    <div class="input-group">

                                        <div class="input-group-prepend">

                                            <span class="input-group-text">

                                                <i class="fas fa-toggle-on"></i>

                                            </span>

                                        </div>

                                        <select
                                            name="is_active"
                                            id="is_active"
                                            class="form-control"
                                        >

                                            <option
                                                value="1"
                                                @selected(old('is_active', $user->is_active) == 1)
                                            >

                                                Aktif

                                            </option>

                                            <option
                                                value="0"
                                                @selected(old('is_active', $user->is_active) == 0)
                                            >

                                                Nonaktif

                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <hr>


                        {{-- =================================================
                             PASSWORD
                             ================================================= --}}

                        <h5 class="text-primary mb-3">

                            <i class="fas fa-lock mr-2"></i>

                            Keamanan Akun

                        </h5>


                        <div class="form-group">

                            <label for="password">

                                Password Baru

                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text">

                                        <i class="fas fa-key"></i>

                                    </span>

                                </div>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password baru"
                                >

                                <div class="input-group-append">

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        id="togglePassword"
                                        title="Tampilkan password"
                                    >

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            @error('password')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                            @enderror

                            <small class="form-text text-muted">

                                Kosongkan jika tidak ingin mengubah password.

                            </small>

                        </div>

                    </div>


                    {{-- =================================================
                         FOOTER
                         ================================================= --}}

                    <div class="card-footer">

                        <div class="d-flex justify-content-end">

                            <a href="{{ route('users.index') }}"
                                class="btn btn-secondary mr-2">

                                <i class="fas fa-times mr-1"></i>

                                Batal

                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="fas fa-save mr-1"></i>

                                Simpan Perubahan

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- =====================================================
             PANEL INFORMASI
             ===================================================== --}}

        <div class="col-lg-4">

            <div class="card card-info card-outline shadow-sm">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-info-circle mr-2"></i>

                        Informasi User

                    </h3>

                </div>


                <div class="card-body">


                    {{-- USER --}}
                    <div class="text-center mb-4">

                        <div class="mb-3">

                            <span
                                class="img-circle elevation-2 d-inline-flex
                                       align-items-center justify-content-center
                                       bg-primary"
                                style="width:80px;height:80px;"
                            >

                                <i class="fas fa-user fa-2x text-white"></i>

                            </span>

                        </div>

                        <h5 class="mb-1">

                            {{ $user->name }}

                        </h5>

                        <small class="text-muted">

                            {{ $user->email }}

                        </small>

                    </div>


                    {{-- ROLE --}}
                    <div class="callout callout-primary">

                        <h6>

                            <i class="fas fa-user-shield mr-1"></i>

                            Role Saat Ini

                        </h6>

                        <p class="mb-0">

                            {{ optional($user->roles->first())->name ?? 'Belum memiliki role' }}

                        </p>

                    </div>


                    {{-- STATUS --}}
                    <div class="callout
                        {{ $user->is_active ? 'callout-success' : 'callout-danger' }}"
                    >

                        <h6>

                            <i class="fas
                                {{ $user->is_active
                                    ? 'fa-check-circle'
                                    : 'fa-times-circle' }}
                                mr-1">
                            </i>

                            Status Akun

                        </h6>

                        <p class="mb-0">

                            @if ($user->is_active)

                                <span class="text-success font-weight-bold">
                                    Aktif
                                </span>

                                — User dapat masuk ke sistem.

                            @else

                                <span class="text-danger font-weight-bold">
                                    Nonaktif
                                </span>

                                — User tidak dapat menggunakan sistem.

                            @endif

                        </p>

                    </div>


                    {{-- PASSWORD --}}
                    <div class="callout callout-warning">

                        <h6>

                            <i class="fas fa-key mr-1"></i>

                            Password

                        </h6>

                        <p class="mb-0">

                            Password tidak perlu diisi jika tidak ingin
                            melakukan perubahan.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

@stop


@section('js')

<script>

    $(document).ready(function () {

        $('#togglePassword').on('click', function () {

            const password = $('#password');

            const icon = $(this).find('i');


            if (password.attr('type') === 'password') {

                password.attr('type', 'text');

                icon
                    .removeClass('fa-eye')
                    .addClass('fa-eye-slash');

                $(this).attr(
                    'title',
                    'Sembunyikan password'
                );

            } else {

                password.attr('type', 'password');

                icon
                    .removeClass('fa-eye-slash')
                    .addClass('fa-eye');

                $(this).attr(
                    'title',
                    'Tampilkan password'
                );

            }

        });

    });

</script>

@stop