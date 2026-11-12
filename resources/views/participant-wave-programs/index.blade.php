@extends('adminlte::page')

@section('title', 'Program Peserta')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                Program Peserta
            </h1>

            <p class="text-muted mb-0">
                Kelola program dan penyesuaian biaya peserta.
            </p>

        </div>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createParticipantProgramModal">

            <i class="fas fa-plus mr-1"></i>
            Tambah Program

        </button>

    </div>

@stop


@section('content')


    {{-- =========================================================
         SUCCESS MESSAGE
         ========================================================= --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif



    {{-- =========================================================
         INFORMASI PESERTA
         ========================================================= --}}

    <div class="row">


        {{-- IDENTITAS PESERTA --}}

        <div class="col-md-8">

            <div class="card card-outline card-primary">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="mr-3">

                            <div class="participant-avatar">

                                <i class="fas fa-user"></i>

                            </div>

                        </div>

                        <div>

                            <h4 class="mb-1">

                                {{ $participant->user->name }}

                            </h4>

                            <div class="text-muted">

                                <i class="fas fa-envelope mr-1"></i>

                                {{ $participant->user->email }}

                            </div>

                            @if ($participant->nik)
                                <div class="text-muted mt-1">

                                    <i class="fas fa-id-card mr-1"></i>

                                    NIK: {{ $participant->nik }}

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- JUMLAH PROGRAM --}}

        <div class="col-md-4">

            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>
                        {{ $programs->count() }}
                    </h3>

                    <p>
                        Program Diikuti
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-graduation-cap"></i>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         DAFTAR PROGRAM
         ========================================================= --}}

    <div class="card card-outline card-primary">


        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-graduation-cap mr-1"></i>

                Daftar Program

            </h3>


            <div class="card-tools">

                <a href="{{ route('participants.index') }}" class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left mr-1"></i>

                    Kembali

                </a>

            </div>

        </div>



        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="55" class="text-center">

                                No

                            </th>

                            <th>

                                Gelombang

                            </th>

                            <th>

                                Program

                            </th>

                            <th width="160" class="text-right">

                                Biaya Standar

                            </th>

                            <th width="180" class="text-right">

                                Penyesuaian Khusus

                            </th>

                            <th width="180" class="text-right">

                                Biaya Peserta

                            </th>

                            <th width="120" class="text-center">

                                Status

                            </th>

                            <th width="110" class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @forelse ($programs as $item)
                            @php

                                $standardFee = (float) ($item->waveProgram->fee ?? 0);

                                $agreedFee = $item->agreed_fee !== null ? (float) $item->agreed_fee : null;

                                $participantFee = $agreedFee !== null ? $agreedFee : $standardFee;

                            @endphp


                            <tr>


                                {{-- NO --}}

                                <td class="text-center align-middle">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- GELOMBANG --}}

                                <td class="align-middle">

                                    <span class="font-weight-bold">

                                        {{ $item->waveProgram->wave->name }}

                                    </span>

                                </td>


                                {{-- PROGRAM --}}

                                <td class="align-middle">

                                    <i class="fas fa-book text-primary mr-1"></i>

                                    {{ $item->waveProgram->program->name }}

                                </td>


                                {{-- BIAYA STANDAR --}}

                                <td class="text-right align-middle">

                                    <span class="text-muted">

                                        Rp {{ number_format($item->standard_fee, 0, ',', '.') }}

                                    </span>

                                </td>


                                {{-- PENYESUAIAN KHUSUS --}}

                                <td class="text-right align-middle">

                                    @if ($agreedFee !== null)
                                        <span class="badge badge-warning mb-1">

                                            <i class="fas fa-sliders-h mr-1"></i>

                                            Khusus

                                        </span>

                                        <br>

                                        <strong class="text-warning">

                                            Rp
                                            {{ number_format($agreedFee, 0, ',', '.') }}

                                        </strong>
                                    @else
                                        <span class="text-muted">

                                            <i class="fas fa-minus mr-1"></i>

                                            Tidak ada

                                        </span>
                                    @endif

                                </td>


                                {{-- BIAYA PESERTA --}}

                                <td class="text-right align-middle">

                                    <strong class="text-success">

                                        Rp
                                        {{ number_format($participantFee, 0, ',', '.') }}

                                    </strong>


                                    @if ($agreedFee !== null)
                                        <div>

                                            <small class="text-warning">

                                                Penyesuaian khusus

                                            </small>

                                        </div>
                                    @else
                                        <div>

                                            <small class="text-muted">

                                                Mengikuti standar

                                            </small>

                                        </div>
                                    @endif

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center align-middle">

                                    @switch($item->status)
                                        @case('Aktif')
                                            <span class="badge badge-success">

                                                <i class="fas fa-check-circle mr-1"></i>

                                                Aktif

                                            </span>
                                        @break

                                        @case('Lulus')
                                        @case('Selesai')
                                            <span class="badge badge-primary">

                                                <i class="fas fa-graduation-cap mr-1"></i>

                                                {{ $item->status }}

                                            </span>
                                        @break

                                        @case('Mengundurkan Diri')
                                        @case('Berhenti')
                                            <span class="badge badge-danger">

                                                <i class="fas fa-times-circle mr-1"></i>

                                                {{ $item->status }}

                                            </span>
                                        @break

                                        @case('Dibatalkan')
                                            <span class="badge badge-secondary">

                                                <i class="fas fa-ban mr-1"></i>

                                                Dibatalkan

                                            </span>
                                        @break

                                        @default
                                            <span class="badge badge-secondary">

                                                {{ $item->status }}

                                            </span>
                                    @endswitch

                                </td>


                                {{-- AKSI --}}

                                <td class="text-center align-middle">
                                    @if (!$item->is_finalized)
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editParticipantProgramModal-{{ $item->id }}"
                                            title="Edit Penyesuaian">

                                            <i class="fas fa-edit"></i>

                                        </button>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Program sudah difinalkan">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif
                                    @if (!$item->is_finalized)
                                        <form action="{{ route('participants.programs.destroy', [$participant, $item]) }}"
                                            method="POST" class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Program"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Program sudah difinalkan">

                                            <i class="fas fa-lock"></i>

                                        </button>
                                    @endif

                                </td>

                            </tr>


                            @empty


                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        <div class="text-muted">

                                            <i class="fas fa-graduation-cap fa-3x mb-3"></i>

                                            <h5>

                                                Belum Ada Program

                                            </h5>

                                            <p>

                                                Peserta ini belum memiliki program.

                                            </p>

                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#createParticipantProgramModal">

                                                <i class="fas fa-plus mr-1"></i>
                                                Tambah Program

                                            </button>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse


                        </tbody>

                    </table>

                </div>

            </div>



            {{-- =====================================================
             FOOTER
             ===================================================== --}}

            @if ($programs->count() > 0)
                <div class="card-footer bg-light">

                    <div class="d-flex justify-content-between align-items-center">

                        <small class="text-muted">

                            <i class="fas fa-info-circle mr-1"></i>

                            Total
                            <strong>{{ $programs->count() }}</strong>
                            program.

                        </small>


                        <small class="text-muted">

                            <span class="mr-3">

                                <i class="fas fa-square text-muted mr-1"></i>

                                Biaya Standar

                            </span>

                            <span>

                                <i class="fas fa-square text-warning mr-1"></i>

                                Penyesuaian Khusus

                            </span>

                        </small>

                    </div>

                </div>
            @endif


        </div>


        {{-- =========================================================
            MODAL PROGRAM PESERTA
        ========================================================== --}}

        {{-- CREATE --}}
        @include('participant-wave-programs.partials.create-modal', [
            'participant' => $participant,
            'waves' => $waves,
        ])

        {{-- EDIT --}}
        @foreach ($programs as $item)
            @if (!$item->is_finalized)
                @include('participant-wave-programs.partials.edit-modal', [
                    'participant' => $participant,
                    'item' => $item,
                ])
            @endif
        @endforeach


    @stop



    @section('css')

        <style>
            .participant-avatar {

                width: 55px;
                height: 55px;

                border-radius: 50%;

                display: flex;
                align-items: center;
                justify-content: center;

                background-color: #e9ecef;

                color: #6c757d;

                font-size: 24px;

            }


            .table td,
            .table th {

                vertical-align: middle;

            }


            .small-box {

                min-height: 130px;

            }


            .small-box .icon {

                top: 15px;

            }


            .card-outline {

                border-top: 3px solid #007bff;

            }


            @media (max-width: 768px) {

                .content-header h1 {

                    font-size: 22px;

                }

            }

            #program-list {
                background-color: #fafafa;
            }

            #program-list table {
                margin-bottom: 0;
            }

            #program-list tbody tr:hover {
                background-color: #f4f6f9;
            }

            .program-checkbox {
                width: 18px;
                height: 18px;
                cursor: pointer;
            }

            .program-name {
                font-weight: 600;
            }
        </style>

    @stop


    @section('js')
        <script>
            $(document).ready(function() {

                /*
                |--------------------------------------------------------------------------
                | CREATE PROGRAM - AJAX
                |--------------------------------------------------------------------------
                */

                const waveSelect = $('#wave_id');
                const programList = $('#program-list');
                const programCount = $('#program-count');
                const saveButton = $('#saveButton');

                const oldWaveId = @json(old('form_context') === 'create' ? old('wave_id') : null);
                const oldSelectedPrograms = @json(old('form_context') === 'create' ? old('wave_programs', []) : []).map(String);

                const participantName = @json($participant->user->name);

                function escapeHtml(value) {
                    return $('<div>').text(value ?? '').html();
                }

                function updateSaveButton() {

                    const checked = $('#program-list input[name="wave_programs[]"]:checked').length;

                    saveButton.prop('disabled', checked === 0);

                    if (checked > 0) {

                        programCount
                            .removeClass('badge-secondary')
                            .addClass('badge-success')
                            .text(checked + ' program dipilih');

                    } else {

                        programCount
                            .removeClass('badge-success')
                            .addClass('badge-secondary')
                            .text('Belum dipilih');

                    }
                }

                function loadPrograms(waveId, waveName) {

                    saveButton.prop('disabled', true);

                    programCount
                        .removeClass('badge-success')
                        .addClass('badge-secondary')
                        .text('Memuat...');

                    if (!waveId) {

                        programList.html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-layer-group fa-2x mb-2"></i>
                    <div>Pilih gelombang terlebih dahulu.</div>
                </div>
            `);

                        programCount.text('Belum dipilih');

                        return;
                    }

                    programList.html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary mb-2"></div>
                <div class="text-muted">Memuat program tersedia...</div>
            </div>
        `);

                    const url = '/participants/{{ $participant->id }}/waves/' +
                        encodeURIComponent(waveId) +
                        '/available-programs';

                    $.get(url, function(data) {

                        if (!Array.isArray(data) || data.length === 0) {

                            programList.html(`
                    <div class="alert alert-success mb-0">

                        <h5>
                            <i class="fas fa-check-circle mr-1"></i>
                            Semua Program Sudah Terdaftar
                        </h5>

                        <p class="mb-0">
                            Peserta <strong>${escapeHtml(participantName)}</strong>
                            sudah terdaftar pada seluruh program yang tersedia
                            di <strong>${escapeHtml(waveName)}</strong>.
                        </p>

                    </div>
                `);

                            programCount
                                .removeClass('badge-success')
                                .addClass('badge-secondary')
                                .text('Tidak ada program');

                            return;
                        }

                        let html = `
                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="bg-light">
                            <tr>
                                <th width="55" class="text-center">Pilih</th>
                                <th>Program</th>
                                <th width="140" class="text-right">Biaya</th>
                                <th width="80" class="text-center">Kuota</th>
                                <th width="80" class="text-center">Terisi</th>
                                <th width="80" class="text-center">Sisa</th>
                            </tr>
                        </thead>

                        <tbody>
            `;

                        const selectedIds = String(waveId) === String(oldWaveId) ?
                            oldSelectedPrograms :
                            [];

                        data.forEach(function(item) {

                            const remaining = Number(item.remaining);

                            const checked = selectedIds.includes(String(item.id)) &&
                                remaining > 0;

                            let quotaBadge = '';

                            if (remaining <= 0) {

                                quotaBadge = `
                        <span class="badge badge-danger">Penuh</span>
                    `;

                            } else if (remaining <= 5) {

                                quotaBadge = `
                        <span class="badge badge-warning">${remaining}</span>
                    `;

                            } else {

                                quotaBadge = `
                        <span class="badge badge-success">${remaining}</span>
                    `;

                            }

                            html += `
                    <tr>

                        <td class="text-center">

                            <input
                                type="checkbox"
                                class="program-checkbox"
                                name="wave_programs[]"
                                value="${Number(item.id)}"
                                ${remaining <= 0 ? 'disabled' : ''}
                                ${checked ? 'checked' : ''}
                            >

                        </td>

                        <td>
                            <span class="program-name">
                                ${escapeHtml(item.program)}
                            </span>
                        </td>

                        <td class="text-right">
                            Rp ${Number(item.fee).toLocaleString('id-ID')}
                        </td>

                        <td class="text-center">
                            ${Number(item.quota)}
                        </td>

                        <td class="text-center">
                            ${Number(item.filled)}
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
                    Pilih satu atau beberapa program yang ingin didaftarkan.
                </div>
            `;

                        programList.html(html);

                        updateSaveButton();

                    }).fail(function() {

                        programList.html(`
                <div class="alert alert-danger mb-0">

                    <h5>
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Gagal Memuat Data
                    </h5>

                    <p class="mb-0">
                        Program tidak dapat dimuat. Silakan coba kembali.
                    </p>

                </div>
            `);

                        programCount.text('Gagal memuat');
                    });
                }


                // Perubahan gelombang
                waveSelect.on('change', function() {

                    const waveId = $(this).val();

                    const waveName = $(this)
                        .find(':selected')
                        .data('name') || '';

                    loadPrograms(waveId, waveName);

                });


                // Saat modal dibuka kembali
                $('#createParticipantProgramModal').on('shown.bs.modal', function() {

                    const waveId = waveSelect.val();

                    if (waveId) {

                        const waveName = waveSelect
                            .find(':selected')
                            .data('name') || '';

                        // Muat daftar program hanya jika belum dimuat
                        if (programList.find('input[name="wave_programs[]"]').length === 0) {
                            loadPrograms(waveId, waveName);
                        }

                    }

                });


                // Validasi submit Create
                $('#programForm').on('submit', function(e) {

                    const checked = $('#program-list input[name="wave_programs[]"]:checked').length;

                    if (checked === 0) {

                        e.preventDefault();

                        if (window.Swal) {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Program Belum Dipilih',
                                text: 'Silakan pilih minimal satu program terlebih dahulu.',
                                confirmButtonText: 'Mengerti'
                            });

                        } else {

                            alert('Silakan pilih minimal satu program terlebih dahulu.');

                        }

                        return false;
                    }

                    saveButton.prop('disabled', true);

                    saveButton.html(`
            <span class="spinner-border spinner-border-sm mr-1"></span>
            Menyimpan...
        `);

                });


                /*
                |--------------------------------------------------------------------------
                | EDIT PROGRAM - KALKULASI BIAYA
                |--------------------------------------------------------------------------
                */

                function formatRupiah(number) {

                    return new Intl.NumberFormat('id-ID').format(number);

                }

                function calculateParticipantFee(modal) {

                    const $modal = $(modal);

                    const standardFee = Number(
                        $modal.find('.modal-body').data('standard-fee')
                    ) || 0;

                    const agreedInput = $modal.find('[name="agreed_fee"]').val();

                    const discount = Number(
                        $modal.find('[name="discount"]').val()
                    ) || 0;

                    const agreedFee = agreedInput !== '' ?
                        Number(agreedInput) || 0 :
                        null;

                    const baseFee = agreedFee !== null ?
                        agreedFee :
                        standardFee;

                    const finalFee = Math.max(0, baseFee - discount);

                    if (agreedFee === null) {

                        $modal.find('.js-agreed-fee-preview').html(`
                <span class="text-muted">
                    Menggunakan standar
                </span>
            `);

                    } else {

                        $modal.find('.js-agreed-fee-preview').text(
                            'Rp ' + formatRupiah(agreedFee)
                        );

                    }

                    $modal.find('.js-discount-preview').text(
                        'Rp ' + formatRupiah(discount)
                    );

                    $modal.find('.js-final-fee-preview').text(
                        'Rp ' + formatRupiah(finalFee)
                    );

                }


                // Hitung ulang ketika biaya disepakati atau diskon berubah
                $(document).on(
                    'input',
                    '.js-agreed-fee, .js-discount',
                    function() {

                        const modal = $(this).closest('.modal');

                        calculateParticipantFee(modal);

                    }
                );


                // Hitung ulang ketika modal Edit dibuka
                $('.edit-participant-program-modal').on(
                    'shown.bs.modal',
                    function() {

                        calculateParticipantFee(this);

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | MEMBUKA KEMBALI MODAL SETELAH VALIDASI GAGAL
                |--------------------------------------------------------------------------
                */

                @if ($errors->any())

                    const formContext = @json(old('form_context'));

                    const itemId = @json(old('participant_program_id'));

                    if (formContext === 'create') {

                        $('#createParticipantProgramModal').modal('show');

                    } else if (formContext === 'edit' && itemId) {

                        $('#editParticipantProgramModal-' + itemId).modal('show');

                    }
                @endif


                /*
                |--------------------------------------------------------------------------
                | PERBAIKAN FOKUS BOOTSTRAP MODAL
                |--------------------------------------------------------------------------
                */

                let modalTriggerElement = null;

                $(document).on('show.bs.modal', '.modal', function(event) {

                    modalTriggerElement = event.relatedTarget || document.activeElement;

                });

                $(document).on('hide.bs.modal', '.modal', function() {

                    const activeElement = document.activeElement;

                    if (activeElement && this.contains(activeElement)) {
                        activeElement.blur();
                    }

                });

                $(document).on('hidden.bs.modal', '.modal', function() {

                    if (
                        modalTriggerElement &&
                        document.contains(modalTriggerElement)
                    ) {
                        modalTriggerElement.focus();
                    }

                    modalTriggerElement = null;

                });

            });
        </script>
    @stop
