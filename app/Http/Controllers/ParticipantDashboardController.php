<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\ParticipantInvoice;

class ParticipantDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $participant = $user->participant;


        /*
        |--------------------------------------------------------------------------
        | Jika user belum memiliki data participant
        |--------------------------------------------------------------------------
        */

        if (!$participant) {

            return view('participants.dashboard', [

                'totalTagihan' => 0,

                'sudahDibayar' => 0,

                'sisaTagihan' => 0,

                'persentase' => 0,

                'statusPembayaran' => 'Belum Ada Tagihan',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Ambil tagihan peserta
        |--------------------------------------------------------------------------
        */

        $invoices = ParticipantInvoice::where(
            'is_final',
            true
        )
            ->whereHas(
                'participantClassroom.participantWaveProgram',
                function ($query) use ($participant) {

                    $query->where(
                        'participant_id',
                        $participant->id
                    );

                }
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Total tagihan
        |--------------------------------------------------------------------------
        */

        $totalTagihan = $invoices->sum(
            'total_amount'
        );


        /*
        |--------------------------------------------------------------------------
        | Total pembayaran
        |--------------------------------------------------------------------------
        */

        $sudahDibayar = $invoices->sum(
            'paid_amount'
        );


        /*
        |--------------------------------------------------------------------------
        | Sisa tagihan
        |--------------------------------------------------------------------------
        */

        $sisaTagihan = max(
            0,
            $totalTagihan - $sudahDibayar
        );


        /*
        |--------------------------------------------------------------------------
        | Persentase pembayaran
        |--------------------------------------------------------------------------
        */

        $persentase = $totalTagihan > 0

            ? min(
                100,
                round(
                    ($sudahDibayar / $totalTagihan) * 100, 2
                )
            )

            : 0;


        /*
        |--------------------------------------------------------------------------
        | Status pembayaran
        |--------------------------------------------------------------------------
        */

        if ($invoices->isEmpty()) {

            $statusPembayaran =
                'Belum Ada Tagihan';

        } elseif (
            $invoices->every(
                function ($invoice) {

                    return $invoice->status === 'Lunas';

                }
            )
        ) {

            $statusPembayaran =
                'Lunas';

        } elseif (
            $invoices->contains(
                function ($invoice) {

                    return $invoice->paid_amount > 0;

                }
            )
        ) {

            $statusPembayaran =
                'Sebagian';

        } else {

            $statusPembayaran =
                'Belum Bayar';

        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'participants.dashboard',
            compact(
                'totalTagihan',
                'sudahDibayar',
                'sisaTagihan',
                'persentase',
                'statusPembayaran'
            )
        );
    }
}