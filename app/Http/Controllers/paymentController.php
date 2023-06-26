<?php

// PaymentController
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Advertiser;
use App\Models\Ad;
use App\Models\User;
use App\Models\Pack;

use Illuminate\Support\Facades\DB;
 

use Illuminate\Http\Request;


 

class PaymentController extends Controller
{


      
    public function getAds(Request $request)
    {
        $advertiserId = $request->input('advertiser_id');
        $ads = Ad::where('advertiser_id', $advertiserId)->pluck('id', 'id')->toArray();
        return response()->json($ads);
    }




    public function index()
    {
        $payments = Payment::with([
            'ad' => function ($query) {
                $query->withTrashed();
                // withTrashed will allow fetching advertisers even when ad is deleted bc relationship is user to adv to ad to payment
            },
            'ad.pack'
        ])->get();
        
        return view('web.payments.index', compact('payments'));
    }






     
    public function create() 
    {
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
        return view('web.payments.create', compact('advertisers'));
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
    
        return redirect()->route('web.payments.index', $payment)->with('success', 'Payment created successfully');
    }
    





    public function show(Payment $payment)
    {
        return view('web.payments.show', compact('payment'));
    }






    public function edit(Payment $payment)
    {
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                ->pluck('name', 'id');
                                
        $ad_status = $payment->ad->status;
        return view('web.payments.edit', compact('payment', 'advertisers', 'ad_status'));
    }





    public function update(Request $request, Payment $payment)
    {
        $rules = [
            'payment_method' => 'required',
            'status' => 'required',
        ];

        if (!$request->input('advertiser_id_disabled')) { 
            $rules['advertiser_id'] = 'required|exists:advertisers,id';
        }

        if (!$request->input('ad_id_disabled')) {
            $rules['ad_id'] = 'required|exists:ads,id';
        }

        $validated = $request->validate($rules);

        $payment->update($validated);

        $ad = $payment->ad;

        if ($request->input('status') == 'paid') {
            if ($ad->decision == 'accepted') {
                $ad->status = 'active';
            } else {
                $ad->status = 'paused';
            }
        } else {
            if ($ad->decision == 'rejected') {
                $ad->status = 'not_active';
            } elseif ($ad->decision == 'in_queue') {
                $ad->status = 'paused';
            }
        }
        
        $ad->save();

        return redirect()->route('web.payments.index', ['page' => $request->page]);

    }




    

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('web.payments.index', $payment)->with('deleted', 'Payment deleted successfully!');
 
    }
}
