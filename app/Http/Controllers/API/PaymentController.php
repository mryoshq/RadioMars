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
        $ads = $advertiser->ads()->with('payment')->get();
    
        // Prepare an empty array to store the payments
        $payments = [];
    
        // Check if $ads is not null
        if($ads) {
            // Get the payment related to these ads
            foreach ($ads as $ad) {
                if ($ad->payment) {
                    $payments[] = $ad->payment;
                }
            }
        }
        
        return PaymentResource::collection(collect($payments));
    }
    
   

    public function show($id, Request $request)
    {
        // Get the currently authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
        
        // Find the payment
        $payment = Payment::find($id);
        
        if(!$payment){
            // Return a 404 Not Found HTTP response
            return response()->json(['error' => 'Payment not found'], 404);
        }
    
        // Load the ad relationship for the payment
        $payment->load('ad'); 
    
        // Check if the payment's related ad belongs to the authenticated user
        if($payment->ad && $payment->ad->advertiser->id == $advertiser->id) {
            // Return the payment
            return new PaymentResource($payment);
        } else {
            // Return a 404 Not Found HTTP response
            return response()->json(['error' => 'Payment not found for this user'], 404);
        }
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'payment_method' => 'required|in:cc,transfer,wire',
            'status' => 'required|in:pending,paid,failed',
        ]);
     
        // Fetch the authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
    
        // Fetch the ad with the given id that belongs to the advertiser
        $ad = $advertiser->ads()->find($validated['ad_id']);
    
        if (!$ad) {
            // If the ad does not exist, return error response
            return response()->json(['error' => 'No ad with such id for this user'], 403);
        }
    
        // Create the payment
        $payment = $ad->payment()->create(array_merge($validated, ['advertiser_id' => $advertiser->id]));
    
        return new PaymentResource($payment);
    }
    
     
    
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|in:cc,transfer,wire',
            'status' => 'required|in:pending,paid,failed',
        ]);
    
        $payment->update($request->all());
    
        return new PaymentResource($payment);
    }
    
}
