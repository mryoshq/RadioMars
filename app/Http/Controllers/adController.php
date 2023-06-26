<?php

// AdController
namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\Pack;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('pack', 'advertiser.user', 'payment')->get(); 
        return view('web.ads.index', compact('ads'));
    }
    public function getVariations(Request $request)
    { 
        $packId = $request->input('pack_id');
        $pack = Pack::find($packId);
    
        if($pack){
            $variations = range(1, $pack->variations);
        } else {
            $variations = [];
        }
    
        return response()->json($variations);
    }
    

    public function create()
    {
        $packs = Pack::all();
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
        $variations = [];
        foreach ($packs as $pack) {
            $variations[$pack->id] = range(1, $pack->variations);
        }
        return view('web.ads.create', compact('packs', 'advertisers', 'variations'));
    }
    
  
        public function store(Request $request)
        {
            $validated = $request->validate([
                'advertiser_id' => 'required|exists:advertisers,id',
                'pack_id' => 'required|exists:packs,id',
                'text_content' => 'nullable|string',
                'audio_content' => 'nullable|string',
                'status' => 'required|in:active,not_active,paused',
                'decision' => 'required|in:accepted,in_queue,rejected',
                'message' => 'nullable|string',
                'programmed_for' => 'required|date|after_or_equal:today',
            ]);
    
            $request->validate([
                'audio_content' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if (empty($request->text_content) && empty($value)) {
                            $fail('The text content or audio content must be provided.');
                        }
                        if (!empty($request->text_content) && !empty($value)) {
                            $fail('Only one of text content or audio content can be provided.');
                        }
                    }, 
                ],
                'text_content' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if (!empty($request->audio_content) && !empty($value)) {
                            $fail('Only one of text content or audio content can be provided.');
                        }
                    },
                ],
            ]);
    
            $ad = Ad::create($validated + ['pack_variation' => $request->pack_variation]);
    
            return redirect()->route('web.ads.index', $ad)->with('success', 'Ad created successfully');
        }
    
    
    
    
      
    public function show(Ad $ad)
    {
        return view('web.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        $packs = Pack::select(DB::raw("CONCAT(name, ' - ', id) AS name"), 'packs.id')
                     ->pluck('name', 'id');
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
        
        $paymentStatus = null;
        $payment = $ad->payment()->first();
        if ($payment) {
            $paymentStatus = $this->translatePaymentStatus($payment->status);
        }
    
        return view('web.ads.edit', compact('ad', 'packs', 'advertisers', 'paymentStatus'));
    }
    
    private function translatePaymentStatus($status) {
        $translations = [
            'paid' => 'Payé',
            'pending' => 'En attente',
            'failed' => 'Échoué',
            // Add other statuses here
        ];
    
        return $translations[$status] ?? $status;
    }
    
    
     
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'advertiser_id' => 'sometimes|exists:advertisers,id',
            'pack_id' => 'sometimes|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'sometimes|in:active,not_active,paused',
            'pack_variation' => 'sometimes|integer',
            'final_text_content' => 'nullable|string',
            'final_audio_content' => 'nullable|string',
            'decision' => 'required|in:accepted,in_queue,rejected',
            'message' => 'nullable|string',
            'programmed_for' => 'nullable|date',
        ]);

        //updating data
        $updateData = $validated;
    
        if ($request->input('advertiser_id_disabled') === 'true') {
            $updateData['advertiser_id'] = $ad->advertiser_id;
        }
    
        if ($request->input('pack_id_disabled') === 'true') {
            $updateData['pack_id'] = $ad->pack_id;
        }
    
        if ($request->input('pack_variation_disabled') === 'true') {
            $updateData['pack_variation'] = $ad->pack_variation;
        }

        if ($request->input('status_disabled') === 'true') {
            $updateData['status'] = $ad->status;
        }
        $updateData['text_content'] = $validated['final_text_content'];
        $updateData['audio_content'] = $validated['final_audio_content'];
        $updateData['decision'] = $validated['decision']; // Add this 
        $updateData['message'] = $validated['message']; // Add this
        $updateData['programmed_for'] = $validated['programmed_for']; 
    



        $paymentStatus = $ad->payment->status ?? '';

        if($validated['decision'] == 'accepted') {
            if($paymentStatus == 'paid') {
                $updateData['status'] = 'active';
            } else {
                $updateData['status'] = 'paused';
            }
        } elseif($validated['decision'] == 'rejected') {
            $updateData['status'] = 'not_active';
        } elseif($validated['decision'] == 'in_queue') {
            $updateData['status'] = 'paused';
        }
        
        $ad->update($updateData);
        

        return redirect()->route('web.ads.index')->with('success', 'Ad updated successfully');
    }
    
    
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('web.ads.index')->with('deleted', 'Ad deleted successfully!');
    }
 
}
