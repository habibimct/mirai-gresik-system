@extends('adminlte::page')

@section('title', 'Riwayat Aktivitas')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mgs-sidebar.css') }}">
@stop

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                Riwayat Aktivitas
            </h1>

            <p class="text-muted mb-0">
                Seluruh aktivitas pengguna dalam sistem.
            </p>

        </div>


        <div>

            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                <i class="fas fa-home mr-1"></i>
                Dashboard
            </a>

        </div>

    </div>

@stop


@section('content')


    {{-- ========================================================= --}}
    {{-- FILTER --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-filter mr-1"></i>

                Filter Aktivitas

            </h3>

        </div>


        <form method="GET">

            <div class="card-body">

                <div class="row">


                    {{-- USER --}}

                    <div class="col-md-3">

                        <label>User</label>

                        <select name="user" class="form-control">

                            <option value="">
                                Semua User
                            </option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>

                                    {{ $user->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- EVENT --}}

                    <div class="col-md-3">

                        <label>Aktivitas</label>

                        <select name="event" class="form-control">

                            <option value="">
                                Semua Aktivitas
                            </option>

                            <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>
                                CREATE
                            </option>

                            <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>
                                UPDATE
                            </option>

                            <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>
                                DELETE
                            </option>

                        </select>

                    </div>


                    {{-- TANGGAL --}}

                    <div class="col-md-3">

                        <label>Tanggal</label>

                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">

                    </div>


                    {{-- BUTTON --}}

                    <div class="col-md-3 d-flex align-items-end">

                        <button type="submit" class="btn btn-primary mr-2">

                            <i class="fas fa-search mr-1"></i>

                            Filter

                        </button>


                        <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>



    {{-- ========================================================= --}}
    {{-- ACTIVITY TABLE --}}
    {{-- ========================================================= --}}

    <div class="card card-outline card-primary">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-history mr-1"></i>

                Daftar Aktivitas

            </h3>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped mb-0">

                    <thead>

                        <tr>

                            <th style="width: 145px;">
                                Waktu
                            </th>

                            <th style="width: 180px;">
                                User
                            </th>

                            <th style="width: 110px;">
                                Aktivitas
                            </th>

                            <th>
                                Detail Aktivitas
                            </th>

                            <th style="width: 90px;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($activities as $activity)

                            @php

                                $subjectName = 'Data';

                                if ($activity->properties) {
                                    $properties = $activity->properties;

                                    if ($activity->event === 'updated') {
                                        $old = $properties['old'] ?? [];

                                        $attributes = $properties['attributes'] ?? [];

                                        $subjectName =
                                            $attributes['name'] ??
                                            ($attributes['nama'] ??
                                                ($attributes['title'] ??
                                                    ($old['name'] ?? ($old['nama'] ?? ($old['title'] ?? null)))));
                                    } else {
                                        $attributes = $properties['attributes'] ?? [];

                                        $subjectName =
                                            $attributes['name'] ??
                                            ($attributes['nama'] ??
                                                ($attributes['title'] ??
                                                    ($attributes['invoice_number'] ??
                                                        ($attributes['invoice_no'] ??
                                                            ($attributes['payment_number'] ??
                                                                ($attributes['payment_no'] ?? null))))));
                                    }
                                }

                                if (!$subjectName) {
                                    $subjectName =
                                        class_basename($activity->subject_type) . ' #' . $activity->subject_id;
                                }
                            @endphp


                            <tr>


                                {{-- WAKTU --}}

                                <td>

                                    <strong>

                                        {{ $activity->created_at->format('d/m/Y') }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ $activity->created_at->format('H:i:s') }}

                                    </small>

                                </td>


                                {{-- USER --}}

                                <td>

                                    @if ($activity->causer)
                                        <strong>

                                            {{ $activity->causer->name }}

                                        </strong>

                                        <br>

                                        @if (method_exists($activity->causer, 'getRoleNames'))
                                            <span class="badge badge-secondary">

                                                {{ $activity->causer->getRoleNames()->first() ?? '-' }}

                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted">

                                            System

                                        </span>
                                    @endif

                                </td>


                                {{-- EVENT --}}

                                <td>

                                    @switch($activity->event)
                                        @case('created')
                                            <span class="badge badge-success">

                                                <i class="fas fa-plus mr-1"></i>

                                                CREATE

                                            </span>
                                        @break

                                        @case('updated')
                                            <span class="badge badge-primary">

                                                <i class="fas fa-edit mr-1"></i>

                                                UPDATE

                                            </span>
                                        @break

                                        @case('deleted')
                                            <span class="badge badge-danger">

                                                <i class="fas fa-trash mr-1"></i>

                                                DELETE

                                            </span>
                                        @break

                                        @default
                                            <span class="badge badge-secondary">

                                                {{ strtoupper($activity->event) }}

                                            </span>
                                    @endswitch

                                </td>


                                {{-- DETAIL RINGKAS --}}

                                <td>

                                    @php

                                        $modelName = class_basename($activity->subject_type);

                                        $modelLabels = [
                                            'Participant' => 'Peserta',

                                            'Classroom' => 'Classroom',

                                            'ParticipantClassroom' => 'Peserta Classroom',

                                            'Program' => 'Program',

                                            'Wave' => 'Gelombang',

                                            'FeeSetting' => 'Pengaturan Biaya',

                                            'WaveFeeSetting' => 'Pengaturan Biaya Gelombang',

                                            'ParticipantInvoice' => 'Invoice Peserta',

                                            'Payment' => 'Pembayaran',

                                            'AttendanceSession' => 'Sesi Absensi',

                                            'ScoreSession' => 'Sesi Nilai',

                                            'ScoreType' => 'Jenis Nilai',

                                            'User' => 'User',
                                        ];

                                        $modelLabel = $modelLabels[$modelName] ?? $modelName;

                                    @endphp


                                    @if ($activity->event === 'created')
                                        Membuat
                                        <strong>
                                            {{ $modelLabel }}
                                        </strong>

                                        @if ($subjectName)
                                            "{{ $subjectName }}"
                                        @endif
                                    @elseif($activity->event === 'updated')
                                        Mengubah
                                        <strong>
                                            {{ $modelLabel }}
                                        </strong>

                                        @if ($subjectName)
                                            "{{ $subjectName }}"
                                        @endif
                                    @elseif($activity->event === 'deleted')
                                        Menghapus
                                        <strong>
                                            {{ $modelLabel }}
                                        </strong>

                                        @if ($subjectName)
                                            "{{ $subjectName }}"
                                        @endif
                                    @else
                                        {{ $activity->description }}
                                    @endif

                                </td>


                                {{-- DETAIL BUTTON --}}

                                <td>

                                    <button type="button" class="btn btn-sm btn-info btn-activity-detail"
                                        data-toggle="modal" data-target="#activityDetailModal"
                                        data-id="{{ $activity->id }}"
                                        data-user="{{ $activity->causer->name ?? 'System' }}"
                                        data-role="{{ $activity->causer ? $activity->causer->getRoleNames()->first() ?? '-' : '-' }}"
                                        data-event="{{ $activity->event }}" data-model="{{ $modelLabel }}"
                                        data-subject-id="{{ $activity->subject_id }}"
                                        data-subject-name="{{ $subjectName }}"
                                        data-date="{{ $activity->created_at->format('d/m/Y H:i:s') }}">

                                        <i class="fas fa-eye mr-1"></i>

                                        Detail

                                    </button>

                                </td>

                            </tr>



                            @empty

                                <tr>

                                    <td colspan="5" class="text-center p-4">

                                        <i class="fas fa-history fa-2x text-muted"></i>

                                        <p class="mt-2 mb-0">

                                            Belum ada aktivitas.

                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>







            {{-- ========================================================= --}}
            {{-- MODAL DETAIL AKTIVITAS --}}
            {{-- ========================================================= --}}

            <div class="modal fade" id="activityDetailModal" tabindex="-1" role="dialog"
                aria-labelledby="activityDetailModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                    <div class="modal-content">


                        {{-- HEADER --}}

                        <div class="modal-header">

                            <h5 class="modal-title" id="activityDetailModalLabel">

                                <i class="fas fa-history mr-2"></i>

                                Detail Aktivitas

                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        {{-- BODY --}}

                        <div class="modal-body">


                            {{-- INFORMASI --}}

                            <div class="row">

                                <div class="col-md-6">

                                    <table class="table table-sm table-borderless">

                                        <tr>

                                            <th width="120">
                                                User
                                            </th>

                                            <td id="detailUser">
                                                -
                                            </td>

                                        </tr>

                                        <tr>

                                            <th>
                                                Role
                                            </th>

                                            <td id="detailRole">
                                                -
                                            </td>

                                        </tr>

                                        <tr>

                                            <th>
                                                Aktivitas
                                            </th>

                                            <td id="detailEvent">
                                                -
                                            </td>

                                        </tr>

                                    </table>

                                </div>


                                <div class="col-md-6">

                                    <table class="table table-sm table-borderless">

                                        <tr>

                                            <th width="120">
                                                Data
                                            </th>

                                            <td>

                                                <span id="detailModel">
                                                    -
                                                </span>

                                                #

                                                <span id="detailSubjectId">
                                                    -
                                                </span>

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Nama
                                            </th>

                                            <td id="detailSubjectName">
                                                -
                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Waktu
                                            </th>

                                            <td id="detailDate">
                                                -
                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>


                            <hr>


                            {{-- DETAIL PERUBAHAN --}}

                            <div id="activityChanges">

                                <div class="text-center text-muted py-3">

                                    <i class="fas fa-spinner fa-spin"></i>

                                    Memuat detail...

                                </div>

                            </div>


                        </div>


                        {{-- FOOTER --}}

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                <i class="fas fa-times mr-1"></i>

                                Tutup

                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PAGINATION --}}

            @if ($activities->hasPages())
                <div class="card-footer">

                    {{ $activities->links() }}

                </div>
            @endif

        </div>



    @stop



    @section('js')

        <script>
            $(document).on('click', '.btn-activity-detail', function() {

                const button = $(this);

                const activityId =
                    button.data('id');


                /*
                |--------------------------------------------------------------------------
                | INFORMASI DASAR
                |--------------------------------------------------------------------------
                */

                $('#detailUser')
                    .text(button.data('user'));

                $('#detailRole')
                    .text(button.data('role'));

                $('#detailModel')
                    .text(button.data('model'));

                $('#detailSubjectId')
                    .text(button.data('subject-id'));

                $('#detailSubjectName')
                    .text(button.data('subject-name'));

                $('#detailDate')
                    .text(button.data('date'));


                /*
                |--------------------------------------------------------------------------
                | EVENT
                |--------------------------------------------------------------------------
                */

                const event =
                    button.data('event');


                let eventBadge = '';


                if (event === 'created') {

                    eventBadge =
                        '<span class="badge badge-success">' +
                        '<i class="fas fa-plus mr-1"></i>' +
                        'CREATE' +
                        '</span>';

                } else if (event === 'updated') {

                    eventBadge =
                        '<span class="badge badge-primary">' +
                        '<i class="fas fa-edit mr-1"></i>' +
                        'UPDATE' +
                        '</span>';

                } else if (event === 'deleted') {

                    eventBadge =
                        '<span class="badge badge-danger">' +
                        '<i class="fas fa-trash mr-1"></i>' +
                        'DELETE' +
                        '</span>';

                } else {

                    eventBadge =
                        '<span class="badge badge-secondary">' +
                        event.toUpperCase() +
                        '</span>';

                }


                $('#detailEvent')
                    .html(eventBadge);


                /*
                |--------------------------------------------------------------------------
                | LOADING
                |--------------------------------------------------------------------------
                */

                $('#activityChanges').html(`
        <div class="text-center text-muted py-4">

            <i class="fas fa-spinner fa-spin fa-2x"></i>

            <div class="mt-2">
                Memuat detail aktivitas...
            </div>

        </div>
    `);


                /*
                |--------------------------------------------------------------------------
                | AMBIL DETAIL
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url: '{{ url('/activity-logs') }}/' +
                        activityId,

                    type: 'GET',

                    success: function(data) {

                        let html = '';


                        /*
                        |--------------------------------------------------------------------------
                        | PROPERTIES
                        |--------------------------------------------------------------------------
                        */

                        const properties =
                            data.properties || {};


                        const oldData =
                            properties.old || {};


                        const newData =
                            properties.attributes || {};


                        /*
                        |--------------------------------------------------------------------------
                        | CREATE
                        |--------------------------------------------------------------------------
                        */

                        if (data.event === 'created') {

                            html += `

                    <h5>

                        <i class="fas fa-plus-circle text-success mr-1"></i>

                        Data yang dibuat

                    </h5>

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm">

                            <thead>

                                <tr>

                                    <th>Field</th>

                                    <th>Nilai</th>

                                </tr>

                            </thead>

                            <tbody>
                `;


                            $.each(newData, function(
                                field,
                                value
                            ) {

                                html += `

                        <tr>

                            <td>
                                <strong>
                                    ${formatField(field)}
                                </strong>
                            </td>

                            <td>
                                ${formatValue(value)}
                            </td>

                        </tr>

                    `;

                            });


                            html += `

                            </tbody>

                        </table>

                    </div>

                `;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | UPDATE
                        |--------------------------------------------------------------------------
                        */
                        else if (data.event === 'updated') {

                            html += `

                    <h5>

                        <i class="fas fa-edit text-primary mr-1"></i>

                        Perubahan Data

                    </h5>

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm">

                            <thead>

                                <tr>

                                    <th>Field</th>

                                    <th>Sebelum</th>

                                    <th>Sesudah</th>

                                </tr>

                            </thead>

                            <tbody>
                `;


                            $.each(newData, function(
                                field,
                                newValue
                            ) {

                                const oldValue =
                                    oldData[field] ?? null;


                                html += `

                        <tr>

                            <td>

                                <strong>
                                    ${formatField(field)}
                                </strong>

                            </td>

                            <td>

                                <span class="text-danger">

                                    ${formatValue(oldValue)}

                                </span>

                            </td>

                            <td>

                                <span class="text-success">

                                    ${formatValue(newValue)}

                                </span>

                            </td>

                        </tr>

                    `;

                            });


                            html += `

                            </tbody>

                        </table>

                    </div>

                `;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | DELETE
                        |--------------------------------------------------------------------------
                        */
                        else if (data.event === 'deleted') {

                            const deletedData =
                                Object.keys(oldData).length ?
                                oldData :
                                newData;


                            html += `

                    <h5>

                        <i class="fas fa-trash text-danger mr-1"></i>

                        Data yang dihapus

                    </h5>

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm">

                            <thead>

                                <tr>

                                    <th>Field</th>

                                    <th>Nilai</th>

                                </tr>

                            </thead>

                            <tbody>
                `;


                            $.each(
                                deletedData,
                                function(
                                    field,
                                    value
                                ) {

                                    html += `

                            <tr>

                                <td>
                                    <strong>
                                        ${formatField(field)}
                                    </strong>
                                </td>

                                <td>
                                    ${formatValue(value)}
                                </td>

                            </tr>

                        `;

                                }
                            );


                            html += `

                            </tbody>

                        </table>

                    </div>

                `;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | DESCRIPTION
                        |--------------------------------------------------------------------------
                        */

                        html += `

                <div class="alert alert-light border mt-3">

                    <strong>
                        Keterangan:
                    </strong>

                    <br>

                    ${escapeHtml(
                        data.description || '-'
                    )}

                </div>

            `;


                        $('#activityChanges')
                            .html(html);

                    },

                    error: function() {

                        $('#activityChanges').html(`

                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-triangle mr-1"></i>

                    Gagal mengambil detail aktivitas.

                </div>

            `);

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | FORMAT FIELD
            |--------------------------------------------------------------------------
            */

            function formatField(field) {
                return field
                    .replace(/_/g, ' ')
                    .replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
            }


            /*
            |--------------------------------------------------------------------------
            | FORMAT VALUE
            |--------------------------------------------------------------------------
            */

            function formatValue(value) {
                if (
                    value === null ||
                    value === undefined ||
                    value === ''
                ) {

                    return '<span class="text-muted">-</span>';

                }


                if (typeof value === 'object') {

                    return escapeHtml(
                        JSON.stringify(value)
                    );

                }


                return escapeHtml(
                    String(value)
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ESCAPE HTML
            |--------------------------------------------------------------------------
            */

            function escapeHtml(text) {
                return $('<div>')
                    .text(text)
                    .html();
            }
        </script>

    @stop
