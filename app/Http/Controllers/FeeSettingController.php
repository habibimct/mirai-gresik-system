<?php

namespace App\Http\Controllers;

use App\Models\FeeSetting;
use App\Models\Program;
use App\Models\Wave;
use App\Models\WaveFeeSetting;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $programs = Program::orderBy('name')->get();
        $waves = Wave::orderBy('name')->get();

        $feeSettings = FeeSetting::with(['program', 'wave'])
            ->when($request->program_id, function ($query) use ($request) {
                $query->where('program_id', $request->program_id);
            })
            ->when($request->wave_id, function ($query) use ($request) {
                $query->where('wave_id', $request->wave_id);
            })
            ->orderBy('fee_name')
            ->get()
            ->map(function ($fee) {

                $fee->is_finalized = \App\Models\ParticipantInvoiceItem::where(
                    'source',
                    'Program'
                )
                    ->where(
                        'fee_name',
                        $fee->fee_name
                    )
                    ->whereHas('invoice', function ($query) {
                        $query->where('is_final', true);
                    })
                    ->exists();

                return $fee;
            });

        $waveFeeSettings = collect();

        if (request('wave_id')) {

            $waveFeeSettings = WaveFeeSetting::where(
                'wave_id',
                request('wave_id')
            )
                ->get()
                ->map(function ($fee) {

                    $fee->is_finalized = \App\Models\ParticipantInvoiceItem::where(
                        'source',
                        'Wave'
                    )
                        ->where(
                            'fee_name',
                            $fee->fee_name
                        )
                        ->whereHas('invoice', function ($query) {
                            $query->where('is_final', true);
                        })
                        ->exists();

                    return $fee;
                });
        }

        return view(
            'finance.fee-settings.index',
            compact(
                'programs',
                'waves',
                'feeSettings',
                'waveFeeSettings'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'wave_id'    => 'required|exists:waves,id',
            'fee_name'   => [
                'required',
                Rule::unique('fee_settings')
                    ->where(fn($query) => $query
                        ->where('program_id', $request->program_id)
                        ->where('wave_id', $request->wave_id)),
            ],
            'amount' => 'required|numeric|min:0',
        ]);

        FeeSetting::create($validated);

        return back()->with(
            'success',
            'Biaya berhasil ditambahkan.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeSetting $feeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeSetting $feeSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        FeeSetting $feeSetting
    ) {
        $validated = $request->validate([

            'fee_name' => [

                'required',

                Rule::unique('fee_settings')
                    ->ignore($feeSetting->id)
                    ->where(
                        fn($query) => $query
                            ->where('program_id', $feeSetting->program_id)
                            ->where('wave_id', $feeSetting->wave_id)
                    ),

            ],

            'amount' => 'required|numeric|min:0',

        ]);

        $feeSetting->update($validated);

        return back()->with(
            'success',
            'Biaya berhasil diperbarui.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeSetting $feeSetting)
    {
        $used = \App\Models\ParticipantInvoiceItem::where(
            'source',
            'Program'
        )
            ->where(
                'fee_name',
                $feeSetting->fee_name
            )
            ->whereHas('invoice', function ($query) {
                $query->where('is_final', true);
            })
            ->exists();

        if ($used) {

            return back()->with(
                'error',
                'Biaya program tidak dapat dihapus karena sudah terdapat tagihan peserta yang telah difinalkan.'
            );
        }

        $feeSetting->delete();

        return back()->with(
            'success',
            'Biaya berhasil dihapus.'
        );
    }
}
