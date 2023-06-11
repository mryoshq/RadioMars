<?php

// CampaignController
namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\User;    
use App\Models\Ad;


class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::all();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $users = User::all();
        return view('campaigns.create', compact('users'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:planning,active,ended',
        ]);
    
        $campaign = Campaign::create($validated);
    
        return redirect()->route('campaigns.show', $campaign)->with('success', 'Campaign created successfully');
    }
    

    public function show(Campaign $campaign)
    {
        return view('campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required',
        ]);

        $campaign->update($validated);

        return redirect()->route('campaigns.show', $campaign);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('campaigns.index');
    }
}
