
@php
    $showEditErrors = $errors->any()
        && old('form_context') === 'edit'
        && (string) old('classroom_id') === (string) $classroom->id;
@endphp

<div class="modal fade"
    id="editClassroomModal-{{ $classroom->id }}"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ route('classrooms.update', $classroom) }}"
                method="POST">

                @csrf
                @method('PUT')

                <input type="hidden" name="form_context" value="edit">
                <input type="hidden" name="classroom_id"
                    value="{{ $classroom->id }}">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Kelas
                    </h5>

                    <button type="button" class="close"
                        data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Perbarui informasi kelas dengan benar.
                    </div>

                    @include('classrooms.partials.form-fields', [
                        'classroom' => $classroom,
                        'wavePrograms' => $wavePrograms,
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
