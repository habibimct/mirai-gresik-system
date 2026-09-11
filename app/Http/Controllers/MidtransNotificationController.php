<?php

namespace App\Http\Controllers;

use App\Models\ParticipantInvoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        try {

            /*
             * Ambil data notification dari Midtrans
             */
            $orderId = $request->input('order_id');
            $statusCode = $request->input('status_code');
            $grossAmount = $request->input('gross_amount');
            $transactionStatus = $request->input('transaction_status');
            $fraudStatus = $request->input('fraud_status');
            $transactionId = $request->input('transaction_id');
            $signatureKey = $request->input('signature_key');

            /*
             * Pastikan data utama tersedia
             */
            if (
                !$orderId ||
                !$statusCode ||
                !$grossAmount ||
                !$transactionStatus ||
                !$signatureKey
            ) {
                return response()->json([
                    'message' => 'Invalid notification data.'
                ], 400);
            }

            /*
             * Verifikasi signature dari Midtrans
             *
             * SHA512:
             *
             * order_id
             * +
             * status_code
             * +
             * gross_amount
             * +
             * Server Key
             */
            $serverKey = config('services.midtrans.server_key');

            $expectedSignature = hash(
                'sha512',
                $orderId
                    . $statusCode
                    . $grossAmount
                    . $serverKey
            );

            if (!hash_equals(
                $expectedSignature,
                $signatureKey
            )) {

                return response()->json([
                    'message' => 'Invalid signature.'
                ], 403);
            }

            /*
             * Pastikan format Order ID MGS benar
             *
             * Contoh:
             *
             * MGS-7-1786337658
             */
            $parts = explode('-', $orderId);

            if (
                count($parts) < 3 ||
                $parts[0] !== 'MGS'
            ) {

                return response()->json([
                    'message' => 'Invalid order ID.'
                ], 400);
            }

            $invoiceId = (int) $parts[1];

            /*
             * Cari invoice
             */
            $invoice = ParticipantInvoice::find($invoiceId);

            if (!$invoice) {

                return response()->json([
                    'message' => 'Invoice not found.'
                ], 404);
            }

            /*
             * Konversi nominal
             */
            $grossAmount = (int) $grossAmount;

            /*
             * Tentukan apakah transaksi berhasil
             */
            $isPaid = false;

            if ($transactionStatus === 'settlement') {

                $isPaid = true;
            } elseif (
                $transactionStatus === 'capture' &&
                $fraudStatus === 'accept'
            ) {

                $isPaid = true;
            }

            /*
             * Jika transaksi belum berhasil,
             * tidak perlu membuat Payment.
             */
            if (!$isPaid) {

                return response()->json([
                    'message' => 'Transaction is not paid.',
                    'status' => $transactionStatus,
                ]);
            }

            /*
             * Simpan pembayaran dan update invoice
             * dalam satu database transaction.
             */
            DB::transaction(function () use (
                $invoice,
                $grossAmount,
                $transactionId,
                $request
            ) {

                /*
                 * Cegah pembayaran yang sama
                 * tercatat dua kali.
                 */
                $existingPayment = Payment::where(
                    'reference_number',
                    $transactionId
                )->first();

                if ($existingPayment) {
                    return;
                }

                /*
                 * Hitung sisa tagihan.
                 */
                $remaining =
                    $invoice->total_amount
                    - $invoice->paid_amount;

                /*
                 * Pastikan pembayaran tidak
                 * melebihi sisa tagihan.
                 */
                if ($grossAmount > $remaining) {

                    throw new \Exception(
                        'Payment amount exceeds invoice balance.'
                    );
                }

                /*
                 * Simpan pembayaran.
                 */
                Payment::create([

                    'participant_invoice_id' =>
                    $invoice->id,

                    'payment_date' =>
                    now()->toDateString(),

                    'payment_type' =>
                    'Online',

                    'payment_channel' => match ($request->input('payment_type')) {
                        'bank_transfer' => 'Midtrans - Bank Transfer',
                        'qris' => 'Midtrans - QRIS',
                        'gopay' => 'Midtrans - GoPay',
                        'shopeepay' => 'Midtrans - ShopeePay',
                        'credit_card' => 'Midtrans - Kartu Kredit',
                        'cstore' => 'Midtrans - Convenience Store',
                        'akulaku' => 'Midtrans - Akulaku',
                        'kredivo' => 'Midtrans - Kredivo',
                        default => 'Midtrans',
                    },

                    'amount' =>
                    $grossAmount,

                    'reference_number' =>
                    $transactionId,

                    'note' =>
                    'Pembayaran melalui Midtrans',

                    'received_by' =>
                    null,

                ]);

                /*
                 * Update jumlah pembayaran.
                 */
                $invoice->paid_amount =
                    $invoice->paid_amount
                    + $grossAmount;

                /*
                 * Update status invoice.
                 */
                if (
                    $invoice->paid_amount
                    >= $invoice->total_amount
                ) {

                    $invoice->paid_amount =
                        $invoice->total_amount;

                    $invoice->status =
                        'Lunas';
                } else {

                    $invoice->status =
                        'Sebagian';
                }

                $invoice->save();
            });

            /*
             * Berikan response sukses ke Midtrans.
             */
            return response()->json([
                'message' => 'Payment processed successfully.'
            ], 200);
        } catch (\Throwable $e) {

            /*
             * Simpan error ke Laravel log.
             */
            report($e);

            return response()->json([
                'message' => 'Failed to process payment.'
            ], 500);
        }
    }
}
