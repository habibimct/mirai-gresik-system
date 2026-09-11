{{-- =========================================================
     JADWAL KELAS
========================================================= --}}

<div class="card card-primary">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Jadwal Kelas
                </h3>
            </div>

            <div class="card-tools">

                <span class="badge badge-light mr-2">
                    {{ $classroom->schedules->count() }} Jadwal
                </span>

                <button type="button"
                    class="btn btn-light btn-sm"
                    data-toggle="modal"
                    data-target="#createScheduleModal">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Jadwal

                </button>

            </div>

        </div>

    </div>


    <div class="card-body">

        @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

                <i class="fas fa-check-circle mr-1"></i>

                {{ session('success') }}

            </div>

        @endif


        @if (session('error'))

            <div class="alert alert-danger alert-dismissible fade show">

                <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

                <i class="fas fa-exclamation-circle mr-1"></i>

                {{ session('error') }}

            </div>

        @endif


        {{-- TABEL JADWAL --}}

        <div class="table-responsive">

            @include('classrooms.partials.schedule-table')

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH JADWAL
========================================================= --}}

@include('classrooms.partials.schedule-create-modal')


{{-- =========================================================
     MODAL EDIT JADWAL
========================================================= --}}

@include('classrooms.partials.schedule-edit-modal')