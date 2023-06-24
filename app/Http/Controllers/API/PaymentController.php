<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Http\Controllers\Controller; 

use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request; 


class PaymentController extends Controller
{
    /**
     * Display a listing of the user's payments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function index(Request $request)
    {
        try {
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found for this user.'], 404);
            }
    
            $ads = $advertiser->ads()->with('payment')->get();
    
            $payments = [];
    
            foreach ($ads as $ad) {
                if ($ad->payment) {
                    $payments[] = $ad->payment;
                }
            }
    
            return PaymentResource::collection(collect($payments));
        } catch (\Exception $e) {
            // catch other errors
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
    /**
     * Display the specified payment.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\PaymentResource
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     * @urlParam id integer required The ID of the ad.
     */
    public function show($id, Request $request)
    {
        try {
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found for this user.'], 404);
            }
    
            $payment = Payment::find($id);
            if (!$payment) {
                return response()->json(['error' => 'Payment not found.'], 404);
            }
    
            $payment->load('ad');
            
            if (!$payment->ad || $payment->ad->advertiser->id !== $advertiser->id) {
                return response()->json(['error' => 'Payment not found for this user.'], 404);
            }
    
            return new PaymentResource($payment);
        } catch (\Exception $e) {
            // catch other errors
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
    


    /**
     * Store a newly created payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\PaymentResource
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'ad_id.required' => 'The ad id field is required.',
                'ad_id.integer' => 'The ad id must be an integer.',
                'ad_id.exists' => 'The selected ad id is invalid.',
                'payment_method.required' => 'The payment method field is required.',
                'payment_method.in' => 'The selected payment method is invalid.',
                'status.required' => 'The status field is required.',
                'status.in' => 'The selected status is invalid.',
            ];
    
            $validated = $request->validate([
                'ad_id' => 'required|integer|exists:ads,id',
                'payment_method' => 'required|in:cc,transfer,wire',
                'status' => 'required|in:pending,paid,failed',
            ], $messages);
         
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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment. ' . $e->getMessage()
            ], 500);
        }
    }
    
    
     
    

   /**
     * Update the specified payment .
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\PaymentResource
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function update(Request $request, Payment $payment)
    {
        try {
            $messages = [
                'payment_method.required' => 'The payment method field is required.',
                'payment_method.in' => 'The selected payment method is invalid.',
                'status.required' => 'The status field is required.',
                'status.in' => 'The selected status is invalid.',
            ];
    
            // Fetch the authenticated user's advertiser
            $advertiser = $request->user()->advertiser;
        
            // Check if the payment's related ad belongs to the authenticated user
            if($payment->ad && $payment->ad->advertiser->id !== $advertiser->id) {
                // Return a 403 Forbidden HTTP response
                return response()->json(['error' => 'This payment does not belong to the authenticated user'], 403);
            }
        
            $validated = $request->validate([
                'payment_method' => 'required|in:cc,transfer,wire',
                'status' => 'required|in:pending,paid,failed',
            ], $messages);
        
            $payment->update($validated);
        
            return new PaymentResource($payment);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update payment. ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
}
