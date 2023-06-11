<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



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
       // Log::info('Labels: ', ['labels' => $labels]);
        //Log::info('Data: ', ['data' => $data]);
        //Log::info('ChartData: ', ['chartData' => $chartData]);
        $payments = DB::table('payments')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    // data
    $paymentData = $payments->pluck('count');

    $chartData2 = [
        'labels' => ['annulé','en attente', 'payé'],
        

        'datasets' => [
            [
                'data' => $paymentData,
                'backgroundColor' => ['#FF6384', '#36A2EB', '#D0F5BE'], 
            ],
        ],
    ];
    //Log::info('paymentLabels: ', ['paymentLabels' => $paymentLabels]);
    return view('dashboard', compact('chartData', 'chartData2'));
    }
    
}

