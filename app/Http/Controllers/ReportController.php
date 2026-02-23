<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function dashboard()
    {
        $today = date('Y-m-d');

        $todaySales = Sale::whereDate('date',$today)->where('status','PAID')->sum('grand_total');
        $todayCount = Sale::whereDate('date',$today)->where('status','PAID')->count();

        $lowStockCount = Product::where('current_stock','<=', DB::raw('stock_minimum'))->count();

        return view('reports.dashboard', compact('todaySales','todayCount','lowStockCount'));
    }

    public function salesSummary(Request $request)
    {
        $from = $request->query('from', date('Y-m-01'));
        $to = $request->query('to', date('Y-m-d'));

        $rows = Sale::select(
                DB::raw('date as day'),
                DB::raw('COUNT(*) as trx_count'),
                DB::raw('SUM(grand_total) as total')
            )
            ->where('status','PAID')
            ->whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->groupBy('day')
            ->orderBy('day','asc')
            ->get();

        return view('reports.sales_summary', compact('rows','from','to'));
    }

    public function bestSellers(Request $request)
    {
        $from = $request->query('from', date('Y-m-01'));
        $to = $request->query('to', date('Y-m-d'));

        $rows = SaleItem::select(
                'product_id',
                DB::raw('SUM(qty) as qty_total'),
                DB::raw('SUM(subtotal) as revenue_total')
            )
            ->whereHas('sale', function($q) use ($from,$to){
                $q->where('status','PAID')
                  ->whereDate('date','>=',$from)
                  ->whereDate('date','<=',$to);
            })
            ->groupBy('product_id')
            ->orderByDesc('qty_total')
            ->with('product')
            ->limit(20)
            ->get();

        return view('reports.best_sellers', compact('rows','from','to'));
    }

    public function profitSimple(Request $request)
    {
        $from = $request->query('from', date('Y-m-01'));
        $to = $request->query('to', date('Y-m-d'));

        // profit sederhana: (price - cost) * qty berdasarkan snapshot di sale_items
        $profit = SaleItem::whereHas('sale', function($q) use ($from,$to){
                $q->where('status','PAID')
                  ->whereDate('date','>=',$from)
                  ->whereDate('date','<=',$to);
            })
            ->select(DB::raw('SUM((price - cost) * qty) as profit_total'))
            ->value('profit_total') ?? 0;

        return view('reports.profit', compact('profit','from','to'));
    }

    public function lowStock()
    {
        $items = Product::with('category','unit')
            ->whereColumn('current_stock','<=','stock_minimum')
            ->orderBy('current_stock','asc')
            ->paginate(20);

        return view('reports.low_stock', compact('items'));
    }

    public function exportSalesCsv(Request $request)
    {
        $from = $request->query('from', date('Y-m-01'));
        $to = $request->query('to', date('Y-m-d'));

        $sales = Sale::where('status','PAID')
            ->whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->orderBy('date','asc')
            ->get();

        $filename = "sales_{$from}_{$to}.csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($sales){
            $out = fopen('php://output', 'w');
            fputcsv($out, ['date','invoice_no','grand_total','payment_method','status','created_by']);
            foreach($sales as $s){
                fputcsv($out, [$s->date, $s->invoice_no, $s->grand_total, $s->payment_method, $s->status, $s->created_by]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportLowStockCsv()
    {
        $items = Product::whereColumn('current_stock','<=','stock_minimum')
            ->orderBy('current_stock','asc')
            ->get();

        $filename = "low_stock.csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($items){
            $out = fopen('php://output', 'w');
            fputcsv($out, ['code','name','current_stock','stock_minimum']);
            foreach($items as $p){
                fputcsv($out, [$p->code, $p->name, $p->current_stock, $p->stock_minimum]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
