@extends('adminlte::page')

@section('title', 'Program')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-graduation-cap mr-2"></i>
                Data Program
            </h1>

            <p class="text-muted mb-0">
                Kelola data program pelatihan LPK Mirai Gresik
            </p>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createProgramModal">

                <i class="fas fa-plus mr-1"></i>
                Tambah Program

            </button>
        </div>

    </div>

@stop


@section('content')


    {{-- =========================================================
         RINGKASAN
    ========================================================== --}}

    <div class="row">

        <div class="col-lg-4 col-md-6">

            <x-adminlte-small-box title="{{ $programs->count() }}" text="Total Program" icon="fas fa-graduation-cap"
                theme="info" />

        </div>


        <div class="col-lg-4 col-md-6">

            <x-adminlte-small-box title="{{ $programs->where('is_active', true)->count() }}" text="Program Aktif"
                icon="fas fa-check-circle" theme="success" />

        </div>

    </div>



    {{-- =========================================================
         DATA PROGRAM
    ========================================================== --}}

    <x-adminlte-card theme="primary" icon="fas fa-list" collapsible>

        {{-- HEADER CARD --}}

        <x-slot name="toolsSlot">

            <span class="text-muted small text-white">

                Menampilkan
                <strong>
                    {{ $programs->count() }}
                </strong>
                program

            </span>

        </x-slot>


        {{-- JUDUL --}}

        <div class="mb-3">

            <h5 class="font-weight-bold mb-1">

                <i class="fas fa-graduation-cap text-primary mr-1"></i>

                Daftar Program

            </h5>

            <small class="text-muted">

                Daftar program pelatihan yang tersedia di
                LPK Mirai Gresik.

            </small>

        </div>



        {{-- TABEL --}}

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="bg-light">

                    <tr>

                        <th width="60" class="text-center">
                            No
                        </th>

                        <th width="120">
                            Kode
                        </th>

                        <th>
                            Nama Program
                        </th>

                        <th width="120" class="text-center">
                            Status
                        </th>

                        <th width="180" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($programs as $program)
                        <tr>

                            {{-- NO --}}

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>


                            {{-- KODE --}}

                            <td>

                                <span class="badge badge-secondary px-2 py-1">

                                    {{ $program->code }}

                                </span>

                            </td>


                            {{-- PROGRAM --}}

                            <td>

                                <div class="font-weight-bold">

                                    {{ $program->name }}

                                </div>

                            </td>


                            {{-- STATUS --}}

                            <td class="text-center">

                                @if ($program->is_active)
                                    <span class="badge badge-success px-2 py-1">

                                        <i class="fas fa-check-circle mr-1"></i>

                                        Aktif

                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">

                                        <i class="fas fa-times-circle mr-1"></i>

                                        Nonaktif

                                    </span>
                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="text-center">

                                <div class="btn-group">

                                    {{-- DETAIL --}}
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#showProgramModal-{{ $program->id }}" title="Detail">

                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- EDIT --}}
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editProgramModal-{{ $program->id }}" title="Edit">

                                        <i class="fas fa-edit"></i>
                                    </button>


                                    {{-- HAPUS --}}
                                    @if ($program->classrooms_count == 0)
                                        <form action="{{ route('programs.destroy', $program) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus program ini?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Program sudah memiliki kelas">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center py-4">

                                <div class="text-muted">

                                    <i class="fas fa-inbox fa-2x mb-2"></i>

                                    <br>

                                    Belum ada data program.

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


    </x-adminlte-card>

    {{-- =========================================================
        MODAL PROGRAM
    ========================================================== --}}

    {{-- CREATE --}}
    @include('programs.partials.create-modal')

    {{-- EDIT & SHOW --}}
    @foreach ($programs as $program)
        @include('programs.partials.edit-modal', [
            'program' => $program,
        ])

        @include('programs.partials.show-modal', [
            'program' => $program,
        ])
    @endforeach


    @section('js')

        <script>
            $(document).ready(function() {

                // Buka kembali modal jika validasi gagal
                @if ($errors->any())

                    const formContext = @json(old('form_context'));
                    const programId = @json(old('program_id'));

                    if (formContext === 'edit' && programId) {

                        $('#editProgramModal-' + programId).modal('show');

                    } else if (formContext === 'create') {

                        $('#createProgramModal').modal('show');

                    }
                @endif

            });

            // Mengelola fokus modal agar tidak muncul warning aria-hidden
            $(document).on('show.bs.modal', '.modal', function(event) {

                $(this).data(
                    'modal-trigger',
                    event.relatedTarget || document.activeElement
                );

            });

            $(document).on('hide.bs.modal', '.modal', function() {

                const activeElement = document.activeElement;

                if (activeElement && this.contains(activeElement)) {
                    activeElement.blur();
                }

            });

            $(document).on('hidden.bs.modal', '.modal', function() {

                const trigger = $(this).data('modal-trigger');

                if (trigger && document.contains(trigger)) {
                    trigger.focus();
                }

                $(this).removeData('modal-trigger');

            });
        </script>

    @stop

@stop
