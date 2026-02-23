<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        // Today's revenue
        $todayRevenue = \App\Models\Sale::whereDate('date', $today)
            ->where('status', 'PAID')
            ->sum('grand_total');

        // This month's revenue
        $monthRevenue = \App\Models\Sale::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->where('status', 'PAID')
            ->sum('grand_total');

        // Today's sales count
        $todaySalesCount = \App\Models\Sale::whereDate('date', $today)
            ->where('status', 'PAID')
            ->count();

        // Low stock products (stock <= 10)
        $lowStockCount = \App\Models\Product::where('current_stock', '<=', 10)
            ->where('is_active', true)
            ->count();

        // Recent 5 transactions
        $recentSales = \App\Models\Sale::with('items.product')
            ->where('status', 'PAID')
            ->latest('date')
            ->latest('id')
            ->take(5)
            ->get();

        return view('dashboard', [
            'role' => $user->role,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'todaySalesCount' => $todaySalesCount,
            'lowStockCount' => $lowStockCount,
            'recentSales' => $recentSales,
        ]);
    }
}
