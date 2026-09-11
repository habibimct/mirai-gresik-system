<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Wave;
use App\Models\WaveProgram;
use App\Models\ParticipantWaveProgram;
use App\Models\FeeSetting;
use App\Models\WaveFeeSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ParticipantWaveProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Participant $participant)
    {
        $participant->load('user');

        $programs = ParticipantWaveProgram::with([
            'waveProgram.wave',
            'waveProgram.program',
            'participantClassroom.invoice',
        ])
            ->where('participant_id', $participant->id)
            ->paginate(10);

        $programs->getCollection()->transform(function ($program) {

            /*
        |--------------------------------------------------------------------------
        | STATUS FINAL
        |--------------------------------------------------------------------------
        */

            $program->is_finalized =
                $program->participantClassroom?->invoice?->is_final ?? false;


            /*
        |--------------------------------------------------------------------------
        | BIAYA STANDAR
        |--------------------------------------------------------------------------
        */

            $waveProgram = $program->waveProgram;

            if ($waveProgram) {

                $waveFees = WaveFeeSetting::where(
                    'wave_id',
                    $waveProgram->wave_id
                )->sum('amount');


                $programFees = FeeSetting::where(
                    'program_id',
                    $waveProgram->program_id
                )
                    ->where(
                        'wave_id',
                        $waveProgram->wave_id
                    )
                    ->sum('amount');


                $program->standard_fee =
                    $waveFees + $programFees;
            } else {

                $program->standard_fee = 0;
            }


            return $program;
        });


        return view(
            'participant-wave-programs.index',
            compact(
                'participant',
                'programs'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Participant $participant)
    {
        $waves = Wave::where('is_active', true)
            ->orderBy('year')
            ->orderBy('name')
            ->get();

        return view(
            'participant-wave-programs.create',
            compact(
                'participant',
                'waves'
            )
        );
    }

    public function availablePrograms(
        Participant $participant,
        Wave $wave
    ) {
        $selected = ParticipantWaveProgram::where(
            'participant_id',
            $participant->id
        )->pluck('wave_program_id');

        $programs = WaveProgram::with('program')
            ->where('wave_id', $wave->id)
            ->where('is_active', true)
            ->whereNotIn('id', $selected)
            ->get()
            ->map(function ($item) {

                $terisi = ParticipantWaveProgram::where(
                    'wave_program_id',
                    $item->id
                )
                    ->whereIn('status', [
                        'Aktif',
                        'Lulus'
                    ])
                    ->count();

                return [

                    'id' => $item->id,
                    'program' => $item->program->name,
                    'fee' => $item->fee,
                    'quota' => $item->quota,
                    'filled' => $terisi,
                    'remaining' => $item->quota - $terisi,

                ];
            });

        return response()->json($programs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Participant $participant)
    {
        $request->validate([
            'wave_programs' => 'required|array|min:1',
            'wave_programs.*' => 'exists:wave_programs,id',
        ]);

        DB::transaction(function () use ($request, $participant) {

            foreach ($request->wave_programs as $waveProgram) {

                ParticipantWaveProgram::firstOrCreate(
                    [
                        'participant_id' => $participant->id,
                        'wave_program_id' => $waveProgram,
                    ],
                    [
                        'agreed_fee' => null,
                        'discount' => 0,
                        'status' => 'Aktif',
                    ]
                );
            }
        });

        return redirect()
            ->route('participants.programs.index', $participant)
            ->with('success', 'Program peserta berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant, ParticipantWaveProgram $program)
    {
        $program->load([
            'waveProgram.program',
            'waveProgram.wave',
        ]);

        $waveProgram = $program->waveProgram;

        /*
    |--------------------------------------------------------------------------
    | BIAYA STANDAR
    |--------------------------------------------------------------------------
    */

        $waveFees = WaveFeeSetting::where(
            'wave_id',
            $waveProgram->wave_id
        )->get();

        $programFees = FeeSetting::where(
            'program_id',
            $waveProgram->program_id
        )
            ->where(
                'wave_id',
                $waveProgram->wave_id
            )
            ->get();

        $standardFee =
            $waveFees->sum('amount')
            +
            $programFees->sum('amount');


        /*
    |--------------------------------------------------------------------------
    | BIAYA KHUSUS
    |--------------------------------------------------------------------------
    */

        $agreedFee = $program->agreed_fee;

        $discount = $program->discount ?? 0;


        /*
    |--------------------------------------------------------------------------
    | TOTAL TAGIHAN
    |--------------------------------------------------------------------------
    */

        $baseFee = $agreedFee !== null
            ? $agreedFee
            : $standardFee;

        $finalFee = max(
            0,
            $baseFee - $discount
        );


        return view(
            'participant-wave-programs.edit',
            compact(
                'participant',
                'program',
                'standardFee',
                'agreedFee',
                'discount',
                'finalFee'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Participant $participant,
        ParticipantWaveProgram $program
    ) {
        $isFinalized =
            $program->participantClassroom?->invoice?->is_final ?? false;

        if ($isFinalized) {

            return back()->with(
                'error',
                'Program peserta tidak dapat diubah karena tagihan sudah difinalkan.'
            );
        }

        $request->validate([
            'agreed_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                'in:Aktif,Lulus,Mengundurkan Diri,Dibatalkan',
            ],
        ]);

        $program->update([

            'agreed_fee' => $request->filled('agreed_fee')
                ? $request->agreed_fee
                : null,

            'discount' => $request->filled('discount')
                ? $request->discount
                : 0,

            'status' => $request->status,

        ]);

        return redirect()

            ->route(
                'participants.programs.index',
                $participant
            )

            ->with(
                'success',
                'Program peserta berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Participant $participant,
        ParticipantWaveProgram $program
    ) {
        $isFinalized =
            $program->participantClassroom?->invoice?->is_final ?? false;

        if ($isFinalized) {

            return back()->with(
                'error',
                'Program peserta tidak dapat dihapus karena tagihan sudah difinalkan.'
            );
        }

        $program->delete();

        return redirect()
            ->route(
                'participants.programs.index',
                $participant
            )
            ->with(
                'success',
                'Program peserta berhasil dihapus.'
            );
    }
}
