<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Participant;
use App\Models\ParticipantInvoice;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class ParticipantPaymentController extends Controller
{
    public function show(ParticipantInvoice $invoice)
    {
        $participant = auth()->user()->participant;

        if (!$participant) {
            abort(
                403,
                'Akun ini belum terhubung dengan data peserta.'
            );
        }

        abort_unless(
            $participant &&
                $invoice->participantClassroom
                ->participantWaveProgram
                ->participant_id === $participant->id,
            403
        );

        $invoice->load([
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
            'items',
            'payments',
        ]);

        $remaining = $invoice->total_amount - $invoice->paid_amount;

        return view(
            'participants.payment',
            compact(
                'invoice',
                'remaining'
            )
        );
    }

    public function createPayment(
        Request $request,
        ParticipantInvoice $invoice
    ) {
        $participant = auth()->user()->participant;

        if (!$participant) {
            abort(403, 'Akun belum terhubung dengan peserta.');
        }

        $invoice->load([
            'participantClassroom.participantWaveProgram.participant.user',
        ]);

        $invoiceParticipant =
            $invoice
            ->participantClassroom
            ->participantWaveProgram
            ->participant;

        if ($invoiceParticipant->id !== $participant->id) {
            abort(403);
        }

        $remaining =
            $invoice->total_amount -
            $invoice->paid_amount;

        $amount = (int) $request->input('amount');

        if ($amount <= 0) {
            return response()->json([
                'message' => 'Nominal pembayaran harus lebih dari Rp0.'
            ], 422);
        }

        if ($amount > $remaining) {
            return response()->json([
                'message' => 'Nominal pembayaran tidak boleh melebihi sisa tagihan.'
            ], 422);
        }

        if ($remaining <= 0) {
            return response()->json([
                'message' => 'Tagihan sudah lunas.'
            ], 422);
        }

        Config::$serverKey =
            config('services.midtrans.server_key');

        Config::$isProduction =
            config('services.midtrans.is_production');

        Config::$isSanitized = true;

        Config::$is3ds = true;

        $orderId =
            'MGS-' .
            $invoice->id .
            '-' .
            time();

        $participantName =
            $invoiceParticipant
            ->user
            ->name;

        $params = [

            'transaction_details' => [

                'order_id' => $orderId,

                'gross_amount' => $amount,

            ],

            'customer_details' => [

                'first_name' => $participantName,

            ],

            'item_details' => [

                [
                    'id' => 'INV-' . $invoice->id,

                    'price' => $amount,

                    'quantity' => 1,

                    'name' => 'Pembayaran Tagihan MGS',
                ],

            ],

        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ]);
    }
}
