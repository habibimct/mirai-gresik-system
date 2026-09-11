@extends('layouts.pengurus')

@section('title', 'Pembayaran')

@section('page_title', 'Pembayaran')

@section('content')

<div class="space-y-6">

    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Pembayaran
        </h2>

        <p class="text-gray-500 mt-1">
            Riwayat pembayaran peserta berdasarkan kelas.
        </p>
    </div>


    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="px-5 py-4 border-b">

            <h3 class="font-semibold text-gray-800">
                Filter Kelas
            </h3>

        </div>

        <form method="GET">

            <div class="p-5">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div class="md:col-span-3">

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kelas
                        </label>

                        <select
                            name="classroom_id"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-indigo-500
                                   focus:ring-indigo-500">

                            <option value="">
                                -- Pilih Kelas --
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


                    <div class="flex items-end">

                        <button
                            type="submit"
                            class="w-full px-4 py-2.5
                                   bg-indigo-600 text-white
                                   rounded-lg hover:bg-indigo-700">

                            <i class="fas fa-search mr-1"></i>

                            Tampilkan

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>


    @if (request()->filled('classroom_id'))

        @php

            $totalPayments = $payments->sum('amount');

        @endphp


        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="bg-white rounded-xl shadow-sm border p-5">

                <p class="text-sm text-gray-500">
                    Jumlah Transaksi
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ $payments->count() }}
                </p>

            </div>


            <div class="bg-white rounded-xl shadow-sm border p-5">

                <p class="text-sm text-gray-500">
                    Total Pembayaran
                </p>

                <p class="text-2xl font-bold text-green-600 mt-1">

                    Rp {{ number_format($totalPayments, 0, ',', '.') }}

                </p>

            </div>

        </div>


        {{-- RIWAYAT --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">

            <div class="px-5 py-4 border-b">

                <h3 class="font-semibold text-gray-800">

                    <i class="fas fa-history mr-2 text-indigo-600"></i>

                    Riwayat Pembayaran

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
                                Tanggal
                            </th>

                            <th class="px-4 py-3 text-left">
                                Peserta
                            </th>

                            <th class="px-4 py-3 text-right">
                                Nominal
                            </th>

                            <th class="px-4 py-3 text-center">
                                Jenis
                            </th>

                            <th class="px-4 py-3 text-center">
                                Channel
                            </th>

                            <th class="px-4 py-3 text-left">
                                Petugas
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse ($payments as $payment)

                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">

                                    {{ \Carbon\Carbon::parse(
                                        $payment->payment_date
                                    )->format('d-m-Y') }}

                                </td>

                                <td class="px-4 py-3 font-medium">

                                    {{ $payment->invoice
                                        ->participantClassroom
                                        ->participantWaveProgram
                                        ->participant
                                        ->user
                                        ->name }}

                                </td>

                                <td class="px-4 py-3 text-right
                                           font-semibold text-green-600">

                                    Rp
                                    {{ number_format($payment->amount, 0, ',', '.') }}

                                </td>

                                <td class="px-4 py-3 text-center">

                                    @if ($payment->payment_type === 'Offline')

                                        <span class="px-2.5 py-1 rounded-full
                                                     text-xs
                                                     bg-gray-100 text-gray-700">

                                            Offline

                                        </span>

                                    @else

                                        <span class="px-2.5 py-1 rounded-full
                                                     text-xs
                                                     bg-blue-100 text-blue-700">

                                            Online

                                        </span>

                                    @endif

                                </td>

                                <td class="px-4 py-3 text-center">

                                    {{ $payment->payment_channel }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ optional($payment->receiver)->name ?? '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="px-4 py-10 text-center text-gray-500">

                                    Belum ada pembayaran.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @endif

</div>

@stop