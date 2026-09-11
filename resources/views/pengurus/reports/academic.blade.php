@extends('layouts.pengurus')

@section('content')
    <div class="p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    Laporan Akademik
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Laporan kehadiran dan nilai peserta
                </p>

            </div>

            <div class="mt-4 md:mt-0">

                <a href="{{ route('pengurus.reports.academic.print', request()->query()) }}"
                    target="_blank"
                    class="inline-flex items-center px-3 py-2
                       border border-gray-300 rounded-lg
                       text-sm text-gray-700
                       hover:bg-gray-50">

                    <i class="fas fa-print mr-2"></i>

                    Cetak

                </a>

            </div>

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

                            <select name="wave_id"
                                class="w-full rounded-lg border-gray-300
                        focus:border-indigo-500 focus:ring-indigo-500">

                                <option value="">
                                    Semua Gelombang
                                </option>

                                @foreach ($waves as $wave)
                                    <option value="{{ $wave->id }}" @selected(request('wave_id') == $wave->id)>

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

                            <select name="program_id"
                                class="w-full rounded-lg border-gray-300
                        focus:border-indigo-500 focus:ring-indigo-500">

                                <option value="">
                                    Semua Program
                                </option>

                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>

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

                            <select name="classroom_id"
                                class="w-full rounded-lg border-gray-300
                        focus:border-indigo-500 focus:ring-indigo-500">

                                <option value="">
                                    Semua Kelas
                                </option>

                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" @selected(request('classroom_id') == $classroom->id)>

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

                        <button type="submit"
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


        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            {{-- Total --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Total Peserta
                </p>

                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $totalParticipants }}
                </p>

            </div>


            {{-- Kehadiran --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Rata-rata Kehadiran
                </p>

                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $averageAttendance }}%
                </p>

            </div>


            {{-- Nilai --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Rata-rata Nilai
                </p>

                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $averageScore }}
                </p>

            </div>


            {{-- Belum dinilai --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Belum Dinilai
                </p>

                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $participantsWithoutScore }}
                </p>

            </div>

        </div>


        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 border-b">

                        <tr>

                            <th class="px-4 py-3 text-center">
                                No
                            </th>

                            <th class="px-4 py-3 text-left">
                                Nama Peserta
                            </th>

                            <th class="px-4 py-3 text-left">
                                Kelas
                            </th>

                            <th class="px-4 py-3 text-center">
                                Hadir
                            </th>

                            <th class="px-4 py-3 text-center">
                                Izin
                            </th>

                            <th class="px-4 py-3 text-center">
                                Sakit
                            </th>

                            <th class="px-4 py-3 text-center">
                                Alpa
                            </th>

                            <th class="px-4 py-3 text-center">
                                Kehadiran
                            </th>

                            <th class="px-4 py-3 text-center">
                                Nilai
                            </th>

                            <th class="px-4 py-3 text-center">
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200">

                        @forelse ($academicData as $index => $data)
                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3 text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $data['name'] }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $data['classroom'] }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $data['present'] }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $data['permission'] }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $data['sick'] }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $data['absent'] }}
                                </td>

                                <td class="px-4 py-3 text-center font-medium">
                                    {{ $data['attendance_percentage'] }}%
                                </td>

                                <td class="px-4 py-3 text-center font-medium">

                                    {{ $data['average_score'] !== null ? $data['average_score'] : '-' }}

                                </td>

                                <td class="px-4 py-3 text-center">

                                    {{ $data['description'] }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="px-4 py-8 text-center text-gray-500">

                                    Belum ada data akademik.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
