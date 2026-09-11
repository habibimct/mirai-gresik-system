<div class="card card-primary card-outline">

    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle mr-1"></i>
            Informasi Kelas
        </h3>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="row">

            {{-- INFORMASI UTAMA --}}
            <div class="col-md-6">

                <div class="card card-light">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chalkboard-teacher mr-1"></i>
                            Data Kelas
                        </h3>
                    </div>

                    <div class="card-body p-0">

                        <table class="table table-hover mb-0">

                            <tr>
                                <th width="180">
                                    Kode Kelas
                                </th>

                                <td>
                                    <span class="badge badge-primary">
                                        {{ $classroom->code }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Nama Kelas
                                </th>

                                <td>
                                    <strong>
                                        {{ $classroom->name }}
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Program
                                </th>

                                <td>
                                    <i class="fas fa-graduation-cap text-muted mr-1"></i>
                                    {{ $classroom->waveProgram->program->name }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Gelombang
                                </th>

                                <td>
                                    <i class="fas fa-layer-group text-muted mr-1"></i>
                                    {{ $classroom->waveProgram->wave->name }}
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>


            {{-- INFORMASI FASILITAS --}}
            <div class="col-md-6">

                <div class="card card-light">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-building mr-1"></i>
                            Fasilitas Kelas
                        </h3>
                    </div>

                    <div class="card-body p-0">

                        <table class="table table-hover mb-0">

                            <tr>
                                <th width="180">
                                    Kapasitas
                                </th>

                                <td>
                                    <i class="fas fa-users text-muted mr-1"></i>

                                    <strong>
                                        {{ $classroom->capacity }}
                                    </strong>
                                    Peserta
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Terisi
                                </th>

                                <td>

                                    @php
                                        $jumlahPeserta = $classroom->participantClassrooms->count();
                                    @endphp

                                    <strong>
                                        {{ $jumlahPeserta }}
                                    </strong>
                                    Peserta
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Sisa Kuota
                                </th>

                                <td>

                                    @php
                                        $sisaKuota = max(0, $classroom->capacity - $jumlahPeserta);
                                    @endphp

                                    @if ($sisaKuota > 0)
                                        <span class="badge badge-success">
                                            {{ $sisaKuota }} Peserta
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            Penuh
                                        </span>
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Ruangan
                                </th>

                                <td>
                                    <i class="fas fa-door-open text-muted mr-1"></i>

                                    {{ $classroom->room ?: '-' }}
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- DESKRIPSI --}}
        <div class="card card-light">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-align-left mr-1"></i>
                    Deskripsi
                </h3>

            </div>

            <div class="card-body">

                @if ($classroom->description)
                    <p class="mb-0">
                        {{ $classroom->description }}
                    </p>
                @else
                    <span class="text-muted">
                        Belum ada deskripsi untuk kelas ini.
                    </span>
                @endif

            </div>

        </div>


        {{-- INFORMASI SISTEM --}}
        <div class="card card-light">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-history mr-1"></i>
                    Informasi Sistem
                </h3>

            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <tr>

                        <th width="180">
                            Dibuat
                        </th>

                        <td>

                            <i class="far fa-calendar-plus text-muted mr-1"></i>

                            {{ $classroom->created_at->translatedFormat('d F Y') }}

                            <span class="text-muted ml-2">
                                {{ $classroom->created_at->format('H:i') }}
                            </span>

                        </td>

                    </tr>

                    <tr>

                        <th>
                            Terakhir Diubah
                        </th>

                        <td>

                            <i class="far fa-calendar-check text-muted mr-1"></i>

                            {{ $classroom->updated_at->translatedFormat('d F Y') }}

                            <span class="text-muted ml-2">
                                {{ $classroom->updated_at->format('H:i') }}
                            </span>

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>


    {{-- FOOTER --}}
    {{-- <div class="card-footer">

        <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-warning">

            <i class="fas fa-edit mr-1"></i>
            Edit Kelas

        </a>

        <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div> --}}

</div>
