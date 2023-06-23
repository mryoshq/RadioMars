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

//REGISTRATION
//REGISTRATION
//REGISTRATION
    $userRegistrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(id) as count'))
        ->where('created_at', '>', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

    // Prepare labels and data for the chart
    $registrationLabels = $userRegistrations->pluck('date');
    $registrationData = $userRegistrations->pluck('count');

    $registrationChartData = [
        'labels' => $registrationLabels,
        'datasets' => [
            [
                'label' => 'User Registration',
                'data' => $registrationData,
                'fill' => false,
                'borderColor' => 'rgb(75, 192, 192)',
                'tension' => 0.1
            ]
        ],
    ];


// ADS
// ADS
// ADS
    // Get pack names, variations and the count of ads for each pack and its variation
    $packs = DB::table('ads')
        ->join('packs', 'ads.pack_id', '=', 'packs.id')
        ->select('packs.name', 'ads.pack_variation', DB::raw('count(ads.id) as ads_count'))
        ->orderBy('packs.name')
        ->orderBy('ads.pack_variation')

        ->groupBy('packs.name','ads.pack_variation')
        ->get();

    $packs2 = DB::table('ads')
        ->join('packs', 'ads.pack_id', '=', 'packs.id')
        ->leftJoin('payments', 'ads.id', '=', 'payments.ad_id')
        ->select('packs.name', 'ads.pack_variation', DB::raw('count(ads.id) as total_ads'), DB::raw('sum(case when payments.status = "paid" then 1 else 0 end) as paid_ads'))
        ->groupBy('packs.name', 'ads.pack_variation')
        ->get();

        $packs2->transform(function ($item) {
            $item->confirmation_rate = (int) ($item->paid_ads / $item->total_ads * 100);
            return $item;
        });
        

    // Prepare labels and data for the chart
    $labels = $packs->map(function ($pack) {
        return $pack->name  . $pack->pack_variation ;
    });
    $data = $packs->pluck('ads_count');

    // Define colors
    $colors = [
        '#F1C376', '#C8553D', '#F28F3B', '#606C5D', '#465362',
        // Add more colors if you have more variations
    ];

    $backgroundColor = [];
    foreach ($packs as $pack) {
        // Use pack_variation as index in the colors array, and use modulo to cycle back to the start when exceeding color count
        $backgroundColor[] = $colors[($pack->pack_variation - 1)];
    }

    $chartData = [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Pubs par Packs',
                'backgroundColor' => $backgroundColor,
                'hoverBackgroundColor' => '#F28F3B', // change this if you want different hover color
                'data' => $data,
            ],
        ],
    ];
 



      //  Log::info('Packs: ', ['packs' => $packs]);
  

      //Payments
      //Payments
      //Payments
        $payments = DB::table('payments')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

        // data
        $paymentData = $payments->pluck('count');

        // labels
        $paymentLabels = $payments->pluck('status');

        $colorMap = [
            'failed' => '#C8553D', 
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
        // Get the paid payments with their corresponding ad and pack data
        $paidPayments = Payment::where('status', 'paid')
        ->with(['ad.pack'])
        ->get();

        // Calculate the total sum
        $totalPaidPayments = 0;
        foreach ($paidPayments as $payment) {
        $packVariation = $payment->ad->pack_variation - 1;  // adjust for array index starting at 0
        $totalPaidPayments += $payment->ad->pack->price[$packVariation];
        (int) $totalPaidPayments;   
        }

        

        //Log::info('paymentLabels: ', ['paymentLabels' => $paymentLabels]); 
        return view('dashboard', compact('packs2','chartData', 'chartData2', 'newUsersCount', 'pausedAdsCount', 'totalPaidPayments', 'registrationChartData'));

    }
    
}

