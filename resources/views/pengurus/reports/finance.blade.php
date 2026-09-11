@extends('layouts.pengurus')

@section('content')

<div class="p-4 sm:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Laporan Keuangan
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Laporan tagihan dan pembayaran peserta
            </p>

        </div>


        {{-- CETAK --}}
        <a href="{{ route('pengurus.reports.finance.print', request()->query()) }}"
            target="_blank"
            class="inline-flex items-center justify-center px-4 py-2
                   border border-gray-300 rounded-lg
                   text-sm font-medium text-gray-700
                   hover:bg-gray-50">

            <i class="fas fa-print mr-2"></i>

            Cetak

        </a>

    </div>



    {{-- ====================================================== --}}
    {{-- FILTER --}}
    {{-- ====================================================== --}}

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

                            @foreach ($waves as $item)

                                <option value="{{ $item->id }}"
                                    @selected(request('wave_id') == $item->id)>

                                    {{ $item->name }}

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

                            @foreach ($programs as $item)

                                <option value="{{ $item->id }}"
                                    @selected(request('program_id') == $item->id)>

                                    {{ $item->name }}

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

                            @foreach ($classrooms as $item)

                                <option value="{{ $item->id }}"
                                    @selected(request('classroom_id') == $item->id)>

                                    {{ $item->name }}
                                    —
                                    {{ $item->waveProgram->program->name }}
                                    —
                                    {{ $item->waveProgram->wave->name }}

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



    {{-- ====================================================== --}}
    {{-- STATISTIK --}}
    {{-- ====================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


        {{-- TOTAL TAGIHAN --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">

            <p class="text-sm text-gray-500">
                Total Tagihan
            </p>

            <p class="text-xl font-bold text-gray-800 mt-2">

                Rp {{ number_format($totalAmount, 0, ',', '.') }}

            </p>

        </div>



        {{-- TOTAL DIBAYAR --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">

            <p class="text-sm text-gray-500">
                Total Dibayar
            </p>

            <p class="text-xl font-bold text-green-600 mt-2">

                Rp {{ number_format($totalPaid, 0, ',', '.') }}

            </p>

        </div>



        {{-- PIUTANG --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">

            <p class="text-sm text-gray-500">
                Total Piutang
            </p>

            <p class="text-xl font-bold text-red-600 mt-2">

                Rp {{ number_format($totalOutstanding, 0, ',', '.') }}

            </p>

        </div>



        {{-- PESERTA --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">

            <p class="text-sm text-gray-500">
                Peserta
            </p>

            <p class="text-xl font-bold text-indigo-600 mt-2">

                {{ number_format($totalParticipants) }}

            </p>

        </div>

    </div>



    {{-- STATUS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-xl border border-gray-200 p-4">

            <p class="text-sm text-gray-500">
                Lunas
            </p>

            <p class="text-xl font-bold text-green-600 mt-1">
                {{ $paidParticipants }}
            </p>

        </div>


        <div class="bg-white rounded-xl border border-gray-200 p-4">

            <p class="text-sm text-gray-500">
                Sebagian
            </p>

            <p class="text-xl font-bold text-yellow-600 mt-1">
                {{ $partialParticipants }}
            </p>

        </div>


        <div class="bg-white rounded-xl border border-gray-200 p-4">

            <p class="text-sm text-gray-500">
                Belum Bayar
            </p>

            <p class="text-xl font-bold text-red-600 mt-1">
                {{ $unpaidParticipants }}
            </p>

        </div>

    </div>



    {{-- ====================================================== --}}
    {{-- TABEL --}}
    {{-- ====================================================== --}}

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-5 py-4 border-b">

            <h3 class="font-semibold text-gray-800">
                Data Keuangan Peserta
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            No
                        </th>

                        <th class="px-4 py-3 text-left">
                            Peserta
                        </th>

                        <th class="px-4 py-3 text-left">
                            Program
                        </th>

                        <th class="px-4 py-3 text-left">
                            Gelombang
                        </th>

                        <th class="px-4 py-3 text-left">
                            Kelas
                        </th>

                        <th class="px-4 py-3 text-right">
                            Tagihan
                        </th>

                        <th class="px-4 py-3 text-right">
                            Dibayar
                        </th>

                        <th class="px-4 py-3 text-right">
                            Sisa
                        </th>

                        <th class="px-4 py-3 text-center">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($financeData as $index => $data)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">
                                {{ $index + 1 }}
                            </td>


                            <td class="px-4 py-3 font-medium text-gray-800">

                                {{ $data['name'] }}

                            </td>


                            <td class="px-4 py-3">
                                {{ $data['program'] }}
                            </td>


                            <td class="px-4 py-3">
                                {{ $data['wave'] }}
                            </td>


                            <td class="px-4 py-3">
                                {{ $data['classroom'] }}
                            </td>


                            <td class="px-4 py-3 text-right whitespace-nowrap">

                                Rp {{ number_format($data['total_amount'], 0, ',', '.') }}

                            </td>


                            <td class="px-4 py-3 text-right whitespace-nowrap text-green-600">

                                Rp {{ number_format($data['paid_amount'], 0, ',', '.') }}

                            </td>


                            <td class="px-4 py-3 text-right whitespace-nowrap text-red-600">

                                Rp {{ number_format($data['remaining'], 0, ',', '.') }}

                            </td>


                            <td class="px-4 py-3 text-center">

                                @if ($data['status'] === 'LUNAS')

                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                 bg-green-100 text-green-700">

                                        LUNAS

                                    </span>

                                @elseif ($data['status'] === 'SEBAGIAN')

                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                 bg-yellow-100 text-yellow-700">

                                        SEBAGIAN

                                    </span>

                                @else

                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                 bg-red-100 text-red-700">

                                        BELUM BAYAR

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="px-4 py-10 text-center text-gray-500">

                                Belum ada data keuangan final.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection