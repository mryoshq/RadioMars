<?php

// PaymentController
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Advertiser;
use App\Models\Ad;

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
        $advertisers = Advertiser::all();
        $ads = Ad::all();
        return view('payments.create', compact('advertisers', 'ads'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'advertiser_id' => 'required|exists:advertisers,id',
            'ad_id' => 'required|exists:ads,id',
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
            
            'advertiser_id' => 'required|exists:advertisers,id',
            'ad_id' => 'required|exists:ads,id',
            'payment_method' => 'required',
            'status' => 'required',
         
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
