<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter mr-1"></i>
            Filter Laporan
        </h3>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('reports.academics.index') }}">

            <div class="row">

                {{-- PROGRAM --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="program_id">
                            Program
                        </label>

                        <select name="program_id" id="program_id" class="form-control">

                            <option value="">
                                -- Semua Program --
                            </option>

                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>


                {{-- GELOMBANG --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="wave_id">
                            Gelombang
                        </label>

                        <select name="wave_id" id="wave_id" class="form-control">

                            <option value="">
                                -- Semua Gelombang --
                            </option>

                            @foreach ($waves as $wave)
                                <option value="{{ $wave->id }}"
                                    {{ request('wave_id') == $wave->id ? 'selected' : '' }}>
                                    {{ $wave->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>


                {{-- KELAS --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="classroom_id">
                            Kelas
                        </label>

                        <select name="classroom_id" id="classroom_id" class="form-control">

                            <option value="">
                                -- Pilih Kelas --
                            </option>

                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}"
                                    {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>

                                    {{-- {{ optional($classroom->waveProgram->program)->name }}
                                    — --}}
                                    {{ optional($classroom->waveProgram->wave)->name }}
                                    —
                                    {{ $classroom->name }}

                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end mb-3">
                    <div class="d-flex justify-content-center w-100">
                        <a href="{{ route('reports.academics.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Reset
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            Tampilkan
                        </button>
                    </div>
                </div>
            </div>


        </form>

    </div>
</div>
