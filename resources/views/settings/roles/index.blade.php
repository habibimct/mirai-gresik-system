@extends('adminlte::page')

@section('title', 'Role & Akses')

@section('content_header')


    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">
                Role & Akses
            </h1>

            <small class="text-muted">
                Daftar role dan hak akses pengguna sistem
            </small>
        </div>

    </div>


@stop

@section('content')


    {{-- =========================================================
     INFORMASI
     ========================================================= --}}

    <div class="alert alert-info">

        <i class="fas fa-info-circle mr-2"></i>

        <strong>Informasi:</strong>

        Role sistem bersifat tetap dan digunakan sebagai dasar
        pengaturan akses pengguna. Nama role tidak diubah melalui
        halaman User.

    </div>


    {{-- =========================================================
     DAFTAR ROLE
     ========================================================= --}}

    <div class="card card-outline card-primary">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-shield mr-2"></i>

                Daftar Role Sistem

            </h3>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="thead-light">

                        <tr>

                            <th width="60" class="text-center">
                                No
                            </th>

                            <th width="220">
                                Role
                            </th>

                            <th width="120" class="text-center">
                                User
                            </th>

                            <th>
                                Akses
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($roles as $index => $role)

                            @php

                                $access = match ($role->name) {
                                    'Super Admin' => [
                                        'Dashboard',
                                        'Master Data',
                                        'Akademik',
                                        'Keuangan',
                                        'Laporan',
                                        'Pengaturan',
                                        'User & Role',
                                    ],

                                    'Admin' => ['Dashboard', 'Master Data', 'Akademik', 'Keuangan', 'Laporan'],

                                    'Staff Administrasi' => [
                                        'Dashboard',
                                        'Peserta',
                                        'Program',
                                        'Gelombang',
                                        'Kelas',
                                        'Laporan Peserta',
                                    ],

                                    'Bendahara' => ['Dashboard', 'Tagihan', 'Pembayaran', 'Laporan Keuangan'],

                                    'Instruktur' => ['Dashboard', 'Kelas', 'Absensi', 'Nilai', 'Laporan Akademik'],

                                    'Pengurus' => [
                                        'Dashboard',
                                        'Program',
                                        'Kelas',
                                        'Absensi',
                                        'Nilai',
                                        'Tagihan',
                                        'Pembayaran',
                                        'Laporan Peserta',
                                        'Laporan Akademik',
                                        'Laporan Keuangan',
                                    ],

                                    'Peserta' => [
                                        'Dashboard',
                                        'Profil',
                                        'Kelas',
                                        'Absensi',
                                        'Nilai',
                                        'Tagihan',
                                        'Pembayaran',
                                    ],

                                    default => [],
                                };

                            @endphp


                            <tr>

                                {{-- NO --}}

                                <td class="text-center">

                                    {{ $index + 1 }}

                                </td>


                                {{-- ROLE --}}

                                <td>

                                    @switch($role->name)
                                        @case('Super Admin')
                                            <span class="badge badge-danger">

                                                <i class="fas fa-user-shield mr-1"></i>

                                                {{ $role->name }}

                                            </span>
                                        @break

                                        @case('Admin')
                                            <span class="badge badge-primary">

                                                <i class="fas fa-user-cog mr-1"></i>

                                                {{ $role->name }}

                                            </span>
                                        @break

                                        @case('Pengurus')
                                            <span class="badge badge-info">

                                                <i class="fas fa-user-tie mr-1"></i>

                                                {{ $role->name }}

                                            </span>
                                        @break

                                        @case('Bendahara')
                                            <span class="badge badge-success">

                                                <i class="fas fa-money-bill-wave mr-1"></i>

                                                {{ $role->name }}

                                            </span>
                                        @break

                                        @case('Instruktur')
                                            <span class="badge badge-warning">

                                                <i class="fas fa-chalkboard-teacher mr-1"></i>

                                                {{ $role->name }}

                                            </span>
                                        @break

                                        @default
                                            <span class="badge badge-secondary">

                                                <i class="fas fa-user mr-1"></i>

                                                {{ $role->name }}

                                            </span>
                                    @endswitch

                                </td>


                                {{-- JUMLAH USER --}}

                                <td class="text-center">

                                    <span class="badge badge-light border">

                                        <i class="fas fa-users mr-1"></i>

                                        {{ $role->users_count }}

                                    </span>

                                </td>


                                {{-- AKSES --}}

                                <td>

                                    @if (count($access))
                                        @foreach ($access as $item)
                                            <span class="badge badge-light border mr-1 mb-1">

                                                <i class="fas fa-check text-success mr-1"></i>

                                                {{ $item }}

                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">

                                            Belum ada akses yang didefinisikan.

                                        </span>
                                    @endif

                                </td>

                            </tr>


                            @empty

                                <tr>

                                    <td colspan="4" class="text-center text-muted py-4">

                                        <i class="fas fa-user-shield fa-2x mb-2"></i>

                                        <br>

                                        Belum ada role.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


    @stop
