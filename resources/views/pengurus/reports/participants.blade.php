@extends('layouts.pengurus')

@section('title', 'Laporan Peserta')

@section('page_title', 'Laporan Peserta')

@section('content')

    {{-- HEADER --}}
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Laporan Peserta
        </h2>

        <p class="text-gray-500 mt-1">
            Rekapitulasi identitas dan data peserta LPK Mirai Gresik.
        </p>

    </div>


    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">

        <div class="px-5 py-4 border-b">

            <h3 class="font-semibold text-gray-800">
                Filter Laporan
            </h3>

        </div>


        <form method="GET">

            <div class="p-5">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- GELOMBANG --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Gelombang
                        </label>

                        <select
                            name="wave_id"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-indigo-500 focus:ring-indigo-500">

                            <option value="">
                                Semua Gelombang
                            </option>

                            @foreach ($waves as $wave)

                                <option
                                    value="{{ $wave->id }}"
                                    @selected(request('wave_id') == $wave->id)
                                >
                                    {{ $wave->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- PROGRAM --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Program
                        </label>

                        <select
                            name="program_id"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-indigo-500 focus:ring-indigo-500">

                            <option value="">
                                Semua Program
                            </option>

                            @foreach ($programs as $program)

                                <option
                                    value="{{ $program->id }}"
                                    @selected(request('program_id') == $program->id)
                                >
                                    {{ $program->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- KELAS --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kelas
                        </label>

                        <select
                            name="classroom_id"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-indigo-500 focus:ring-indigo-500">

                            <option value="">
                                Semua Kelas
                            </option>

                            @foreach ($classrooms as $classroom)

                                <option
                                    value="{{ $classroom->id }}"
                                    @selected(request('classroom_id') == $classroom->id)
                                >
                                    {{ $classroom->name }}
                                    —
                                    {{ $classroom->waveProgram->program->name }}
                                    —
                                    {{ $classroom->waveProgram->wave->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="mt-4 flex justify-end">

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2
                               bg-indigo-600 text-white rounded-lg
                               hover:bg-indigo-700 transition">

                        <i class="fas fa-search mr-2"></i>

                        Tampilkan

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- TOTAL --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-200 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Peserta
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $totalParticipants ?? 0 }}
                    </p>

                </div>

                <div
                    class="w-12 h-12 rounded-xl
                           bg-blue-100 text-blue-600
                           flex items-center justify-center">

                    <i class="fas fa-users text-xl"></i>

                </div>

            </div>

        </div>


        {{-- AKTIF --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-200 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Peserta Aktif
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $activeParticipants ?? 0 }}
                    </p>

                </div>

                <div
                    class="w-12 h-12 rounded-xl
                           bg-green-100 text-green-600
                           flex items-center justify-center">

                    <i class="fas fa-user-check text-xl"></i>

                </div>

            </div>

        </div>


        {{-- LULUS --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-200 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Peserta Lulus
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $graduatedParticipants ?? 0 }}
                    </p>

                </div>

                <div
                    class="w-12 h-12 rounded-xl
                           bg-emerald-100 text-emerald-600
                           flex items-center justify-center">

                    <i class="fas fa-graduation-cap text-xl"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- TABEL --}}
    <div class="bg-white rounded-xl shadow-sm
                border border-gray-200">

        <div class="px-5 py-4 border-b
                    flex items-center justify-between">

            <div>

                <h3 class="font-semibold text-gray-800">
                    Daftar Peserta
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Data identitas peserta berdasarkan filter yang dipilih.
                </p>

            </div>


            <a
                href="{{ route('pengurus.reports.participants.print', request()->query()) }}"
                target="_blank"
                class="inline-flex items-center px-3 py-2
                       border border-gray-300 rounded-lg
                       text-sm text-gray-700 hover:bg-gray-50">

                <i class="fas fa-print mr-2"></i>

                Cetak

            </a>

        </div>


        <div class="w-full overflow-x-auto">

            <table class="w-full min-w-max divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        {{-- NO --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            No
                        </th>


                        {{-- NAMA --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Nama Peserta
                        </th>


                        {{-- NIK --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            NIK
                        </th>


                        {{-- TEMPAT LAHIR --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Tempat Lahir
                        </th>


                        {{-- TANGGAL LAHIR --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Tanggal Lahir
                        </th>


                        {{-- JENIS KELAMIN --}}
                        <th class="px-4 py-3 text-center
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            JK
                        </th>


                        {{-- ALAMAT --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Alamat
                        </th>


                        {{-- PENDIDIKAN --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Pendidikan
                        </th>


                        {{-- PEKERJAAN --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Pekerjaan
                        </th>


                        {{-- EMAIL --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Email
                        </th>


                        {{-- PHONE --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            No. HP
                        </th>


                        {{-- PROGRAM --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Program
                        </th>


                        {{-- GELOMBANG --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Gelombang
                        </th>


                        {{-- KELAS --}}
                        <th class="px-4 py-3 text-left
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Kelas
                        </th>


                        {{-- STATUS --}}
                        <th class="px-4 py-3 text-center
                                   text-xs font-semibold
                                   text-gray-600 uppercase">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($participants ?? [] as $participant)

                        @php
                            $data = $participant->participantWaveProgram->participant;
                            $user = $data->user;
                            $waveProgram = $participant->classroom->waveProgram;
                        @endphp


                        <tr class="hover:bg-gray-50">


                            {{-- NO --}}
                            <td class="px-4 py-3 text-gray-600">
                                {{ $loop->iteration }}
                            </td>


                            {{-- NAMA --}}
                            <td class="px-4 py-3 font-medium text-gray-800 whitespace-nowrap">
                                {{ $user->name ?? '-' }}
                            </td>


                            {{-- NIK --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $data->nik ?? '-' }}
                            </td>


                            {{-- TEMPAT LAHIR --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $data->birth_place ?? '-' }}
                            </td>


                            {{-- TANGGAL LAHIR --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">

                                @if ($data->birth_date)

                                    {{ \Carbon\Carbon::parse($data->birth_date)->format('d-m-Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- JENIS KELAMIN --}}
                            <td class="px-4 py-3 text-center text-gray-600">
                                {{ $data->gender ?? '-' }}
                            </td>


                            {{-- ALAMAT --}}
                            <td class="px-4 py-3 text-gray-600 min-w-[250px]">
                                {{ $data->address ?? '-' }}
                            </td>


                            {{-- PENDIDIKAN --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $data->education ?? '-' }}
                            </td>


                            {{-- PEKERJAAN --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $data->job ?? '-' }}
                            </td>


                            {{-- EMAIL --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $user->email ?? '-' }}
                            </td>


                            {{-- PHONE --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $user->phone ?? '-' }}
                            </td>


                            {{-- PROGRAM --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $waveProgram->program->name ?? '-' }}
                            </td>


                            {{-- GELOMBANG --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $waveProgram->wave->name ?? '-' }}
                            </td>


                            {{-- KELAS --}}
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                {{ $participant->classroom->name ?? '-' }}
                            </td>


                            {{-- STATUS --}}
                            <td class="px-4 py-3 text-center whitespace-nowrap">

                                @if ($data->status === 'Lulus')

                                    <span
                                        class="inline-flex px-2 py-1
                                               text-xs font-semibold
                                               rounded-full
                                               bg-green-100
                                               text-green-700">

                                        Lulus

                                    </span>

                                @else

                                    <span
                                        class="inline-flex px-2 py-1
                                               text-xs font-semibold
                                               rounded-full
                                               bg-blue-100
                                               text-blue-700">

                                        {{ $data->status ?? 'Aktif' }}

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="15"
                                class="px-4 py-10 text-center
                                       text-gray-500">

                                <i
                                    class="fas fa-users text-3xl
                                           text-gray-300 mb-3"></i>

                                <p>
                                    Tidak ada data peserta.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@stop
