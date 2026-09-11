@extends('adminlte::page')

@section('title', 'Backup & Restore')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">

                <i class="fas fa-database mr-2"></i>

                Backup & Restore

            </h1>

            <p class="text-muted mb-0">

                Kelola backup database dan file sistem MGS.

            </p>

        </div>

    </div>

@stop


@section('content')


    {{-- ==========================================================
     ALERT
=========================================================== --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-2"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-exclamation-triangle mr-2"></i>

            {{ session('error') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif



    {{-- ==========================================================
     BACKUP ACTION
=========================================================== --}}

    <div class="row">


        {{-- ======================================================
         DATABASE BACKUP
    ======================================================= --}}

        <div class="col-md-6 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="bg-primary text-white rounded-circle
                               d-flex align-items-center justify-content-center mr-3"
                            style="width:50px;height:50px;">

                            <i class="fas fa-database fa-lg"></i>

                        </div>

                        <div>

                            <h5 class="mb-1 font-weight-bold">
                                Backup Database
                            </h5>

                            <small class="text-muted">
                                Backup seluruh database MGS.
                            </small>

                        </div>

                    </div>


                    <p class="text-muted small">

                        Membuat file SQL yang berisi seluruh
                        data database aplikasi.

                    </p>


                    <form action="{{ route('admin.backups.store') }}" method="POST">

                        @csrf

                        <input type="hidden" name="type" value="database">


                        <button type="submit" class="btn btn-primary btn-block"
                            onclick="return confirm(
                            'Buat backup database sekarang?'
                        )">

                            <i class="fas fa-database mr-1"></i>

                            Buat Backup Database

                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- ==========================================================
                RESTORE DARI FILE
            =========================================================== --}}

        <div class="card col-md-6 shadow-sm border-0 mb-4">

            <div class="card-header bg-white">

                <h3 class="card-title font-weight-bold">

                    <i class="fas fa-upload mr-2 text-warning"></i>

                    Restore dari File

                </h3>

            </div>


            <div class="card-body">

                <form action="{{ route('admin.backups.restore-upload') }}" method="POST" enctype="multipart/form-data"
                    id="restoreUploadForm">

                    @csrf


                    <div class="form-group">

                        <label for="backup_file">

                            <i class="fas fa-file-upload mr-1"></i>

                            Pilih File Backup

                        </label>


                        <div class="custom-file">

                            <input type="file" class="custom-file-input" id="backup_file" name="backup_file"
                                accept=".sql" required>

                            <label class="custom-file-label" for="backup_file">

                                Pilih file .SQL

                            </label>

                        </div>


                        <small class="form-text text-muted">

                            Format yang diperbolehkan:

                            <strong>.SQL</strong>
                            untuk database


                        </small>

                    </div>


                    <div class="form-group mb-0">

                        <label for="upload_confirmation">

                            Ketik

                            <code class="text-danger">
                                RESTORE MGS
                            </code>

                            untuk mengaktifkan restore.

                        </label>


                        <input type="text" name="confirmation" id="upload_confirmation" class="form-control"
                            placeholder="Ketik RESTORE MGS" autocomplete="off" required>

                    </div>


                    <div class="mt-4">

                        <button type="submit" class="btn btn-danger" id="restoreUploadButton">

                            <i class="fas fa-undo mr-1"></i>

                            Restore File Backup

                        </button>

                    </div>

                </form>

            </div>

        </div>


    </div>

    {{-- ==========================================================
     RIWAYAT BACKUP
=========================================================== --}}

    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-white">

            <h3 class="card-title font-weight-bold">

                <i class="fas fa-history mr-2"></i>

                Riwayat Backup

            </h3>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th>No</th>

                            <th>Backup</th>

                            <th>Jenis</th>

                            <th>Dibuat Oleh</th>

                            <th>Ukuran</th>

                            <th>Status</th>

                            <th>Waktu</th>

                            <th class="text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($backups as $backup)
                            <tr>

                                <td>

                                    {{ $loop->iteration + ($backups->currentPage() - 1) * $backups->perPage() }}

                                </td>


                                <td>

                                    <strong>
                                        {{ $backup->name }}
                                    </strong>


                                    @if ($backup->error_message)
                                        <div class="text-danger small mt-1">

                                            <i class="fas fa-exclamation-circle mr-1"></i>

                                            {{ $backup->error_message }}

                                        </div>
                                    @endif

                                </td>


                                <td>

                                    <span class="badge badge-primary">

                                        <i class="fas fa-database mr-1"></i>

                                        Database

                                    </span>

                                </td>


                                <td>

                                    {{ $backup->user?->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $backup->formatted_size }}

                                </td>


                                <td>

                                    @if ($backup->status === 'completed')
                                        <span class="badge badge-success">

                                            <i class="fas fa-check mr-1"></i>

                                            Berhasil

                                        </span>
                                    @elseif($backup->status === 'processing')
                                        <span class="badge badge-warning">

                                            <i class="fas fa-spinner fa-spin mr-1"></i>

                                            Processing

                                        </span>
                                    @elseif($backup->status === 'failed')
                                        <span class="badge badge-danger">

                                            <i class="fas fa-times mr-1"></i>

                                            Gagal

                                        </span>
                                    @else
                                        <span class="badge badge-secondary">

                                            {{ ucfirst($backup->status) }}

                                        </span>
                                    @endif

                                </td>


                                <td>

                                    <div>
                                        {{ $backup->created_at->format('d/m/Y') }}
                                    </div>

                                    <small class="text-muted">

                                        {{ $backup->created_at->format('H:i:s') }}

                                    </small>

                                </td>


                                <td class="text-right">


                                    @if ($backup->status === 'completed')
                                        {{-- DOWNLOAD --}}

                                        <a href="{{ route('admin.backups.download', $backup) }}"
                                            class="btn btn-sm btn-outline-primary" title="Download">

                                            <i class="fas fa-download"></i>

                                        </a>


                                        {{-- RESTORE --}}

                                        <button type="button" class="btn btn-sm btn-outline-warning" data-toggle="modal"
                                            data-target="#restoreModal{{ $backup->id }}" title="Restore">

                                            <i class="fas fa-undo"></i>

                                        </button>
                                    @endif


                                    {{-- DELETE --}}

                                    <form action="{{ route('admin.backups.destroy', $backup) }}" method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')


                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            onclick="return confirm(
                                        'Hapus backup ini secara permanen?'
                                    )">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5 text-muted">

                                    <i class="fas fa-database fa-2x mb-3"></i>

                                    <div>
                                        Belum ada backup.
                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if ($backups->hasPages())
            <div class="card-footer bg-white">

                {{ $backups->links() }}

            </div>
        @endif

    </div>



    {{-- ==========================================================
     RESTORE MODAL
=========================================================== --}}

    @foreach ($backups as $backup)
        @if ($backup->status === 'completed')
            <div class="modal fade" id="restoreModal{{ $backup->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">


                        <div class="modal-header bg-warning">

                            <h5 class="modal-title">

                                <i class="fas fa-exclamation-triangle mr-2"></i>

                                Konfirmasi Restore

                            </h5>


                            <button type="button" class="close" data-dismiss="modal">

                                <span>&times;</span>

                            </button>

                        </div>


                        <form action="{{ route('admin.backups.restore', $backup) }}" method="POST">

                            @csrf


                            <div class="modal-body">


                                <div class="alert alert-danger">

                                    <strong>

                                        <i class="fas fa-exclamation-triangle mr-1"></i>

                                        PERINGATAN!

                                    </strong>


                                    <p class="mb-0 mt-2">

                                        Restore akan mengganti database
                                        saat ini dengan data dari backup.

                                    </p>

                                </div>


                                <p class="mb-2">

                                    Backup yang dipilih:

                                </p>


                                <div class="bg-light rounded p-3 mb-3">

                                    <strong>

                                        {{ $backup->name }}

                                    </strong>


                                    <br>


                                    <small class="text-muted">

                                        {{ $backup->created_at->format('d F Y H:i:s') }}

                                        ·

                                        {{ $backup->formatted_size }}

                                    </small>

                                </div>


                                <p class="font-weight-bold">

                                    Untuk melanjutkan, ketik:

                                </p>


                                <div class="text-center mb-3">

                                    <code class="text-danger">

                                        RESTORE MGS

                                    </code>

                                </div>


                                <input type="text" name="confirmation" class="form-control"
                                    placeholder="Ketik RESTORE MGS" autocomplete="off" required>

                            </div>


                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                    Batal

                                </button>


                                <button type="submit" class="btn btn-danger">

                                    <i class="fas fa-undo mr-1"></i>

                                    Restore Sekarang

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        @endif
    @endforeach


@stop



{{-- ==========================================================
     JAVASCRIPT
=========================================================== --}}

@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            /*
            |--------------------------------------------------------------------------
            | File Input
            |--------------------------------------------------------------------------
            */

            const fileInput =
                document.getElementById('backup_file');

            if (fileInput) {

                fileInput.addEventListener('change', function() {

                    const fileName =
                        this.files.length ?
                        this.files[0].name :
                        'Pilih file .SQL';

                    const label =
                        document.querySelector(
                            '.custom-file-label[for="backup_file"]'
                        );

                    if (label) {
                        label.textContent = fileName;
                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Restore Upload Confirmation
            |--------------------------------------------------------------------------
            */

            const restoreForm =
                document.getElementById('restoreUploadForm');


            if (restoreForm) {

                restoreForm.addEventListener('submit', function(event) {

                    const confirmation =
                        document.getElementById(
                            'upload_confirmation'
                        ).value.trim();


                    if (confirmation !== 'RESTORE MGS') {

                        event.preventDefault();

                        alert(
                            'Konfirmasi tidak benar.\n\n' +
                            'Ketik: RESTORE MGS'
                        );

                        return;
                    }


                    const confirmed = confirm(

                        '⚠ PERINGATAN!\n\n' +

                        'Restore dapat mengganti data ' +
                        'yang sedang digunakan oleh sistem.\n\n' +

                        'Pastikan file backup yang dipilih benar.\n\n' +

                        'Apakah Anda benar-benar ingin melanjutkan?'

                    );


                    if (!confirmed) {

                        event.preventDefault();

                    }

                });

            }

        });
    </script>

@stop
