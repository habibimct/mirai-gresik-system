
@php
    $showCreateErrors = $errors->any()
        && old('form_context') === 'create';
@endphp

<div class="modal fade"
    id="createClassroomModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createClassroomModalLabel">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('classrooms.store') }}" method="POST">

                @csrf

                <input type="hidden" name="form_context" value="create">

                <div class="modal-header bg-primary">

                    <h5 class="modal-title" id="createClassroomModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Kelas
                    </h5>

                    <button type="button" class="close text-white"
                        data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    @include('classrooms.partials.form-fields', [
                        'classroom' => null,
                        'wavePrograms' => $wavePrograms,
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
                        Simpan Kelas

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
