
@php
    $selectedWaveProgram = $showErrors
        ? old('wave_program_id')
        : ($classroom?->wave_program_id ?? '');

    $codeValue = old('code', $classroom?->code ?? '');
    $nameValue = old('name', $classroom?->name ?? '');
    $capacityValue = old('capacity', $classroom?->capacity ?? 20);
    $roomValue = old('room', $classroom?->room ?? '');

    $statusValue = old(
        'is_active',
        $classroom ? (string) (int) $classroom->is_active : '1'
    );

    $descriptionValue = old('description', $classroom?->description ?? '');

    $errorClass = fn ($field) =>
        $showErrors && $errors->has($field) ? 'is-invalid' : '';
@endphp

{{-- PROGRAM GELOMBANG --}}
<h6 class="text-primary font-weight-bold mb-3">
    <i class="fas fa-layer-group mr-2"></i>
    Program Gelombang
</h6>

<div class="form-group">

    <label>
        Program Gelombang <span class="text-danger">*</span>
    </label>

    <select name="wave_program_id"
        class="form-control {{ $errorClass('wave_program_id') }}"
        required>

        <option value="">-- Pilih Program Gelombang --</option>

        @foreach ($wavePrograms as $item)

            <option value="{{ $item->id }}"
                @selected($selectedWaveProgram == $item->id)>

                {{ $item->wave->code }}
                -
                {{ $item->program->name }}
                (Kuota {{ $item->quota }})

            </option>

        @endforeach

        {{-- Jika program kelas lama tidak ada dalam daftar pilihan --}}
        @if (
            $classroom &&
            $classroom->waveProgram &&
            !$wavePrograms->contains('id', $classroom->wave_program_id)
        )
            <option value="{{ $classroom->wave_program_id }}"
                @selected($selectedWaveProgram == $classroom->wave_program_id)>

                {{ $classroom->waveProgram->wave->code }}
                -
                {{ $classroom->waveProgram->program->name }}
                (Program saat ini)

            </option>
        @endif

    </select>

    @if ($showErrors)
        @error('wave_program_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif

</div>

<hr>

{{-- INFORMASI KELAS --}}
<h6 class="text-primary font-weight-bold mb-3">
    <i class="fas fa-chalkboard-teacher mr-2"></i>
    Informasi Kelas
</h6>

<div class="row">

    {{-- KODE --}}
    <div class="col-md-4">
        <div class="form-group">

            <label>
                Kode Kelas <span class="text-danger">*</span>
            </label>

            <input type="text"
                name="code"
                class="form-control {{ $errorClass('code') }}"
                value="{{ $codeValue }}"
                placeholder="Contoh: KLS-01"
                required>

            @if ($showErrors)
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- NAMA --}}
    <div class="col-md-8">
        <div class="form-group">

            <label>
                Nama Kelas <span class="text-danger">*</span>
            </label>

            <input type="text"
                name="name"
                class="form-control {{ $errorClass('name') }}"
                value="{{ $nameValue }}"
                placeholder="Contoh: Kelas Bahasa Jepang A"
                required>

            @if ($showErrors)
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

</div>

<div class="row">

    {{-- KAPASITAS --}}
    <div class="col-md-4">
        <div class="form-group">

            <label>
                Kapasitas <span class="text-danger">*</span>
            </label>

            <div class="input-group">

                <input type="number"
                    name="capacity"
                    class="form-control {{ $errorClass('capacity') }}"
                    value="{{ $capacityValue }}"
                    min="1"
                    required>

                <div class="input-group-append">
                    <span class="input-group-text">Peserta</span>
                </div>

                @if ($showErrors)
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                @endif

            </div>

        </div>
    </div>

    {{-- RUANGAN --}}
    <div class="col-md-4">
        <div class="form-group">

            <label>Ruangan</label>

            <input type="text"
                name="room"
                class="form-control {{ $errorClass('room') }}"
                value="{{ $roomValue }}"
                placeholder="Contoh: Ruang 1">

            @if ($showErrors)
                @error('room')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- STATUS --}}
    <div class="col-md-4">
        <div class="form-group">

            <label>
                Status <span class="text-danger">*</span>
            </label>

            <select name="is_active"
                class="form-control {{ $errorClass('is_active') }}"
                required>

                <option value="1" @selected($statusValue == '1')>
                    Aktif
                </option>

                <option value="0" @selected($statusValue == '0')>
                    Nonaktif
                </option>

            </select>

            @if ($showErrors)
                @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

</div>

{{-- DESKRIPSI --}}
<div class="form-group">

    <label>Deskripsi</label>

    <textarea name="description"
        rows="3"
        class="form-control {{ $errorClass('description') }}"
        placeholder="Keterangan tambahan mengenai kelas...">{{ $descriptionValue }}</textarea>

    @if ($showErrors)
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif

</div>
