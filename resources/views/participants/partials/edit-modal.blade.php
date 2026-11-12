
@php
    $showEditErrors = $errors->any()
        && old('form_context') === 'edit'
        && (string) old('participant_id') === (string) $participant->id;
@endphp

<div class="modal fade"
    id="editParticipantModal-{{ $participant->id }}"
    tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form action="{{ route('participants.update', $participant) }}"
                method="POST">

                @csrf
                @method('PUT')

                <input type="hidden" name="form_context" value="edit">
                <input type="hidden" name="participant_id"
                    value="{{ $participant->id }}">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit mr-2"></i>
                        Edit Data Peserta
                    </h5>

                    <button type="button" class="close"
                        data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Perbarui informasi peserta dengan teliti.
                    </div>

                    @include('participants.partials.form-fields', [
                        'participant' => $participant,
                        'showErrors' => $showEditErrors
                    ])

                </div>

                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary"
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
