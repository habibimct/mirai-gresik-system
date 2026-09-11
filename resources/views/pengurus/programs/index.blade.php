@extends('layouts.pengurus')

@section('title', 'Program')

@section('page_title', 'Program')

@section('content')

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Program
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Daftar program pelatihan LPK Mirai Gresik.
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">

            <div>

                <h3 class="font-semibold text-gray-800">
                    Daftar Program
                </h3>

                <p class="text-xs text-gray-400 mt-1">
                    Total {{ $programs->count() }} program
                </p>

            </div>

            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600
                        flex items-center justify-center">

                <i class="fas fa-graduation-cap"></i>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            No
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Program
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Keterangan
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($programs as $program)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4 text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4">

                                <div class="font-semibold text-gray-800">
                                    {{ $program->name }}
                                </div>

                            </td>

                            <td class="px-5 py-4 text-gray-500">

                                {{ $program->description ?? '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="3"
                                class="px-5 py-10 text-center text-gray-500">

                                <i class="fas fa-graduation-cap text-3xl text-gray-300 mb-3"></i>

                                <p>
                                    Belum ada program.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection