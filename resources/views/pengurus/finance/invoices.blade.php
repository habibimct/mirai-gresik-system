@extends('layouts.pengurus')

@section('title', 'Tagihan Peserta')

@section('page_title', 'Tagihan Peserta')

@section('content')

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Tagihan Peserta
            </h2>

            <p class="text-gray-500 mt-1">
                Informasi tagihan peserta berdasarkan kelas.
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

                            <select name="classroom_id"
                                class="w-full rounded-lg border-gray-300
                                   focus:border-indigo-500 focus:ring-indigo-500">

                                <option value="">
                                    -- Pilih Kelas --
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


                        <div class="flex items-end">

                            <button type="submit"
                                class="w-full px-4 py-2.5
                                   bg-indigo-600 text-white
                                   rounded-lg hover:bg-indigo-700
                                   transition">

                                <i class="fas fa-search mr-1"></i>

                                Tampilkan

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        @if (request()->filled('classroom_id'))

            {{-- RINGKASAN --}}
            @php

                $totalInvoices = $invoices->count();

                $totalAmount = $invoices->sum('total_amount');

                $totalPaid = $invoices->sum('paid_amount');

                $totalRemaining = max(0, $totalAmount - $totalPaid);

                $paidCount = $invoices->where('status', 'Lunas')->count();

                $partialCount = $invoices->where('status', 'Sebagian')->count();

                $unpaidCount = $invoices->where('status', 'Belum Bayar')->count();

            @endphp


            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                {{-- TOTAL PESERTA --}}
                <div class="bg-white rounded-xl shadow-sm border p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-gray-500">
                                Total Tagihan
                            </p>

                            <p class="text-2xl font-bold text-gray-800 mt-1">
                                {{ $totalInvoices }}
                            </p>

                        </div>

                        <div
                            class="w-11 h-11 rounded-xl
                                bg-indigo-100 text-indigo-600
                                flex items-center justify-center">

                            <i class="fas fa-file-invoice"></i>

                        </div>

                    </div>

                </div>


                {{-- TOTAL TAGIHAN --}}
                <div class="bg-white rounded-xl shadow-sm border p-5">

                    <p class="text-sm text-gray-500">
                        Nilai Tagihan
                    </p>

                    <p class="text-xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($totalAmount, 0, ',', '.') }}
                    </p>

                </div>


                {{-- SUDAH DIBAYAR --}}
                <div class="bg-white rounded-xl shadow-sm border p-5">

                    <p class="text-sm text-gray-500">
                        Sudah Dibayar
                    </p>

                    <p class="text-xl font-bold text-green-600 mt-1">
                        Rp {{ number_format($totalPaid, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $paidCount }} peserta lunas
                    </p>

                </div>


                {{-- SISA --}}
                <div class="bg-white rounded-xl shadow-sm border p-5">

                    <p class="text-sm text-gray-500">
                        Sisa Tagihan
                    </p>

                    <p class="text-xl font-bold text-orange-600 mt-1">
                        Rp {{ number_format($totalRemaining, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $unpaidCount }} belum bayar
                    </p>

                </div>

            </div>


            {{-- DAFTAR TAGIHAN --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">

                <div class="px-5 py-4 border-b">

                    <h3 class="font-semibold text-gray-800">

                        <i class="fas fa-file-invoice-dollar mr-2 text-indigo-600"></i>

                        Daftar Tagihan Peserta

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


                        <tbody class="divide-y">

                            @forelse ($invoices as $invoice)
                                @php

                                    $remaining = max(0, $invoice->total_amount - $invoice->paid_amount);

                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3 font-medium">

                                        {{ $invoice->participantClassroom->participantWaveProgram->participant->user->name }}

                                    </td>

                                    <td class="px-4 py-3 text-right">

                                        Rp
                                        {{ number_format($invoice->total_amount, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-3 text-right text-green-600">

                                        Rp
                                        {{ number_format($invoice->paid_amount, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-3 text-right font-semibold">

                                        Rp
                                        {{ number_format($remaining, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-3 text-center">

                                        @if ($invoice->status === 'Lunas')
                                            <span
                                                class="px-2.5 py-1 rounded-full
                                                     text-xs font-medium
                                                     bg-green-100 text-green-700">

                                                Lunas

                                            </span>
                                        @elseif ($invoice->status === 'Sebagian')
                                            <span
                                                class="px-2.5 py-1 rounded-full
                                                     text-xs font-medium
                                                     bg-yellow-100 text-yellow-700">

                                                Sebagian

                                            </span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 rounded-full
                                                     text-xs font-medium
                                                     bg-red-100 text-red-700">

                                                Belum Bayar

                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">

                                        Belum ada data tagihan.

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
