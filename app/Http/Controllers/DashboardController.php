<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'backgroundColor' => '#F26202',
                    'data' => [15000, 5000, 10000, 15000, 10000, 20000],
                ],
            ],
        ];

        return view('dashboard', compact('data'));
    }
}

