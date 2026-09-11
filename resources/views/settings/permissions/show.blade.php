@extends('adminlte::page')

@section('title', 'Detail Permission')

@section('content_header')

    <h1>
        <i class="fas fa-key mr-1"></i>
        Detail Permission
    </h1>

@stop


@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-key mr-1"></i>

                {{ $permission->name }}

            </h3>

        </div>


        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="200">
                        Nama Permission
                    </th>

                    <td>
                        {{ $permission->name }}
                    </td>

                </tr>


                <tr>

                    <th>
                        Guard
                    </th>

                    <td>

                        <span class="badge badge-secondary">

                            {{ $permission->guard_name }}

                        </span>

                    </td>

                </tr>


                <tr>

                    <th>
                        Digunakan Oleh
                    </th>

                    <td>

                        @forelse($permission->roles as $role)

                            <span class="badge badge-info mr-1">

                                {{ $role->name }}

                            </span>

                        @empty

                            <span class="text-muted">

                                Belum digunakan oleh role.

                            </span>

                        @endforelse

                    </td>

                </tr>

            </table>

        </div>


        <div class="card-footer">

            <a href="{{ route('settings.permissions.edit', $permission) }}"
               class="btn btn-warning">

                <i class="fas fa-edit mr-1"></i>

                Edit

            </a>


            <a href="{{ route('settings.permissions.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>

                Kembali

            </a>

        </div>

    </div>

@stop