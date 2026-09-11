<div class="modal fade" id="createScheduleModal" tabindex="-1" role="dialog" aria-labelledby="createScheduleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <form action="{{ route('classrooms.schedule.store', $classroom) }}" method="POST">

            @csrf

            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title font-weight-bold" id="createScheduleModalLabel">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Tambah Jadwal
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body p-4">

                    {{-- Info --}}
                    <div class="alert alert-light border mb-4">

                        <div class="d-flex">

                            <div class="mr-3 text-primary">
                                <i class="fas fa-info-circle fa-lg"></i>
                            </div>

                            <div>

                                <strong>Jadwal Pembelajaran</strong>

                                <div class="small text-muted mt-1">
                                    Masukkan materi, hari, dan waktu pelaksanaan
                                    pembelajaran untuk kelas ini.
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Materi --}}
                    <div class="form-group">

                        <label for="subject" class="font-weight-bold">
                            <i class="fas fa-book text-primary mr-1"></i>
                            Materi
                        </label>

                        <input type="text" id="subject" name="subject" class="form-control"
                            placeholder="Contoh: Bahasa Jepang Dasar" required>

                        <small class="form-text text-muted">
                            Masukkan nama materi yang akan diajarkan.
                        </small>

                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">

                        <label for="schedule_date" class="font-weight-bold">
                            <i class="fas fa-calendar-alt text-primary mr-1"></i>
                            Tanggal
                        </label>

                        <input type="date" id="schedule_date" name="schedule_date" class="form-control" required>

                        <small class="form-text text-muted">
                            Pilih tanggal pelaksanaan pembelajaran.
                            Hari akan ditentukan otomatis berdasarkan tanggal.
                        </small>

                    </div>


                    {{-- Waktu --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            <i class="fas fa-clock text-primary mr-1"></i>
                            Waktu Pembelajaran
                        </label>

                        <div class="row">

                            {{-- Jam Mulai --}}
                            <div class="col-6">

                                <label for="start_time" class="small text-muted">
                                    Jam Mulai
                                </label>

                                <div class="input-group">

                                    <input type="time" id="start_time" name="start_time" class="form-control"
                                        required>

                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>

                                </div>

                            </div>

                            {{-- Jam Selesai --}}
                            <div class="col-6">

                                <label for="end_time" class="small text-muted">
                                    Jam Selesai
                                </label>

                                <div class="input-group">

                                    <input type="time" id="end_time" name="end_time" class="form-control" required>

                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="form-group mb-0">

                        <label for="is_active" class="font-weight-bold">
                            <i class="fas fa-toggle-on text-success mr-1"></i>
                            Status
                        </label>

                        <select name="is_active" id="is_active" class="form-control" required>

                            <option value="1" selected>
                                Aktif
                            </option>

                            <option value="0">
                                Nonaktif
                            </option>

                        </select>

                        <small class="form-text text-muted">
                            Jadwal aktif akan digunakan dalam kegiatan pembelajaran.
                        </small>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Batal

                    </button>

                    <button type="submit" class="btn btn-primary">

                        <i class="fas fa-save mr-1"></i>
                        Simpan Jadwal

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
