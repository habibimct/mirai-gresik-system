<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.pwa-meta')

    <title>Pembayaran Tagihan - MGS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 min-h-screen">

    <div class="w-full max-w-2xl mx-auto px-4 sm:px-6 py-6 sm:py-10">

        <div class="mb-6">

            <a href="{{ route('participant.invoices.index') }}"
                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 mb-5">

                <span class="mr-1">←</span>
                Kembali ke Tagihan

            </a>


            <h1 class="text-2xl font-bold text-gray-800">
                Detail Pembayaran
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Periksa rincian tagihan sebelum melakukan pembayaran.
            </p>

        </div>


        {{-- ============================= --}}
        {{-- INFORMASI PESERTA --}}
        {{-- ============================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-5">

            <div class="flex items-center gap-3 mb-5">

                <div class="w-10 h-10 shrink-0 rounded-full bg-indigo-100 flex items-center justify-center">

                    <span class="text-indigo-600">
                        👤
                    </span>

                </div>

                <div>

                    <h2 class="font-bold text-gray-800">
                        Informasi Peserta
                    </h2>

                    <p class="text-xs text-gray-500">
                        Data tagihan peserta
                    </p>

                </div>

            </div>


            <div class="space-y-4 text-sm">

                <div class="grid grid-cols-[90px_1fr] gap-3 items-start">

                    <span class="text-gray-500">
                        Nama
                    </span>

                    <span class="font-semibold text-gray-800 text-right break-words">
                        {{ $invoice->participantClassroom->participantWaveProgram->participant->user->name }}
                    </span>

                </div>


                <div class="grid grid-cols-[90px_1fr] gap-3 items-start">

                    <span class="text-gray-500">
                        Program
                    </span>

                    <span class="font-semibold text-gray-800 text-right break-words">
                        {{ $invoice->participantClassroom->participantWaveProgram->waveProgram->program->name }}
                    </span>

                </div>


                <div class="grid grid-cols-[90px_1fr] gap-3 items-start">

                    <span class="text-gray-500">
                        Gelombang
                    </span>

                    <span class="font-semibold text-gray-800 text-right break-words">
                        {{ $invoice->participantClassroom->classroom->waveProgram->wave->name }}
                    </span>

                </div>


                <div class="grid grid-cols-[90px_1fr] gap-3 items-start">

                    <span class="text-gray-500">
                        Kelas
                    </span>

                    <span class="font-semibold text-gray-800 text-right break-words">
                        {{ $invoice->participantClassroom->classroom->name }}
                    </span>

                </div>

            </div>

        </div>



        {{-- ============================= --}}
        {{-- STATUS TAGIHAN --}}
        {{-- ============================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-5">

            <div class="flex justify-between items-center mb-5">

                <div>

                    <h2 class="font-bold text-gray-800">
                        Status Tagihan
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        Ringkasan pembayaran
                    </p>

                </div>


                @if ($remaining <= 0)
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">

                        LUNAS

                    </span>
                @elseif ($invoice->paid_amount > 0)
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">

                        SEBAGIAN

                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">

                        BELUM BAYAR

                    </span>
                @endif

            </div>


            {{-- Total --}}
            <div class="flex justify-between items-center mb-3">

                <span class="text-gray-500 text-sm">
                    Total Tagihan
                </span>

                <span class="font-bold text-gray-800">

                    Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}

                </span>

            </div>


            {{-- Dibayar --}}
            <div class="flex justify-between items-center mb-3">

                <span class="text-gray-500 text-sm">
                    Sudah Dibayar
                </span>

                <span class="font-bold text-green-600">

                    Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}

                </span>

            </div>


            {{-- Progress --}}
            @php

                $paidPercent = $invoice->total_amount > 0 ? ($invoice->paid_amount / $invoice->total_amount) * 100 : 0;

                $paidPercent = min(100, $paidPercent);

            @endphp


            <div class="mt-5">

                <div class="flex justify-between text-xs mb-2">

                    <span class="text-gray-500">
                        Progress pembayaran
                    </span>

                    <span class="font-semibold text-gray-700">

                        {{ number_format($paidPercent, 0) }}%

                    </span>

                </div>


                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

                    <div class="bg-green-500 h-3 rounded-full transition-all" style="width: {{ $paidPercent }}%">
                    </div>

                </div>

            </div>


            {{-- Sisa --}}
            <div class="mt-5 p-4 rounded-xl bg-indigo-50 border border-indigo-100">

                <div class="text-sm text-indigo-700">
                    Sisa Tagihan
                </div>

                <div class="text-2xl sm:text-3xl font-bold text-indigo-700 mt-1">

                    Rp {{ number_format($remaining, 0, ',', '.') }}

                </div>

            </div>

        </div>



        {{-- ============================= --}}
        {{-- RINCIAN BIAYA --}}
        {{-- ============================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-5">

            <h2 class="font-bold text-gray-800 mb-4">
                Rincian Biaya
            </h2>


            <div class="divide-y divide-gray-100">

                @foreach ($invoice->items as $item)
                    <div class="flex justify-between gap-4 py-3">

                        <span class="text-sm text-gray-600">

                            {{ $item->fee_name }}

                        </span>

                        <span class="text-sm font-semibold text-gray-800">

                            Rp {{ number_format($item->amount, 0, ',', '.') }}

                        </span>

                    </div>
                @endforeach

            </div>

        </div>



        {{-- ============================= --}}
        {{-- RIWAYAT PEMBAYARAN --}}
        {{-- ============================= --}}

        @if ($invoice->payments->count())

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-5">

                <h2 class="font-bold text-gray-800 mb-4">
                    Riwayat Pembayaran
                </h2>


                <div class="space-y-3">

                    @foreach ($invoice->payments->sortByDesc('payment_date') as $payment)
                        <div class="border border-gray-100 rounded-xl p-4 bg-gray-50">

                            <div class="flex justify-between gap-4">

                                <div>

                                    <div class="font-semibold text-gray-800">

                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}

                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">

                                        {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y') }}

                                    </div>

                                </div>


                                <div class="text-right">

                                    <div class="text-xs font-semibold text-green-600">

                                        {{ $payment->payment_type }}

                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">

                                        {{ $payment->payment_channel }}

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        @endif



        {{-- ============================= --}}
        {{-- PEMBAYARAN --}}
        {{-- ============================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-6">

            @if ($remaining > 0)
                <div class="mb-5">

                    <h2 class="font-bold text-gray-800">
                        Lakukan Pembayaran
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Anda dapat melakukan pembayaran secara bertahap.
                    </p>

                </div>


                {{-- Nominal --}}
                <div>

                    <label for="payment-amount" class="block text-sm font-semibold text-gray-700 mb-2">

                        Nominal Pembayaran

                    </label>


                    <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-white">

                        <div class="px-4 py-3 bg-gray-50 border-r border-gray-300 text-gray-600 font-semibold">
                            Rp
                        </div>

                        <input type="number" id="payment-amount" name="amount" min="1"
                            max="{{ $remaining }}" value="{{ $remaining }}"
                            class="w-full px-4 py-3 text-lg font-semibold text-gray-800 outline-none border-0 focus:ring-0">

                    </div>


                    <p class="text-xs text-gray-500 mt-2">

                        Maksimal pembayaran:

                        <span class="font-semibold">

                            Rp {{ number_format($remaining, 0, ',', '.') }}

                        </span>

                    </p>

                </div>


                {{-- Tombol --}}
                <button type="button" id="pay-button"
                    style="
                        display: block !important;
                        width: 100% !important;
                        background-color: #4f46e5 !important;
                        color: #ffffff !important;
                        padding: 14px 20px !important;
                        border-radius: 12px !important;
                        border: none !important;
                        font-weight: 700 !important;
                        font-size: 16px !important;
                        cursor: pointer !important;
                        text-align: center !important;
                        margin-top: 20px !important;
                        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.20) !important;
                    ">
                    Bayar Sekarang
                </button>


                <div class="text-center mt-3">

                    <p class="text-xs text-gray-400">

                        🔒 Pembayaran diproses secara aman melalui Midtrans.

                    </p>

                </div>
            @else
                <div class="text-center py-5">

                    <div class="w-14 h-14 mx-auto rounded-full bg-green-100 flex items-center justify-center">

                        <span class="text-2xl">
                            ✓
                        </span>

                    </div>


                    <h2 class="text-lg font-bold text-green-700 mt-4">

                        Tagihan Sudah Lunas

                    </h2>


                    <p class="text-sm text-gray-500 mt-1">

                        Terima kasih. Seluruh tagihan Anda telah dibayar.

                    </p>

                </div>
            @endif

        </div>

    </div>



    {{-- ============================= --}}
    {{-- MIDTRANS --}}
    {{-- ============================= --}}

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>


    <script>
        const payButton =
            document.getElementById('pay-button');


        if (payButton) {

            payButton.addEventListener(
                'click',
                async function() {

                    const amountInput =
                        document.getElementById(
                            'payment-amount'
                        );


                    const amount =
                        parseInt(
                            amountInput.value
                        );


                    if (!amount || amount <= 0) {

                        alert(
                            'Masukkan nominal pembayaran.'
                        );

                        return;

                    }


                    const maximum =
                        parseInt(
                            amountInput.max
                        );


                    if (amount > maximum) {

                        alert(
                            'Nominal pembayaran melebihi sisa tagihan.'
                        );

                        return;

                    }


                    payButton.disabled = true;

                    payButton.innerText =
                        'Memproses pembayaran...';


                    try {

                        const response =
                            await fetch(
                                "{{ route('participant.payment.create', $invoice) }}", {

                                    method: 'POST',

                                    headers: {

                                        'Content-Type': 'application/json',

                                        'X-CSRF-TOKEN': document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .getAttribute(
                                                'content'
                                            ),

                                        'Accept': 'application/json',

                                    },

                                    body: JSON.stringify({

                                        amount: amount

                                    }),

                                }
                            );


                        const data =
                            await response.json();


                        if (!response.ok) {

                            throw new Error(
                                data.message ||
                                'Gagal membuat pembayaran.'
                            );

                        }


                        window.snap.pay(
                            data.snap_token, {

                                onSuccess: function(result) {

                                    console.log(
                                        'Pembayaran berhasil',
                                        result
                                    );

                                    window.location.reload();

                                },


                                onPending: function(result) {

                                    console.log(
                                        'Menunggu pembayaran',
                                        result
                                    );


                                    alert(
                                        'Pembayaran sedang menunggu penyelesaian.'
                                    );


                                    payButton.disabled =
                                        false;

                                    payButton.innerText =
                                        'Bayar Sekarang';

                                },


                                onError: function(result) {

                                    console.error(
                                        'Pembayaran gagal',
                                        result
                                    );


                                    alert(
                                        'Pembayaran gagal.'
                                    );


                                    payButton.disabled =
                                        false;

                                    payButton.innerText =
                                        'Bayar Sekarang';

                                },


                                onClose: function() {

                                    payButton.disabled =
                                        false;

                                    payButton.innerText =
                                        'Bayar Sekarang';

                                },

                            }
                        );


                    } catch (error) {

                        console.error(error);


                        alert(
                            error.message ||
                            'Terjadi kesalahan saat memproses pembayaran.'
                        );


                        payButton.disabled =
                            false;


                        payButton.innerText =
                            'Bayar Sekarang';

                    }

                }
            );

        }
    </script>

</body>

</html>
