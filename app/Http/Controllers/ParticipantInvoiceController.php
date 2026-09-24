<?php

namespace App\Http\Controllers;

use App\Models\FeeSetting;
use App\Models\ParticipantClassroom;
use App\Models\ParticipantInvoice;
use App\Models\ParticipantInvoiceItem;
use App\Models\ParticipantWaveProgram;
use App\Models\WaveFeeSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;
use App\Models\Wave;
use App\Models\Classroom;
use App\Models\Payment;
use Illuminate\Http\Request;

class ParticipantInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::orderBy('name')->get();

        $waves = Wave::orderBy('name')->get();

        $classrooms = Classroom::whereHas('waveProgram', function ($query) use ($request) {
            $query->where('wave_id', $request->wave_id);
        })
            ->orderBy('name')
            ->get();

        $participants = collect();

        $payments = collect();

        if ($request->filled('classroom_id')) {

            $participants = ParticipantClassroom::with([
                'participantWaveProgram.participant.user',
                'participantWaveProgram.waveProgram.program',
                'classroom.waveProgram.wave',
                'invoice',
            ])
                ->where('classroom_id', $request->classroom_id)
                ->get();

            $payments = Payment::with([
                'invoice.participantClassroom.participantWaveProgram.participant.user',
                'receiver'
            ])
                ->whereHas('invoice.participantClassroom', function ($q) use ($request) {
                    $q->where('classroom_id', $request->classroom_id);
                })
                ->latest('payment_date')
                ->get();
        }

        return view(
            'finance.participant-invoices.index',
            compact(
                'programs',
                'waves',
                'classrooms',
                'participants',
                'payments'
            )
        );
    }

    public function show(
        ParticipantInvoice $participantInvoice
    ) {

        $participantInvoice->load([
            'items',
            'payments.receiver',
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
        ]);

        return view(
            'finance.participant-invoices.partials.show',
            compact('participantInvoice')
        );
    }

    public function generate(ParticipantClassroom $participantClassroom)
    {
        $invoice = $participantClassroom->invoice;

        try {

            $this->generateInvoice($participantClassroom);
        } catch (\Exception $e) {

            return back()->with(
                'warning',
                $e->getMessage()
            );
        }

        if ($invoice) {

            return back()->with(
                'success',
                'Tagihan peserta berhasil diperbarui.'
            );
        }

        return back()->with(
            'success',
            'Tagihan peserta berhasil dibuat.'
        );
    }

    public function generateAll(Request $request)
    {
        $participants = ParticipantClassroom::with([
            'participantWaveProgram.participant.user',
            'participantWaveProgram.waveProgram.program',
            'participantWaveProgram.waveProgram.wave',
            'invoice',
        ])
            ->where('classroom_id', $request->classroom_id)
            ->get();

        $created = 0;
        $updated = 0;
        $failed = [];

        foreach ($participants as $participant) {

            $hadInvoice = $participant->invoice !== null;

            try {

                $this->generateInvoice($participant);

                if ($hadInvoice) {
                    $updated++;
                } else {
                    $created++;
                }
            } catch (\Exception $e) {

                $failed[] = $e->getMessage();
            }
        }


        /*
    |--------------------------------------------------------------------------
    | PESAN HASIL GENERATE
    |--------------------------------------------------------------------------
    */

        $messages = [];


        if ($created > 0) {

            $messages[] =
                "{$created} tagihan baru berhasil dibuat.";
        }


        if ($updated > 0) {

            $messages[] =
                "{$updated} tagihan berhasil diperbarui.";
        }


        if (count($failed) > 0) {

            $messages[] =
                count($failed)
                . " tagihan gagal diperbarui karena total tagihan lebih kecil dari pembayaran yang sudah diterima.";
        }


        /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

        return back()
            ->with('generate_messages', $messages)
            ->with('generate_failed', $failed);
    }

    public function unfinal(ParticipantInvoice $participantInvoice)
    {
        $participantInvoice->update([
            'is_final' => false,
        ]);

        return back()->with(
            'success',
            'Invoice berhasil dibuka kembali dan sekarang berstatus Draft.'
        );
    }

    private function generateInvoice(
        ParticipantClassroom $participantClassroom
    ) {
        return DB::transaction(function () use ($participantClassroom) {

            /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PROGRAM & GELOMBANG
        |--------------------------------------------------------------------------
        */

            $participantWaveProgram = $participantClassroom
                ->participantWaveProgram;

            $waveProgram = $participantWaveProgram
                ->waveProgram;

            $participantId = $participantWaveProgram
                ->participant_id;

            $programId = $waveProgram->program_id;
            $waveId = $waveProgram->wave_id;


            /*
        |--------------------------------------------------------------------------
        | TENTUKAN PEMILIK BIAYA GELOMBANG
        |--------------------------------------------------------------------------
        |
        | Satu peserta dapat mengikuti beberapa program
        | dalam satu gelombang.
        |
        | Biaya gelombang hanya dimasukkan ke SATU invoice.
        |
        | Kita gunakan ParticipantWaveProgram dengan ID terkecil
        | sebagai pemilik biaya gelombang.
        |
        */

            $waveFeeOwnerId = ParticipantWaveProgram::where(
                'participant_id',
                $participantId
            )
                ->whereHas('waveProgram', function ($query) use ($waveId) {

                    $query->where('wave_id', $waveId);
                })
                ->orderBy('id')
                ->value('id');


            $isWaveFeeOwner =
                $participantWaveProgram->id == $waveFeeOwnerId;


            /*
        |--------------------------------------------------------------------------
        | AMBIL / BUAT INVOICE
        |--------------------------------------------------------------------------
        */

            $invoice = ParticipantInvoice::firstOrCreate(
                [
                    'participant_classroom_id'
                    => $participantClassroom->id,
                ],
                [
                    'total_amount' => 0,
                    'paid_amount' => 0,
                    'status' => 'Belum Bayar',
                    'is_final' => false,
                ]
            );


            /*
        |--------------------------------------------------------------------------
        | HAPUS ITEM INVOICE LAMA
        |--------------------------------------------------------------------------
        */

            $invoice->items()->delete();


            /*
        |--------------------------------------------------------------------------
        | AMBIL BIAYA GELOMBANG
        |--------------------------------------------------------------------------
        */

            $waveFees = collect();

            if ($isWaveFeeOwner) {

                $waveFees = WaveFeeSetting::where(
                    'wave_id',
                    $waveId
                )->get();
            }


            /*
        |--------------------------------------------------------------------------
        | AMBIL BIAYA PROGRAM
        |--------------------------------------------------------------------------
        */

            $programFees = FeeSetting::where(
                'program_id',
                $programId
            )
                ->where(
                    'wave_id',
                    $waveId
                )
                ->get();


            /*
        |--------------------------------------------------------------------------
        | HITUNG BIAYA PROGRAM
        |--------------------------------------------------------------------------
        */

            $standardProgramFee = $programFees->sum('amount');


            /*
        |--------------------------------------------------------------------------
        | AGREED FEE
        |--------------------------------------------------------------------------
        */

            $agreedFee = $participantWaveProgram->agreed_fee;

            if ($agreedFee !== null) {

                $programTotal = (float) $agreedFee;
            } else {

                $programTotal = (float) $standardProgramFee;
            }


            /*
        |--------------------------------------------------------------------------
        | TOTAL AWAL
        |--------------------------------------------------------------------------
        */

            $total =
                $waveFees->sum('amount')
                + $programTotal;


            /*
        |--------------------------------------------------------------------------
        | ITEM BIAYA GELOMBANG
        |--------------------------------------------------------------------------
        |
        | Hanya invoice yang menjadi pemilik Wave Fee
        | yang akan mendapatkan item ini.
        |
        */

            foreach ($waveFees as $fee) {

                ParticipantInvoiceItem::create([

                    'participant_invoice_id'
                    => $invoice->id,

                    'source'
                    => 'Wave',

                    'fee_name'
                    => $fee->fee_name,

                    'amount'
                    => $fee->amount,

                    'is_required'
                    => strcasecmp(
                        $fee->fee_name,
                        'Pendaftaran'
                    ) === 0,

                ]);
            }


            /*
        |--------------------------------------------------------------------------
        | ITEM BIAYA PROGRAM
        |--------------------------------------------------------------------------
        */

            if ($agreedFee !== null) {

                ParticipantInvoiceItem::create([

                    'participant_invoice_id'
                    => $invoice->id,

                    'source'
                    => 'Program',

                    'fee_name'
                    => 'Biaya Program (Penyesuaian Khusus)',

                    'amount'
                    => $programTotal,

                    'is_required'
                    => false,

                ]);
            } else {

                foreach ($programFees as $fee) {

                    ParticipantInvoiceItem::create([

                        'participant_invoice_id'
                        => $invoice->id,

                        'source'
                        => 'Program',

                        'fee_name'
                        => $fee->fee_name,

                        'amount'
                        => $fee->amount,

                        'is_required'
                        => false,

                    ]);
                }
            }


            /*
        |--------------------------------------------------------------------------
        | DISKON
        |--------------------------------------------------------------------------
        */

            $discount = (float) (
                $participantWaveProgram->discount ?? 0
            );

            if ($discount > 0) {

                ParticipantInvoiceItem::create([

                    'participant_invoice_id'
                    => $invoice->id,

                    'source'
                    => 'Diskon',

                    'fee_name'
                    => 'Diskon',

                    'amount'
                    => -$discount,

                    'is_required'
                    => false,

                ]);

                $total -= $discount;
            }


            /*
        |--------------------------------------------------------------------------
        | AMBIL TOTAL PEMBAYARAN YANG SUDAH ADA
        |--------------------------------------------------------------------------
        */

            $paidAmount = (float) $invoice
                ->payments()
                ->sum('amount');


            /*
        |--------------------------------------------------------------------------
        | CEK TOTAL BARU
        |--------------------------------------------------------------------------
        */

            if ($paidAmount > $total) {

                $participantName = $participantWaveProgram
                    ->participant
                    ->user
                    ->name;

                throw new \Exception(

                    "Peserta {$participantName}: total tagihan baru Rp "
                        . number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        )
                        . " lebih kecil dari pembayaran yang sudah diterima Rp "
                        . number_format(
                            $paidAmount,
                            0,
                            ',',
                            '.'
                        )
                );
            }


            /*
        |--------------------------------------------------------------------------
        | TENTUKAN STATUS
        |--------------------------------------------------------------------------
        */

            if ($paidAmount <= 0) {

                $status = 'Belum Bayar';
            } elseif ($paidAmount >= $total) {

                $status = 'Lunas';
            } else {

                $status = 'Sebagian';
            }


            /*
        |--------------------------------------------------------------------------
        | UPDATE INVOICE
        |--------------------------------------------------------------------------
        */

            $invoice->update([

                'total_amount'
                => $total,

                'paid_amount'
                => $paidAmount,

                'status'
                => $status,

            ]);


            return $invoice;
        });
    }

    public function destroy(
        ParticipantInvoice $participantInvoice
    ) {
        $participantInvoice->delete();

        return redirect()
            ->route('finance.participant-invoices.index')
            ->with(
                'success',
                'Tagihan berhasil dihapus.'
            );
    }

    public function whatsappData(ParticipantInvoice $participantInvoice)
    {
        $participantInvoice->load([
            'items',
            'participantClassroom.participantWaveProgram.participant.user',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
        ]);

        $user = $participantInvoice
            ->participantClassroom
            ->participantWaveProgram
            ->participant
            ->user;

        $program = $participantInvoice
            ->participantClassroom
            ->participantWaveProgram
            ->waveProgram
            ->program
            ->name;

        $wave = $participantInvoice
            ->participantClassroom
            ->classroom
            ->waveProgram
            ->wave
            ->name;

        $detail = '';

        foreach ($participantInvoice->items as $item) {

            $detail .= "• {$item->fee_name} : Rp "
                . number_format($item->amount, 0, ',', '.')
                . "\n";
        }

        $total = number_format(
            $participantInvoice->total_amount,
            0,
            ',',
            '.'
        );

        $paid = number_format(
            $participantInvoice->paid_amount,
            0,
            ',',
            '.'
        );

        $remaining = number_format(
            $participantInvoice->total_amount - $participantInvoice->paid_amount,
            0,
            ',',
            '.'
        );

        $message = "Yth. {$user->name},

Berikut informasi tagihan Anda.

Program: {$program}
Gelombang: {$wave}

=========================
RINCIAN BIAYA
=========================

{$detail}
=========================

Total Tagihan: Rp {$total}
Sudah Dibayar: Rp {$paid}
Sisa Tagihan: Rp {$remaining}";

        return response()->json([
            'id'      => $participantInvoice->id,
            'name'    => $user->name,
            'phone'   => $user->phone,
            'message' => $message,
        ]);
    }

    public function myInvoices()
    {
        $participant = Auth::user()->participant;

        if (!$participant) {
            abort(
                403,
                'Akun ini belum terhubung dengan data peserta.'
            );
        }

        $invoices = ParticipantInvoice::with([
            'items',
            'participantClassroom.participantWaveProgram.waveProgram.program',
            'participantClassroom.classroom.waveProgram.wave',
            'payments',
        ])
            ->where('is_final', true)
            ->whereHas(
                'participantClassroom.participantWaveProgram',
                function ($query) use ($participant) {

                    $query->where(
                        'participant_id',
                        $participant->id
                    );
                }
            )
            ->orderByRaw("
                            CASE
                                WHEN status = 'Belum Bayar' THEN 1
                                WHEN status = 'Sebagian' THEN 2
                                WHEN status = 'Lunas' THEN 3
                                ELSE 4
                            END
                        ")
            ->orderByDesc('id')
            ->get();

        return view(
            'participants.invoices.index',
            compact('invoices')
        );
    }

    public function finalize(ParticipantInvoice $participantInvoice)
    {
        if ($participantInvoice->is_final) {

            return back()->with(
                'warning',
                'Tagihan peserta tersebut sudah berstatus final.'
            );
        }

        $participantInvoice->update([
            'is_final' => true,
        ]);

        return back()->with(
            'success',
            'Tagihan berhasil difinalkan dan sekarang dapat dilihat oleh peserta.'
        );
    }
}
