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

            <button type="button"
                class="close"
                data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-danger alert-dismissible fade show shadow-sm">

            <i class="fas fa-exclamation-circle mr-2"></i>

            {{ session('error') }}

            <button type="button"
                class="close"
                data-dismiss="alert">

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


                <a href="{{ route('users.create') }}"
                    class="btn btn-primary btn-sm">

                    <i class="fas fa-plus mr-1"></i>

                    Tambah User

                </a>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped mb-0">

                    <thead class="bg-light">

                        <tr>

                            <th width="60"
                                class="text-center">

                                No

                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th width="120"
                                class="text-center">

                                Status

                            </th>

                            <th width="120"
                                class="text-center">

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


                                {{-- ROLE --}}
                                <td class="align-middle">

                                    @if ($user->roles->count())

                                        @foreach ($user->roles as $role)

                                            @php

                                                $roleClass = match ($role->name) {

                                                    'Super Admin'
                                                        => 'danger',

                                                    'Admin'
                                                        => 'primary',

                                                    'Staff Administrasi'
                                                        => 'info',

                                                    'Bendahara'
                                                        => 'success',

                                                    'Instruktur'
                                                        => 'warning',

                                                    'Peserta'
                                                        => 'secondary',

                                                    default
                                                        => 'dark',

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

                                    <div class="btn-group">

                                        {{-- EDIT --}}
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="btn btn-warning btn-sm"
                                            title="Edit User">

                                            <i class="fas fa-edit"></i>

                                        </a>


                                        {{-- HAPUS --}}
                                        <form action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus User"
                                                onclick="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fas fa-users-slash fa-3x mb-3"></i>

                                        <h5>
                                            Belum Ada User
                                        </h5>

                                        <p class="mb-3">
                                            Belum ada akun pengguna yang terdaftar.
                                        </p>

                                        <a href="{{ route('users.create') }}"
                                            class="btn btn-primary">

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

@stop