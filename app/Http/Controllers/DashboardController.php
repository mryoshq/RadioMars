<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Ad;
use App\Models\Payment; 
use Carbon\Carbon;
use App\Models\Pack;
 
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
                    'label' => 'Nouveaux clients',
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
        
        // Get the maximum number of variations from the 'packs' table
        $maxVariation = Pack::max('variations');
        
        $colors = [
            '#F1C376', '#C8553D', '#F28F3B', '#606C5D', '#465362',
            // Add more colors if you have more variations
        ];
        
        $packNames = $packs->pluck('name')->unique();
        $labels = $packNames->values();
        
        $datasets = [];
        for ($variation = 1; $variation <= $maxVariation; $variation++) {
            $datasets[] = [
                'label' => 'Variation ' . $variation,
                'backgroundColor' => $colors[($variation - 1) % count($colors)],
                'data' => array_fill(0, $packNames->count(), 0),
            ];
        
            foreach ($packNames as $packName) {
                $packData = $packs->filter(function ($pack) use ($packName, $variation) {
                    return $pack->name == $packName && $pack->pack_variation == $variation;
                })->first();
        
                if ($packData) {
                    $index = $labels->search($packName);
                    $datasets[count($datasets) - 1]['data'][$index] = $packData->ads_count;
                }
            }
        }
        
        $chartData = [
            'labels' => $labels,
            'datasets' => $datasets,
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
        
        // Mapping for label translation
        $labelMap = [
            'failed' => 'échoué',
            'pending' => 'en attente',
            'paid' => 'payé',
        ];
        
        $backgroundColor = [];
        $translatedLabels = [];
        
        foreach ($paymentLabels as $label) {
            if (isset($colorMap[$label])) {
                $backgroundColor[] = $colorMap[$label];
            } else {
                $backgroundColor[] = '#000000'; // default color if the status is not found in the colorMap
            }
        
            if (isset($labelMap[$label])) {
                $translatedLabels[] = $labelMap[$label];
            } else {
                $translatedLabels[] = $label; // Keep original label if not found in labelMap
            }
        }
        
        $chartData2 = [
            'labels' => $translatedLabels,
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
                if ($payment->ad) {
                    $packVariation = $payment->ad->pack_variation - 1;  // adjust for array index starting at 0
                    $totalPaidPayments += $payment->ad->pack->price[$packVariation];
                }
                (int) $totalPaidPayments;   
            }

           
            $this->sendRecommendations();

            //Log::info('paymentLabels: ', ['paymentLabels' => $paymentLabels]); 
            return view('dashboard', compact('packs2','chartData', 'chartData2', 'newUsersCount', 'pausedAdsCount', 'totalPaidPayments', 'registrationChartData'));

        
    }
         


    //getting events for calendar
        public function getEvents() {
            $colors = ['red', 'blue', 'green', 'orange', 'purple', 'pink', 'yellow', 'cyan', 'magenta', 'lime'];
            $ads = Ad::where('programmed_for', '!=', null)
                        ->where('decision', 'accepted')
                        ->with(['pack']) // eager load the pack relations
                        ->get()
                        ->map(function ($ad) use ($colors) { // Make sure to pass $colors to the map function
                            return [
                                'title' =>  $ad->id,
                                'start' => Carbon::parse($ad->programmed_for)->format('Y-m-d'),
                                'packName' => $ad->pack->name,
                                'variation' => $ad->pack_variation,
                                'color' => $colors[$ad->pack->id % count($colors)], // Use modulo to map colors based on pack id
                                // More fields can go here if needed
                            ];
                        });
        
            return view('calendar', ['ads' => $ads]);
        }
        

        protected function generateRecommendations(){
            Log::info('Inside generateRecommendations');
        $recommendations = [];

        // Recommendation for "Accepted Ads with Failed Payment Status"
        $acceptedButFailedPayment = Ad::whereHas('payment', function ($query) {
            $query->where('status', 'failed');
        })->where('decision', 'accepted')->get();
        Log::info('$acceptedButFailedPayment:', ['count' => count($acceptedButFailedPayment)]);

        if (count($acceptedButFailedPayment) > 0) {
            $recommendations[] = "Il y a  " . count($acceptedButFailedPayment) . " publicitées acceptées mais le paiment à échouté";
        } 

        // Recommendation for "Paid Ads in Queue"
        $paidInQueue = Ad::whereHas('payment', function ($query) {
            $query->where('status', 'paid');
        })->where('decision', 'in_queue')->get();

        if (count($paidInQueue) > 0) {
            $recommendations[] = "Il y a  " . count($paidInQueue) . " publicités payées qui sont toujours en attente !!";
        }

        // Recommendation for "Paid Ads but Rejected"
        $paidButRejected = Ad::whereHas('payment', function ($query) {
            $query->where('status', 'paid');
        })->where('decision', 'rejected')->get();

        if (count($paidButRejected) > 0) {
            $recommendations[] = "Il y a " . count($paidButRejected) . " publicités payées qui ont été rejetées. Accorder une nouvelle chance.";
        }
        Log::info('$recommendations:', ['recommendations' => $recommendations]);
        Log::info($recommendations);
        return $recommendations;
    }

    public function sendRecommendations() 
    {
        $recommendations = $this->generateRecommendations();
        return view('recommendations', compact('recommendations'));
    }
    
        
}
