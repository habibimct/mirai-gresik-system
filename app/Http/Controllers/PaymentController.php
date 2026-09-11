<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\ParticipantInvoice;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'participant_invoice_id' => 'required|exists:participant_invoices,id',
            'payment_date'           => 'required|date',
            'payment_type'           => 'required',
            'payment_channel'        => 'nullable',
            'amount'                 => 'required|numeric|min:1',
            'reference_number'       => 'nullable',
            'note'                   => 'nullable',
        ]);

        $invoice = ParticipantInvoice::findOrFail(
            $request->participant_invoice_id
        );

        // Cek apakah invoice sudah lunas
        if ($invoice->status == 'Lunas') {
            return back()
                ->withErrors([
                    'amount' => 'Invoice ini sudah lunas.'
                ])
                ->withInput();
        }

        // Hitung sisa tagihan
        $sisaTagihan = $invoice->total_amount - $invoice->paid_amount;

        // Nominal tidak boleh melebihi sisa tagihan
        if ($request->amount > $sisaTagihan) {
            return back()
                ->withErrors([
                    'amount' => 'Nominal pembayaran tidak boleh melebihi sisa tagihan sebesar Rp ' .
                        number_format($sisaTagihan, 0, ',', '.')
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request, $invoice) {

            Payment::create([
                'participant_invoice_id' => $invoice->id,
                'payment_date'           => $request->payment_date,
                'amount'                 => $request->amount,
                'payment_type'           => $request->payment_type,
                'payment_channel'        => $request->payment_channel,
                'reference_number'       => $request->reference_number,
                'note'                   => $request->note,
                'received_by'            => Auth::id(),
            ]);

            // Hitung total pembayaran terbaru
            $paid = $invoice->payments()->sum('amount');

            // Tentukan status invoice
            if ($paid <= 0) {
                $status = 'Belum Bayar';
            } elseif ($paid < $invoice->total_amount) {
                $status = 'Sebagian';
            } else {
                $status = 'Lunas';
            }

            $invoice->update([
                'paid_amount' => $paid,
                'status'      => $status,
            ]);
        });

        return back()->with(
            'success',
            'Pembayaran berhasil disimpan.'
        );
    }

    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            $invoice = $payment->invoice;

            $payment->delete();

            $paid = $invoice->payments()->sum('amount');

            $status = 'Belum Bayar';

            if ($paid >= $invoice->total_amount) {

                $status = 'Lunas';
            } elseif ($paid > 0) {

                $status = 'Sebagian';
            }

            $invoice->update([

                'paid_amount' => $paid,

                'status' => $status,

            ]);
        });

        return back()->with(
            'success',
            'Pembayaran berhasil dihapus.'
        );
    }
}
