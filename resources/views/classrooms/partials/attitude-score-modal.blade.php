{{-- ========================================================= --}}
{{-- MODAL INPUT NILAI SIKAP --}}
{{-- ========================================================= --}}

@foreach ($classroom->attitudeSessions as $session)

    @php
        $sessionScores = $session->scores->keyBy(function ($score) {
            return $score->participant_classroom_id . '_' . $score->attitude_type_id;
        });

        $participantNotes = $session->scores
            ->groupBy('participant_classroom_id')
            ->map(function ($scores) {
                return $scores->first()->notes;
            });
    @endphp

    <div class="modal fade" id="attitudeScoreModal{{ $session->id }}" tabindex="-1" role="dialog"
        aria-labelledby="attitudeScoreModalLabel{{ $session->id }}" aria-hidden="true">

        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">

                <form action="{{ route('classrooms.attitude-sessions.scores.store', [$classroom, $session]) }}"
                    method="POST">

                    @csrf

                    <div class="modal-header">

                        <div>
                            <h5 class="modal-title" id="attitudeScoreModalLabel{{ $session->id }}">

                                <i class="fas fa-user-check mr-1"></i>
                                Input Nilai Sikap

                            </h5>

                            <small class="text-muted">
                                {{ $session->title }}
                                &mdash;
                                Minggu {{ $session->week }}
                            </small>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="alert alert-info">

                            <i class="fas fa-info-circle mr-1"></i>

                            Masukkan nilai sikap peserta dengan rentang
                            <strong>0–100</strong>.

                        </div>


                        <div class="table-responsive">

                            <table class="table table-bordered table-hover">

                                <thead class="thead-light">

                                    <tr>

                                        <th width="50" class="text-center">
                                            No
                                        </th>

                                        <th style="min-width: 220px;">
                                            Peserta
                                        </th>

                                        @foreach ($session->sessionTypes as $sessionType)
                                            <th class="text-center" style="min-width: 130px;">

                                                {{ $sessionType->type->name }}

                                            </th>
                                        @endforeach

                                        <th style="min-width: 180px;">
                                            Catatan
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($classroom->participantClassrooms as $participantClassroom)
                                        <tr>

                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td>
                                                <strong>
                                                    {{ $participantClassroom->participantWaveProgram->participant->user->name ?? '-' }}
                                                </strong>
                                            </td>

                                            @foreach ($session->sessionTypes as $sessionType)
                                                @php
                                                    $inputKey =
                                                        $participantClassroom->id . '_' . $sessionType->type->id;
                                                @endphp

                                                <td class="text-center">

                                                    <input type="hidden"
                                                        name="scores[{{ $inputKey }}][participant_classroom_id]"
                                                        value="{{ $participantClassroom->id }}">

                                                    <input type="hidden"
                                                        name="scores[{{ $inputKey }}][attitude_type_id]"
                                                        value="{{ $sessionType->type->id }}">

                                                    <input type="number" name="scores[{{ $inputKey }}][score]"
                                                        class="form-control form-control-sm text-center" min="0"
                                                        max="100" step="0.01" placeholder="0–100"
                                                        value="{{ old('scores.' . $inputKey . '.score', $sessionScores->get($inputKey)?->score) }}">

                                                </td>
                                            @endforeach

                                            <td>

                                                <input type="text"
                                                    name="participant_notes[{{ $participantClassroom->id }}]"
                                                    class="form-control form-control-sm" placeholder="Catatan"
                                                    value="{{ old('participant_notes.' . $participantClassroom->id, $participantNotes->get($participantClassroom->id)) }}">

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="{{ 3 + $session->sessionTypes->count() }}"
                                                class="text-center text-muted py-4">

                                                <i class="fas fa-info-circle mr-1"></i>

                                                Belum ada peserta di kelas ini.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">

                            <i class="fas fa-times mr-1"></i>
                            Tutup

                        </button>

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save mr-1"></i>
                            Simpan Nilai

                        </button>

                    </div>
                </form>
            </div>

        </div>

    </div>
@endforeach
