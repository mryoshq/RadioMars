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
    public function index()
    {
        $payments = Payment::all();
        return view('web.payments.index', compact('payments'));
    }
    public function create() 
    {
  
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
        return view('web.payments.create', compact('advertisers'));
    }

    public function getAds(Request $request)
    {
        $advertiserId = $request->input('advertiser_id');
        $ads = Ad::where('advertiser_id', $advertiserId)->pluck('id', 'id')->toArray();
        return response()->json($ads);
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
        return view('web.payments.edit', compact('payment'));
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

        return redirect()->route('web.payments.show', $payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('web.payments.index', $payment)->with('deleted', 'Payment deleted successfully!');
 
    }
}
