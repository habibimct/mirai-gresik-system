@extends('adminlte::page')

@section('title', 'Tambah Program Peserta')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">
                Tambah Program Peserta
            </h1>

            <small class="text-muted">
                Daftarkan peserta ke gelombang dan program pelatihan
            </small>
        </div>

        <a
            href="{{ route('participants.programs.index', $participant) }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </div>

@stop


@section('content')


    {{-- =========================================================
        ERROR VALIDASI
    ========================================================== --}}

    @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Data belum dapat disimpan
            </h5>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button
                type="button"
                class="close"
                data-dismiss="alert"
            >
                <span>&times;</span>
            </button>

        </div>

    @endif


    {{-- =========================================================
        FORM
    ========================================================== --}}

    <div class="card card-primary">


        {{-- HEADER --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-plus mr-1"></i>

                Pendaftaran Program Peserta

            </h3>

        </div>


        <form
            id="programForm"
            action="{{ route('participants.programs.store', $participant) }}"
            method="POST"
        >

            @csrf


            <div class="card-body">


                {{-- =================================================
                    DATA PESERTA
                ================================================== --}}

                <h5 class="text-primary mb-3">

                    <i class="fas fa-user-circle mr-1"></i>

                    Data Peserta

                </h5>


                <div class="row">


                    <div class="col-md-8">

                        <div class="form-group">

                            <label>
                                Nama Peserta
                            </label>

                            <div class="input-group">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $participant->user->name }}"
                                    readonly
                                >

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                ID Peserta
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="#{{ str_pad($participant->id, 5, '0', STR_PAD_LEFT) }}"
                                readonly
                            >

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =================================================
                    PILIH GELOMBANG
                ================================================== --}}

                <h5 class="text-primary mb-3">

                    <i class="fas fa-layer-group mr-1"></i>

                    Pilih Gelombang

                </h5>


                <div class="row">

                    <div class="col-md-8">

                        <div class="form-group">

                            <label for="wave_id">

                                Gelombang
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                id="wave_id"
                                class="form-control @error('wave_id') is-invalid @enderror"
                            >

                                <option value="">
                                    -- Pilih Gelombang --
                                </option>

                                @foreach ($waves as $wave)

                                    <option
                                        value="{{ $wave->id }}"
                                        data-name="{{ $wave->name }}"
                                        {{ old('wave_id') == $wave->id ? 'selected' : '' }}
                                    >
                                        {{ $wave->name }}
                                        @if ($wave->year)
                                            ({{ $wave->year }})
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                            @error('wave_id')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    PROGRAM TERSEDIA
                ================================================== --}}

                <hr>


                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="text-primary mb-0">

                        <i class="fas fa-book mr-1"></i>

                        Program Tersedia

                    </h5>

                    <span
                        id="program-count"
                        class="badge badge-secondary"
                    >
                        Belum dipilih
                    </span>

                </div>


                <div
                    id="program-list"
                    class="border rounded p-3"
                >

                    <div class="text-center text-muted py-4">

                        <i class="fas fa-layer-group fa-2x mb-2"></i>

                        <div>
                            Pilih gelombang terlebih dahulu.
                        </div>

                    </div>

                </div>


            </div>


            {{-- =================================================
                FOOTER
            ================================================== --}}

            <div class="card-footer d-flex justify-content-end">

                <a
                    href="{{ route('participants.programs.index', $participant) }}"
                    class="btn btn-secondary mr-1"
                >

                    <i class="fas fa-times mr-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    id="saveButton"
                    class="btn btn-primary"
                    disabled
                >

                    <i class="fas fa-save mr-1"></i>

                    Simpan Program

                </button>

            </div>


        </form>

    </div>

@stop



@section('css')

<style>

    /*
    |--------------------------------------------------------------------------
    | PROGRAM TABLE
    |--------------------------------------------------------------------------
    */

    #program-list {
        background-color: #fafafa;
    }

    #program-list table {
        margin-bottom: 0;
    }

    #program-list tbody tr {
        transition: background-color .15s ease;
    }

    #program-list tbody tr:hover {
        background-color: #f4f6f9;
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKBOX
    |--------------------------------------------------------------------------
    */

    .program-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRAM NAME
    |--------------------------------------------------------------------------
    */

    .program-name {
        font-weight: 600;
    }

    /*
    |--------------------------------------------------------------------------
    | EMPTY STATE
    |--------------------------------------------------------------------------
    */

    .empty-program {
        padding: 35px 15px;
        text-align: center;
    }

</style>

@stop



@section('js')

<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const waveSelect   = $('#wave_id');
    const programList  = $('#program-list');
    const programCount = $('#program-count');
    const saveButton   = $('#saveButton');


    /*
    |--------------------------------------------------------------------------
    | UPDATE BUTTON
    |--------------------------------------------------------------------------
    */

    function updateSaveButton() {

        const checked = $('input[name="wave_programs[]"]:checked').length;

        if (checked > 0) {

            saveButton.prop('disabled', false);

            programCount
                .removeClass('badge-secondary')
                .addClass('badge-success')
                .text(checked + ' program dipilih');

        } else {

            saveButton.prop('disabled', true);

            programCount
                .removeClass('badge-success')
                .addClass('badge-secondary')
                .text('Belum dipilih');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | LOAD PROGRAM
    |--------------------------------------------------------------------------
    */

    waveSelect.change(function () {


        let waveId = $(this).val();

        let waveName =
            $(this).find(':selected').data('name') || '';


        saveButton.prop('disabled', true);

        programCount
            .removeClass('badge-success')
            .addClass('badge-secondary')
            .text('Belum dipilih');


        /*
        |--------------------------------------------------------------------------
        | BELUM MEMILIH GELOMBANG
        |--------------------------------------------------------------------------
        */

        if (!waveId) {

            programList.html(`

                <div class="empty-program text-muted">

                    <i class="fas fa-layer-group fa-2x mb-2"></i>

                    <div>
                        Pilih gelombang terlebih dahulu.
                    </div>

                </div>

            `);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | LOADING
        |--------------------------------------------------------------------------
        */

        programList.html(`

            <div class="text-center py-4">

                <div
                    class="spinner-border text-primary mb-2"
                    role="status"
                >
                    <span class="sr-only">
                        Loading...
                    </span>
                </div>

                <div class="text-muted">
                    Memuat program tersedia...
                </div>

            </div>

        `);


        /*
        |--------------------------------------------------------------------------
        | REQUEST
        |--------------------------------------------------------------------------
        */

        $.get(

            '/participants/{{ $participant->id }}/waves/'
            + waveId
            + '/available-programs',

            function (data) {


                /*
                |--------------------------------------------------------------------------
                | TIDAK ADA PROGRAM
                |--------------------------------------------------------------------------
                */

                if (data.length === 0) {

                    programList.html(`

                        <div class="alert alert-success mb-0">

                            <h5>
                                <i class="fas fa-check-circle mr-1"></i>
                                Semua Program Sudah Terdaftar
                            </h5>

                            <p class="mb-0">

                                Peserta
                                <strong>
                                    {{ $participant->user->name }}
                                </strong>

                                sudah terdaftar pada seluruh program
                                yang tersedia di

                                <strong>
                                    ${waveName}
                                </strong>.

                            </p>

                        </div>

                    `);

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | TABLE
                |--------------------------------------------------------------------------
                */

                let html = `

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="bg-light">

                                <tr>

                                    <th
                                        width="50"
                                        class="text-center"
                                    >
                                        Pilih
                                    </th>

                                    <th>
                                        Program
                                    </th>

                                    <th
                                        width="130"
                                        class="text-right"
                                    >
                                        Biaya
                                    </th>

                                    <th
                                        width="80"
                                        class="text-center"
                                    >
                                        Kuota
                                    </th>

                                    <th
                                        width="80"
                                        class="text-center"
                                    >
                                        Terisi
                                    </th>

                                    <th
                                        width="90"
                                        class="text-center"
                                    >
                                        Sisa
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                `;


                /*
                |--------------------------------------------------------------------------
                | PROGRAM DATA
                |--------------------------------------------------------------------------
                */

                data.forEach(function (item) {


                    let remaining = Number(item.remaining);

                    let quotaBadge = '';


                    /*
                    |--------------------------------------------------------------------------
                    | QUOTA STATUS
                    |--------------------------------------------------------------------------
                    */

                    if (remaining <= 0) {

                        quotaBadge = `
                            <span class="badge badge-danger">
                                Penuh
                            </span>
                        `;

                    } else if (remaining <= 5) {

                        quotaBadge = `
                            <span class="badge badge-warning">
                                ${remaining}
                            </span>
                        `;

                    } else {

                        quotaBadge = `
                            <span class="badge badge-success">
                                ${remaining}
                            </span>
                        `;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ROW
                    |--------------------------------------------------------------------------
                    */

                    html += `

                        <tr>

                            <td class="text-center">

                                <input
                                    type="checkbox"
                                    class="program-checkbox"
                                    name="wave_programs[]"
                                    value="${item.id}"
                                    ${remaining <= 0 ? 'disabled' : ''}
                                >

                            </td>


                            <td>

                                <span class="program-name">
                                    ${item.program}
                                </span>

                            </td>


                            <td class="text-right">

                                Rp
                                ${Number(item.fee)
                                    .toLocaleString('id-ID')}

                            </td>


                            <td class="text-center">
                                ${item.quota}
                            </td>


                            <td class="text-center">
                                ${item.filled}
                            </td>


                            <td class="text-center">

                                ${quotaBadge}

                            </td>

                        </tr>

                    `;

                });


                html += `

                            </tbody>

                        </table>

                    </div>


                    <div class="mt-3 text-muted small">

                        <i class="fas fa-info-circle mr-1"></i>

                        Pilih satu atau lebih program yang ingin
                        didaftarkan untuk peserta.

                    </div>

                `;


                programList.html(html);


                /*
                |--------------------------------------------------------------------------
                | CHECKBOX EVENT
                |--------------------------------------------------------------------------
                */

                $('input[name="wave_programs[]"]').on(
                    'change',
                    updateSaveButton
                );


                updateSaveButton();


            }

        ).fail(function () {


            /*
            |--------------------------------------------------------------------------
            | ERROR REQUEST
            |--------------------------------------------------------------------------
            */

            programList.html(`

                <div class="alert alert-danger mb-0">

                    <h5>

                        <i class="fas fa-exclamation-triangle mr-1"></i>

                        Gagal Memuat Data

                    </h5>

                    <p class="mb-0">

                        Program tidak dapat dimuat.
                        Silakan coba kembali.

                    </p>

                </div>

            `);

        });


    });


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

    $('#programForm').submit(function (e) {


        const checked =
            $('input[name="wave_programs[]"]:checked').length;


        if (checked === 0) {

            e.preventDefault();


            Swal.fire({

                icon: 'warning',

                title: 'Program Belum Dipilih',

                text: 'Silakan pilih minimal satu program terlebih dahulu.',

                confirmButtonText: 'Mengerti'

            });

            return false;

        }


        saveButton.prop('disabled', true);

        saveButton.html(`

            <span
                class="spinner-border spinner-border-sm mr-1"
                role="status"
            ></span>

            Menyimpan...

        `);

    });


});

</script>

@stop