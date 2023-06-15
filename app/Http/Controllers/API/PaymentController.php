<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Http\Controllers\Controller;

use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function index(Request $request)
    {
        // Get the currently authenticated user
        $advertiser = $request->user()->advertiser;
    
        // Get the Ads related to this advertiser
        $ads = $advertiser->ads;
    
        // Prepare an empty array to store the payments
        $payments = [];
    
        // Check if $ads is not null
        if($ads) {
            // Get the payments related to these ads
            foreach ($ads as $ad) {
                if ($ad->payments) {
                    foreach ($ad->payments as $payment) {
                        $payments[] = $payment;
                    }
                }
            }
        }
        
        return PaymentResource::collection(collect($payments));
    }
    
    
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'payment_method' => 'required|in:cc,transfer,wire',
            'status' => 'required|in:pending,paid,failed',
        ]);

        $payment = Payment::create($validated);

        return new PaymentResource($payment);
    }

    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'payment_method' => 'required|in:cc,transfer,wire',
            'status' => 'required|in:pending,paid,failed',
        ]);

        $payment->update($validated);

        return new PaymentResource($payment);
    }
}
