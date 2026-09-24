<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.pwa-meta')

    <title>Tagihan Saya - MGS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 min-h-screen">


    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


        {{-- =========================================================
         HEADER
         ========================================================= --}}

        <div class="mb-8">

            <a href="{{ route('participant.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800">

                ← Dashboard

            </a>


            <h1 class="text-2xl font-bold text-gray-800 mt-3">

                Tagihan Saya

            </h1>


            <p class="text-gray-500 mt-1">

                Daftar tagihan pembayaran Anda.

            </p>

        </div>



        {{-- =========================================================
         DAFTAR INVOICE
         ========================================================= --}}

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


            @forelse($invoices as $invoice)


                @php

                    $remaining = max(0, $invoice->total_amount - $invoice->paid_amount);

                    $program = optional($invoice->participantClassroom->participantWaveProgram->waveProgram->program);

                    $wave = optional($invoice->participantClassroom->classroom->waveProgram->wave);

                    $classroom = optional($invoice->participantClassroom->classroom);

                @endphp



                {{-- =====================================================
                 CARD INVOICE
                 ===================================================== --}}

                <div class="bg-white rounded-7xl shadow-sm border border-gray-200 overflow-hidden">


                    {{-- HEADER INVOICE --}}

                    <div class="px-6 py-5 border-b border-gray-100">


                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">


                            <div>


                                <p class="text-xs uppercase tracking-wide text-gray-400">

                                    Tagihan Program

                                </p>


                                <h2 class="text-xl font-bold text-gray-800 mt-1">

                                    {{ $program->name ?? '-' }}

                                </h2>


                                <div class="mt-2 text-sm text-gray-500 space-y-1">


                                    <p>

                                        <span class="font-medium text-gray-700">
                                            Gelombang:
                                        </span>

                                        {{ $wave->name ?? '-' }}

                                    </p>


                                    <p>

                                        <span class="font-medium text-gray-700">
                                            Kelas:
                                        </span>

                                        {{ $classroom->name ?? '-' }}

                                    </p>


                                </div>


                            </div>



                            {{-- STATUS --}}

                            <div>


                                @if ($remaining <= 0)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full
                                           bg-green-100 text-green-700 text-sm font-semibold">

                                        ✓ Lunas

                                    </span>
                                @elseif ($invoice->paid_amount > 0)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full
                                           bg-yellow-100 text-yellow-700 text-sm font-semibold">

                                        ◷ Sebagian Dibayar

                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full
                                           bg-red-100 text-red-700 text-sm font-semibold">

                                        Belum Dibayar

                                    </span>
                                @endif


                            </div>

                        </div>

                    </div>



                    {{-- =====================================================
                     RINCIAN BIAYA
                     ===================================================== --}}

                    <div class="px-6 py-5">


                        <h3 class="font-semibold text-gray-700 mb-4">

                            Rincian Biaya

                        </h3>


                        <div class="space-y-3">


                            @foreach ($invoice->items as $item)
                                <div class="flex justify-between items-start gap-4 text-sm">


                                    <div class="text-gray-600">

                                        {{ $item->fee_name }}


                                        @if ($item->source)
                                            <span class="text-xs text-gray-400">

                                                ({{ $item->source }})
                                            </span>
                                        @endif

                                    </div>


                                    <div
                                        class="font-medium
                                    {{ $item->amount < 0 ? 'text-green-600' : 'text-gray-800' }}">

                                        {{ $item->amount < 0 ? '- ' : '' }}

                                        Rp
                                        {{ number_format(abs($item->amount), 0, ',', '.') }}

                                    </div>


                                </div>
                            @endforeach


                        </div>


                        {{-- GARIS --}}

                        <div class="border-t border-gray-200 my-5"></div>



                        {{-- TOTAL --}}

                        <div class="flex justify-between items-center">


                            <span class="font-semibold text-gray-700">

                                Total Tagihan

                            </span>


                            <span class="text-xl font-bold text-gray-900">

                                Rp
                                {{ number_format($invoice->total_amount, 0, ',', '.') }}

                            </span>

                        </div>



                        {{-- SUDAH DIBAYAR --}}

                        <div class="flex justify-between items-center mt-3">


                            <span class="text-sm text-gray-500">

                                Sudah Dibayar

                            </span>


                            <span class="font-semibold text-green-600">

                                Rp
                                {{ number_format($invoice->paid_amount, 0, ',', '.') }}

                            </span>

                        </div>



                        {{-- SISA --}}

                        <div class="flex justify-between items-center mt-3">


                            <span class="text-sm text-gray-500">

                                Sisa Tagihan

                            </span>


                            <span class="text-xl font-bold text-indigo-600">

                                Rp
                                {{ number_format($remaining, 0, ',', '.') }}

                            </span>

                        </div>


                    </div>



                    {{-- =====================================================
                     FOOTER
                     ===================================================== --}}

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">


                        @if ($remaining > 0)
                            <a href="{{ route('participant.payment.show', $invoice) }}"
                                class="block w-full text-center bg-indigo-600
                                   hover:bg-indigo-700 text-white font-semibold
                                   px-4 py-3 rounded-xl transition">

                                Bayar Sekarang

                            </a>
                        @else
                            <div
                                class="text-center text-green-700
                                   font-semibold py-2">

                                ✓ Tagihan ini sudah lunas

                            </div>
                        @endif


                    </div>


                </div>


            @empty


                {{-- =====================================================
                 BELUM ADA TAGIHAN
                 ===================================================== --}}

                <div
                    class="bg-white rounded-2xl shadow-sm
                       border border-gray-200 p-10 text-center">


                    <div class="text-4xl mb-4">

                        💳

                    </div>


                    <h2 class="font-semibold text-gray-700">

                        Belum Ada Tagihan

                    </h2>


                    <p class="text-sm text-gray-500 mt-1">

                        Saat ini belum ada tagihan pembayaran untuk Anda.

                    </p>


                </div>
            @endforelse


        </div>


    </div>


</body>

</html>
