
@php
    $isOldEdit = old('form_context') === 'edit'
        && (string) old('participant_program_id') === (string) $item->id;

    $standardFee = (float) ($item->standard_fee ?? 0);

    $agreedFee = $isOldEdit
        ? old('agreed_fee')
        : $item->agreed_fee;

    $discount = $isOldEdit
        ? old('discount', $item->discount ?? 0)
        : ($item->discount ?? 0);

    $statusValue = $isOldEdit
        ? old('status', $item->status)
        : $item->status;

    $baseFee = ($agreedFee !== null && $agreedFee !== '')
        ? (float) $agreedFee
        : $standardFee;

    $finalFee = max(0, $baseFee - (float) $discount);
@endphp

<div class="modal fade"
    id="editParticipantProgramModal-{{ $item->id }}"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form
                action="{{ route('participants.programs.update', [$participant, $item]) }}"
                method="POST">

                @csrf
                @method('PUT')

                <input type="hidden" name="form_context" value="edit">

                <input type="hidden"
                    name="participant_program_id"
                    value="{{ $item->id }}">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">
                        <i class="fas fa-user-edit mr-2"></i>
                        Edit Program Peserta
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    {{-- IDENTITAS PESERTA --}}
                    <div class="section-title mb-3">

                        <h5 class="text-primary mb-1">
                            <i class="fas fa-user mr-2"></i>
                            Identitas Peserta
                        </h5>

                        <small class="text-muted">
                            Informasi peserta yang terdaftar pada program.
                        </small>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Nama Peserta</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>

                                    <input type="text"
                                        class="form-control bg-light"
                                        value="{{ $participant->user->name }}"
                                        readonly>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Program</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-graduation-cap"></i>
                                        </span>
                                    </div>

                                    <input type="text"
                                        class="form-control bg-light"
                                        value="{{ $item->waveProgram->program->name }}"
                                        readonly>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Gelombang</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-layer-group"></i>
                                        </span>
                                    </div>

                                    <input type="text"
                                        class="form-control bg-light"
                                        value="{{ $item->waveProgram->wave->name }}"
                                        readonly>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Biaya Standar</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>

                                    <input type="text"
                                        class="form-control bg-light"
                                        value="{{ number_format($standardFee, 0, ',', '.') }}"
                                        readonly>

                                </div>

                                <small class="text-muted">
                                    Biaya standar dihitung otomatis dari pengaturan
                                    biaya gelombang dan program.
                                </small>

                            </div>
                        </div>

                    </div>

                    <hr>

                    {{-- PENGATURAN BIAYA --}}
                    <div class="section-title mb-3">

                        <h5 class="text-primary mb-1">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Pengaturan Biaya
                        </h5>

                        <small class="text-muted">
                            Atur biaya khusus dan potongan untuk peserta.
                        </small>

                    </div>

                    <div class="row">

                        {{-- BIAYA DISEPAKATI --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="agreed_fee_{{ $item->id }}">
                                    Biaya Disepakati
                                </label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>

                                    <input
                                        type="number"
                                        id="agreed_fee_{{ $item->id }}"
                                        name="agreed_fee"
                                        class="form-control {{ $isOldEdit && $errors->has('agreed_fee') ? 'is-invalid' : '' }}"
                                        value="{{ $agreedFee }}"
                                        min="0"
                                        step="1000"
                                        placeholder="Contoh: 500000">

                                    @if ($isOldEdit)
                                        @error('agreed_fee')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif

                                </div>

                                <small class="form-text text-muted">
                                    Kosongkan apabila peserta menggunakan biaya standar.
                                </small>

                            </div>

                        </div>

                        {{-- DISKON --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="discount_{{ $item->id }}">
                                    Diskon
                                </label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>

                                    <input
                                        type="number"
                                        id="discount_{{ $item->id }}"
                                        name="discount"
                                        class="form-control {{ $isOldEdit && $errors->has('discount') ? 'is-invalid' : '' }}"
                                        value="{{ $discount }}"
                                        min="0"
                                        step="1000"
                                        placeholder="Contoh: 100000">

                                    @if ($isOldEdit)
                                        @error('discount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif

                                </div>

                                <small class="form-text text-muted">
                                    Masukkan nominal potongan biaya peserta.
                                </small>

                            </div>

                        </div>

                    </div>

                    <hr class="my-4">

                    {{-- RINGKASAN BIAYA --}}
                    <div class="section-title mb-3">

                        <h5 class="text-primary mb-1">
                            <i class="fas fa-calculator mr-2"></i>
                            Ringkasan Biaya
                        </h5>

                        <small class="text-muted">
                            Perhitungan biaya peserta berdasarkan pengaturan di atas.
                        </small>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="small text-muted">
                                Biaya Standar
                            </div>

                            <div class="h5 mb-0">
                                Rp {{ number_format($standardFee, 0, ',', '.') }}
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="small text-muted">
                                Biaya Disepakati
                            </div>

                            <div class="h5 mb-0"
                                id="agreed-fee-preview-{{ $item->id }}">

                                @if ($agreedFee !== null && $agreedFee !== '')
                                    Rp {{ number_format((float) $agreedFee, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">
                                        Menggunakan standar
                                    </span>
                                @endif

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="small text-muted">
                                Diskon
                            </div>

                            <div class="h5 mb-0"
                                id="discount-preview-{{ $item->id }}">

                                Rp {{ number_format((float) $discount, 0, ',', '.') }}

                            </div>

                        </div>

                    </div>

                    <div class="alert alert-info mt-4 mb-0">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <strong>
                                    <i class="fas fa-file-invoice-dollar mr-1"></i>
                                    Perkiraan Total Tagihan
                                </strong>

                                <div class="small">
                                    Nilai ini yang akan digunakan saat invoice dibuat.
                                </div>

                            </div>

                            <div class="h4 mb-0 font-weight-bold"
                                id="final-fee-{{ $item->id }}">

                                Rp {{ number_format($finalFee, 0, ',', '.') }}

                            </div>

                        </div>

                    </div>

                    <hr>

                    {{-- STATUS --}}
                    <div class="form-group">

                        <label for="status_{{ $item->id }}">
                            Status Keikutsertaan
                        </label>

                        <select
                            id="status_{{ $item->id }}"
                            name="status"
                            class="form-control {{ $isOldEdit && $errors->has('status') ? 'is-invalid' : '' }}">

                            @foreach (['Aktif', 'Lulus', 'Mengundurkan Diri', 'Dibatalkan'] as $status)

                                <option value="{{ $status }}"
                                    @selected($statusValue == $status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                        @if ($isOldEdit)
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        @endif

                        <small class="form-text text-muted">
                            Status menunjukkan kondisi keikutsertaan peserta pada program ini.
                        </small>

                    </div>

                    @if ($isOldEdit && $errors->any())

                        <div class="alert alert-danger mb-0">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Periksa kembali data penyesuaian biaya.
                        </div>

                    @endif

                </div>

                <div class="modal-footer bg-light">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Batal

                    </button>

                    <button type="submit" class="btn btn-warning">

                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
