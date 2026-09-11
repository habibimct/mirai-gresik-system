@extends('layouts.pengurus')

@section('title', 'Nilai')

@section('page_title', 'Nilai')

@section('content')

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Nilai Peserta
        </h2>

        <p class="text-gray-500 mt-1">
            Pilih kelas untuk melihat nilai peserta.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="px-5 py-4 border-b flex items-center justify-between">

            <div>
                <h3 class="font-semibold text-gray-800">
                    Daftar Kelas
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Nilai peserta berdasarkan kelas.
                </p>
            </div>

            <div class="text-indigo-600">
                <i class="fas fa-star text-xl"></i>
            </div>

        </div>


        <div class="p-5">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead>

                        <tr class="border-b bg-gray-50">

                            <th class="px-4 py-3 text-left">
                                No
                            </th>

                            <th class="px-4 py-3 text-left">
                                Kelas
                            </th>

                            <th class="px-4 py-3 text-left">
                                Program
                            </th>

                            <th class="px-4 py-3 text-left">
                                Gelombang
                            </th>

                            <th class="px-4 py-3 text-center">
                                Peserta
                            </th>

                            <th class="px-4 py-3 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($classrooms as $classroom)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $classroom->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $classroom->waveProgram->program->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $classroom->waveProgram->wave->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-center">

                                    <span class="inline-flex items-center
                                        px-2.5 py-1 rounded-full
                                        text-xs font-medium
                                        bg-blue-100 text-blue-700">

                                        {{ $classroom->participant_classrooms_count }}

                                        peserta

                                    </span>

                                </td>

                                <td class="px-4 py-3 text-center">

                                    <a href="{{ route('pengurus.scores.show', $classroom) }}"
                                        class="inline-flex items-center
                                        px-3 py-2 rounded-lg
                                        bg-indigo-600 text-white
                                        hover:bg-indigo-700 transition">

                                        <i class="fas fa-eye mr-2"></i>

                                        Lihat Nilai

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="px-4 py-8 text-center text-gray-500">

                                    <i class="fas fa-folder-open text-3xl mb-2"></i>

                                    <p>
                                        Belum ada kelas.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@stop