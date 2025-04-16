<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Saless;
use App\Models\Customers;
use App\Models\DetailSales;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalProducts = Products::count();
        $totalMembers = Customers::count(); 
        $totalRevenue = Saless::sum('total_pay'); 

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $daysInMonth = Carbon::now()->daysInMonth;
        
        // Query for daily product quantities sold instead of revenue
        $dailyProductsSold = DetailSales::selectRaw('EXTRACT(DAY FROM created_at) as day, SUM(amount) as total')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->groupByRaw('EXTRACT(DAY FROM created_at)')
        ->orderBy('day')
        ->pluck('total', 'day')
        ->toArray();
    
    $salesData = [];
    $dayLabels = [];
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dayLabels[] = $i;
            // Convert day to string since pluck may create string keys
            $salesData[] = isset($dailyProductsSold[(string)$i]) ? $dailyProductsSold[(string)$i] : 
                          (isset($dailyProductsSold[$i]) ? $dailyProductsSold[$i] : 0);
        }
        
        $popularProducts = DetailSales::select('products.name', DB::raw('SUM(detail_sales.amount) as total_sold'))
            ->join('products', 'detail_sales.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
            
        $productNames = $popularProducts->pluck('name')->toArray();
        $productSaless = $popularProducts->pluck('total_sold')->toArray();

        return view('index', compact(
            'totalProducts', 
            'totalMembers', 
            'totalRevenue',
            'dayLabels',
            'salesData',
            'productNames',
            'productSaless'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
