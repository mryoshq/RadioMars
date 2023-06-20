<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Ad;
use App\Models\Payment; 
 
 
class DashboardController extends Controller
{
    public function index()
    {
        // Get pack names and the count of ads for each pack
        $packs = DB::table('ads')
            ->join('packs', 'ads.pack_id', '=', 'packs.id')
            ->select('packs.name', DB::raw('count(ads.id) as ads_count'))
            ->groupBy('packs.name')
            ->get();
    
        // Prepare labels and data for the chart
        $labels = $packs->pluck('name');
        $data = $packs->pluck('ads_count');
    
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'pubs par packs',
                    'backgroundColor' => '#F1C376',
                    'hoverBackgroundColor' => '#606C5D',
                    'data' => $data,
                ],
            ],
        ];
 
      //  Log::info('Packs: ', ['packs' => $packs]);
  
        $payments = DB::table('payments')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    // data
    $paymentData = $payments->pluck('count');

   // labels
    $paymentLabels = $payments->pluck('status');

    $colorMap = [
        'failed' => '#FF6384',
        'pending' => '#36A2EB',
        'paid' => '#D0F5BE'
    ];
    
    $backgroundColor = [];
    foreach ($paymentLabels as $label) {
        if (isset($colorMap[$label])) {
            $backgroundColor[] = $colorMap[$label];
        } else {
            $backgroundColor[] = '#000000'; // default color if the status is not found in the colorMap
        }
    }
    
    $chartData2 = [
        'labels' => $paymentLabels,
        'datasets' => [
            [
                'data' => $paymentData,
                'backgroundColor' => $backgroundColor,
            ],
        ],
    ];

    // Get the new users count for the last week
    $newUsersCount = User::where('created_at', '>=', now()->subWeek())->count();

    // Get the total of paused ads
    $pausedAdsCount = Ad::where('status', 'paused')->count();

    // Get the total of paid payments (total of packs price for valid payments)
    $totalPaidPayments = DB::table('payments')
    ->join('ads', 'payments.ad_id', '=', 'ads.id')
    ->join('packs', 'ads.pack_id', '=', 'packs.id')
    ->where('payments.status', 'paid')
    ->sum('packs.price');
    $totalPaidPayments = (int) $totalPaidPayments;


    //Log::info('paymentLabels: ', ['paymentLabels' => $paymentLabels]); 
    return view('dashboard', compact('chartData', 'chartData2', 'newUsersCount', 'pausedAdsCount', 'totalPaidPayments'));

    }
    
}

