
@php
    $showCreateErrors = $errors->any()
        && old('form_context') === 'create';
@endphp

<div class="modal fade" id="createParticipantModal"
    tabindex="-1" role="dialog"
    aria-labelledby="createParticipantModalLabel">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form action="{{ route('participants.store') }}" method="POST">
                @csrf

                <input type="hidden" name="form_context" value="create">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createParticipantModalLabel">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah Peserta
                    </h5>

                    <button type="button" class="close text-white"
                        data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    @include('participants.partials.form-fields', [
                        'participant' => null,
                        'showErrors' => $showCreateErrors
                    ])

                </div>

                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Peserta
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
