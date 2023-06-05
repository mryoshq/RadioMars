<?php

// PaymentController
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required',
            'payment_method' => 'required',
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('payments.show', $payment);
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required',
            'payment_method' => 'required',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.show', $payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index');
    }
}
