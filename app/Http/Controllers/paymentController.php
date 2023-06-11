<?php

// PaymentController
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Reservation;

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
        $users = User::all();
        $reservations = Reservation::all();
        return view('payments.create', compact('users', 'reservations'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:cc,transfer,wire',
            'status' => 'required|in:pending,paid,failed',
        ]);
    
        $payment = Payment::create($validated);
    
        return redirect()->route('payments.show', $payment)->with('success', 'Payment created successfully');
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
