
@php
    $participantUser = $participant?->user;

    $nameValue = old('name', $participantUser?->name ?? '');
    $emailValue = old('email', $participantUser?->email ?? '');
    $phoneValue = old('phone', $participantUser?->phone ?? '');

    $nikValue = old('nik', $participant?->nik ?? '');
    $genderValue = old('gender', $participant?->gender ?? '');

    $birthPlaceValue = old('birth_place', $participant?->birth_place ?? '');

    $birthDateValue = old(
        'birth_date',
        $participant?->birth_date
            ? \Carbon\Carbon::parse($participant->birth_date)->format('Y-m-d')
            : ''
    );

    $addressValue = old('address', $participant?->address ?? '');
    $educationValue = old('education', $participant?->education ?? '');
    $jobValue = old('job', $participant?->job ?? '');

    $statusValue = old('status', $participant?->status ?? 'Aktif');

    $errorClass = fn ($field) =>
        $showErrors && $errors->has($field) ? 'is-invalid' : '';
@endphp

{{-- =====================================================
     DATA AKUN
====================================================== --}}

<h5 class="text-primary mb-3">
    <i class="fas fa-user-circle mr-1"></i>
    Data Akun
</h5>

<div class="row">

    {{-- NAMA --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>
                Nama Lengkap <span class="text-danger">*</span>
            </label>

            <input type="text"
                name="name"
                class="form-control {{ $errorClass('name') }}"
                value="{{ $nameValue }}"
                placeholder="Masukkan nama lengkap"
                required>

            @if ($showErrors)
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>
                Email <span class="text-danger">*</span>
            </label>

            <input type="email"
                name="email"
                class="form-control {{ $errorClass('email') }}"
                value="{{ $emailValue }}"
                placeholder="contoh@email.com"
                required>

            @if ($showErrors)
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- NO HP --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>No. HP</label>

            <input type="text"
                name="phone"
                class="form-control {{ $errorClass('phone') }}"
                value="{{ $phoneValue }}"
                placeholder="Contoh: 6281234567890">

            @if ($showErrors)
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

</div>

<hr>

{{-- =====================================================
     IDENTITAS PESERTA
====================================================== --}}

<h5 class="text-primary mb-3">
    <i class="fas fa-id-card mr-1"></i>
    Identitas Peserta
</h5>

<div class="row">

    {{-- NIK --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>NIK</label>

            <input type="text"
                name="nik"
                class="form-control {{ $errorClass('nik') }}"
                value="{{ $nikValue }}"
                placeholder="Masukkan NIK"
                maxlength="16">

            @if ($showErrors)
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- JENIS KELAMIN --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>Jenis Kelamin</label>

            <select name="gender"
                class="form-control {{ $errorClass('gender') }}">

                <option value="">-- Pilih Jenis Kelamin --</option>

                <option value="L" @selected($genderValue == 'L')>
                    Laki-laki
                </option>

                <option value="P" @selected($genderValue == 'P')>
                    Perempuan
                </option>

            </select>

            @if ($showErrors)
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- TEMPAT LAHIR --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>
                Tempat Lahir <span class="text-danger">*</span>
            </label>

            <input type="text"
                name="birth_place"
                class="form-control {{ $errorClass('birth_place') }}"
                value="{{ $birthPlaceValue }}"
                placeholder="Contoh: Gresik"
                required>

            @if ($showErrors)
                @error('birth_place')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- TANGGAL LAHIR --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>
                Tanggal Lahir <span class="text-danger">*</span>
            </label>

            <input type="date"
                name="birth_date"
                class="form-control {{ $errorClass('birth_date') }}"
                value="{{ $birthDateValue }}"
                required>

            @if ($showErrors)
                @error('birth_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

</div>

<hr>

{{-- =====================================================
     ALAMAT & PENDIDIKAN
====================================================== --}}

<h5 class="text-primary mb-3">
    <i class="fas fa-address-card mr-1"></i>
    Alamat & Pendidikan
</h5>

{{-- ALAMAT --}}
<div class="form-group">

    <label>Alamat</label>

    <textarea name="address"
        rows="3"
        class="form-control {{ $errorClass('address') }}"
        placeholder="Masukkan alamat lengkap peserta...">{{ $addressValue }}</textarea>

    @if ($showErrors)
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif

</div>

<div class="row">

    {{-- PENDIDIKAN --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>Pendidikan Terakhir</label>

            <input type="text"
                name="education"
                class="form-control {{ $errorClass('education') }}"
                value="{{ $educationValue }}"
                placeholder="Contoh: SMA / SMK">

            @if ($showErrors)
                @error('education')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

    {{-- PEKERJAAN --}}
    <div class="col-md-6">
        <div class="form-group">

            <label>Pekerjaan</label>

            <input type="text"
                name="job"
                class="form-control {{ $errorClass('job') }}"
                value="{{ $jobValue }}"
                placeholder="Contoh: Pelajar / Karyawan">

            @if ($showErrors)
                @error('job')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif

        </div>
    </div>

</div>

<hr>

{{-- =====================================================
     STATUS PESERTA
====================================================== --}}

<h5 class="text-primary mb-3">
    <i class="fas fa-toggle-on mr-1"></i>
    Status Peserta
</h5>

<div class="form-group">

    <label>Status</label>

    <select name="status"
        class="form-control {{ $errorClass('status') }}">

        <option value="Aktif" @selected($statusValue == 'Aktif')>
            Aktif
        </option>

        <option value="Lulus" @selected($statusValue == 'Lulus')>
            Lulus
        </option>

        <option value="Keluar" @selected($statusValue == 'Keluar')>
            Keluar
        </option>

    </select>

    @if ($showErrors)
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif

</div>
