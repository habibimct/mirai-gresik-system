<?php

namespace App\Http\Controllers;

use App\Models\WaveFeeSetting;
use Illuminate\Http\Request;

class WaveFeeSettingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wave_id'  => 'required|exists:waves,id',
            'fee_name' => 'required|max:100',
            'amount'   => 'required|numeric|min:0',
        ]);

        WaveFeeSetting::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Biaya gelombang berhasil ditambahkan.');
    }

    public function update(
        Request $request,
        WaveFeeSetting $waveFeeSetting
    ) {
        $validated = $request->validate([
            'fee_name' => 'required|max:100',
            'amount'   => 'required|numeric|min:0',
        ]);

        $waveFeeSetting->update($validated);

        return back()->with(
            'success',
            'Biaya gelombang berhasil diubah.'
        );
    }

    public function destroy(
        WaveFeeSetting $waveFeeSetting
    ) {
        $used = \App\Models\ParticipantInvoiceItem::where(
            'source',
            'Wave'
        )
            ->where(
                'fee_name',
                $waveFeeSetting->fee_name
            )
            ->whereHas('invoice', function ($query) {
                $query->where('is_final', true);
            })
            ->exists();

        if ($used) {

            return back()->with(
                'error',
                'Biaya gelombang tidak dapat dihapus karena sudah terdapat tagihan peserta yang telah difinalkan.'
            );
        }

        $waveFeeSetting->delete();

        return back()->with(
            'success',
            'Biaya gelombang berhasil dihapus.'
        );
    }
}
