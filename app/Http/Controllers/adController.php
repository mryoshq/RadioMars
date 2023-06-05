<?php

// AdController
namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return view('ads.index', compact('ads'));
    }

    public function create()
    {
        return view('ads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'required',
            'status' => 'required',
        ]);

        $ad = Ad::create($validated);

        return redirect()->route('ads.show', $ad);
    }

    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'required',
            'status' => 'required',
        ]);

        $ad->update($validated);

        return redirect()->route('ads.show', $ad);
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('ads.index');
    }
}
