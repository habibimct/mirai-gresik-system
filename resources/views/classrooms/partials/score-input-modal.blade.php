<div class="modal fade"
    id="scoreInput{{ $session->id }}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="scoreInputLabel{{ $session->id }}"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered"
        style="max-width: 95%;"
        role="document">

        <div class="modal-content border-0 shadow">

            <form action="{{ route('score-sessions.saveScores', $session) }}"
                method="POST">

                @csrf

                {{-- Header --}}
                <div class="modal-header bg-info text-white">

                    <div>

                        <h5 class="modal-title font-weight-bold"
                            id="scoreInputLabel{{ $session->id }}">

                            <i class="fas fa-edit mr-2"></i>
                            Input Nilai

                        </h5>

                        <small class="d-block mt-1">
                            Masukkan nilai peserta berdasarkan jenis penilaian.
                        </small>

                    </div>

                    <button type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body p-4">

                    {{-- Info --}}
                    <div class="alert alert-light border mb-4">

                        <div class="d-flex align-items-center">

                            <div class="mr-3 text-info">

                                <i class="fas fa-info-circle fa-lg"></i>

                            </div>

                            <div>

                                <strong>Input Nilai Peserta</strong>

                                <div class="small text-muted mt-1">

                                    Nilai berada pada rentang
                                    <strong>0–100</strong>.
                                    Kosongkan kolom jika nilai belum tersedia.

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Tabel Nilai --}}
                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead class="thead-light text-center">

                                <tr>

                                    <th width="60" class="align-middle">
                                        No.
                                    </th>

                                    <th class="align-middle text-left"
                                        style="min-width: 250px;">

                                        <i class="fas fa-user mr-1 text-info"></i>
                                        Peserta

                                    </th>

                                    @foreach ($session->sessionTypes as $type)

                                        <th class="align-middle"
                                            style="min-width: 110px;">

                                            <i class="text-warning mr-1"></i>

                                            {{ $type->type->name }}

                                        </th>

                                    @endforeach

                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($classroom->participantClassrooms as $index => $participant)

                                    <tr>

                                        {{-- Nomor --}}
                                        <td class="text-center align-middle">

                                            {{ $index + 1 }}

                                        </td>

                                        {{-- Peserta --}}
                                        <td class="align-middle">

                                            <div class="font-weight-bold">

                                                {{ $participant->participantWaveProgram->participant->user->name }}

                                            </div>

                                        </td>

                                        {{-- Nilai --}}
                                        @foreach ($session->sessionTypes as $type)

                                            <td class="text-center align-middle">

                                                @php

                                                    $score = $participant->scores
                                                        ->where('score_session_id', $session->id)
                                                        ->where('score_type_id', $type->score_type_id)
                                                        ->first();

                                                @endphp

                                                <input type="number"
                                                    min="0"
                                                    max="100"
                                                    step="0.01"
                                                    value="{{ $score?->score }}"
                                                    class="form-control form-control-sm text-center mx-auto"
                                                    style="width: 75px;"
                                                    name="scores[{{ $participant->id }}][{{ $type->score_type_id }}]"
                                                    placeholder="-">

                                            </td>

                                        @endforeach

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="{{ $session->sessionTypes->count() + 2 }}"
                                            class="text-center text-muted py-5">

                                            <i class="fas fa-users-slash fa-2x mb-2"></i>

                                            <div>
                                                Belum ada peserta di kelas ini.
                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer bg-light">

                    <div class="mr-auto text-muted small">

                        <i class="fas fa-info-circle mr-1"></i>

                        Periksa kembali nilai sebelum menyimpan.

                    </div>

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Tutup

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-save mr-1"></i>
                        Simpan Nilai

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>