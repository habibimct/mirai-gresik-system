<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentTypes = PaymentType::orderBy('name')->paginate(10);

        return view(
            'finance.payment-types.index',
            compact('paymentTypes')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|max:100|unique:payment_types,name',

            'description' => 'nullable',

            'is_registration' => 'nullable|boolean',

            'is_active' => 'nullable|boolean',

        ]);

        $validated['is_registration'] = $request->has('is_registration');
        $validated['is_active'] = $request->has('is_active');

        PaymentType::create($validated);

        return redirect()
            ->route('finance.payment-types.index')
            ->with('success', 'Jenis tagihan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentType $paymentType)
    {
        return view(
            'payment-types.edit',
            compact('paymentType')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        $validated = $request->validate([

            'name' => 'required|max:100|unique:payment_types,name,' . $paymentType->id,

            'description' => 'nullable',

            'is_registration' => 'nullable|boolean',

            'is_active' => 'nullable|boolean',

        ]);

        $validated['is_registration'] = $request->has('is_registration');
        $validated['is_active'] = $request->has('is_active');

        $paymentType->update($validated);

        return redirect()
            ->route('finance.payment-types.index')
            ->with('success', 'Jenis tagihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentType $paymentType)
    {
        $paymentType->delete();

        return back()->with(
            'success',
            'Jenis tagihan berhasil dihapus.'
        );
    }
}
