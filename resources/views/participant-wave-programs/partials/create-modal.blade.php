
<div class="modal fade" id="createParticipantProgramModal"
    tabindex="-1" role="dialog"
    aria-labelledby="createParticipantProgramModalLabel">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form id="programForm"
                action="{{ route('participants.programs.store', $participant) }}"
                method="POST">

                @csrf

                <input type="hidden" name="form_context" value="create">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createParticipantProgramModalLabel">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah Program Peserta
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- DATA PESERTA --}}
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-user-circle mr-1"></i>
                        Data Peserta
                    </h5>

                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Peserta</label>

                                <input type="text" class="form-control"
                                    value="{{ $participant->user->name }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ID Peserta</label>

                                <input type="text" class="form-control"
                                    value="#{{ str_pad($participant->id, 5, '0', STR_PAD_LEFT) }}"
                                    readonly>
                            </div>
                        </div>

                    </div>

                    <hr>

                    {{-- PILIH GELOMBANG --}}
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-layer-group mr-1"></i>
                        Pilih Gelombang
                    </h5>

                    <div class="row">
                        <div class="col-md-8">

                            <div class="form-group">

                                <label>
                                    Gelombang <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="wave_id"
                                    name="wave_id"
                                    class="form-control @if(old('form_context') === 'create' && $errors->has('wave_id')) is-invalid @endif">

                                    <option value="">
                                        -- Pilih Gelombang --
                                    </option>

                                    @foreach ($waves as $wave)

                                        <option
                                            value="{{ $wave->id }}"
                                            data-name="{{ $wave->name }}"
                                            @selected(old('form_context') === 'create' && old('wave_id') == $wave->id)>

                                            {{ $wave->name }}
                                            @if ($wave->year)
                                                ({{ $wave->year }})
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                                @if(old('form_context') === 'create')
                                    @error('wave_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif

                            </div>

                        </div>
                    </div>

                    <hr>

                    {{-- PROGRAM TERSEDIA --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="text-primary mb-0">
                            <i class="fas fa-book mr-1"></i>
                            Program Tersedia
                        </h5>

                        <span id="program-count" class="badge badge-secondary">
                            Belum dipilih
                        </span>

                    </div>

                    <div id="program-list" class="border rounded p-3">

                        <div class="text-center text-muted py-4">

                            <i class="fas fa-layer-group fa-2x mb-2"></i>

                            <div>
                                Pilih gelombang terlebih dahulu.
                            </div>

                        </div>

                    </div>

                    @if(old('form_context') === 'create')
                        @error('wave_programs')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    @endif

                    <small class="text-muted d-block mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pilih satu atau beberapa program yang ingin diikuti peserta.
                        Program yang kuotanya penuh tidak dapat dipilih.
                    </small>

                </div>

                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Batal

                    </button>

                    <button type="submit" id="saveButton"
                        class="btn btn-primary" disabled>

                        <i class="fas fa-save mr-1"></i>
                        Simpan Program

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
