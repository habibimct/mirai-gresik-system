@extends('adminlte::page')

@section('title', 'Permission')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <h1>
            <i class="fas fa-key mr-1"></i>
            Permission
        </h1>

        {{-- <a href="{{ route('settings.permissions.create') }}"
           class="btn btn-primary">

            <i class="fas fa-plus"></i>
            Tambah Permission

        </a> --}}

    </div>

@stop


@section('content')

    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- Permission Table --}}
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-list mr-1"></i>

                Daftar Permission

            </h3>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Permission
                            </th>

                            <th width="180">
                                Guard
                            </th>

                            <th width="160">
                                Digunakan Role
                            </th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($permissions as $permission)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <i class="fas fa-key text-warning mr-1"></i>

                                    <strong>
                                        {{ $permission->name }}
                                    </strong>

                                </td>


                                <td>

                                    <span class="badge badge-secondary">

                                        {{ $permission->guard_name }}

                                    </span>

                                </td>


                                <td>

                                    <span class="badge badge-info">

                                        {{ $permission->roles_count }}

                                        Role

                                    </span>

                                </td>


                                <td>

                                    {{-- Show --}}

                                    <a href="{{ route('settings.permissions.show', $permission) }}"
                                       class="btn btn-sm btn-info"
                                       title="Lihat">

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    {{-- Edit --}}

                                    {{-- <a href="{{ route('settings.permissions.edit', $permission) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">

                                        <i class="fas fa-edit"></i>

                                    </a> --}}


                                    {{-- Delete --}}

                                    {{-- <form
                                        action="{{ route('settings.permissions.destroy', $permission) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus permission {{ $permission->name }}?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form> --}}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-4">

                                    <i class="fas fa-info-circle mr-1"></i>

                                    Belum ada permission.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@stop